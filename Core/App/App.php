<?php

namespace Framer\Core\App;

use Framer\Core\App\Request;
use Framer\Core\Router\Router;
use Framer\Core\Exceptions\FramerException;
use Framer\Core\Exceptions\RouteNotFoundException;
use Framer\Core\Model\DbManager;
use Framer\Core\Model\EnvModel;

class App
{

    /**
     * @method start
     * @param $uri - path
     * starts app
     */
    static function start(Query $query) {

        # init session
        Session::init();

        # set the global error handler
        FramerException::handleErrors();

        # connect database
        $ENV = EnvModel::get();
        $ENV->use_db && DbManager::connect();

        # boot
        Bootstrap::boot();

        # get the route from uri
        $route = Router::matchRoute( $query->uri, $query->method );

        # check route
        if ( !$route ) {
            throw new RouteNotFoundException;
            return;
        }

        # mergin get params to  query object
        $query->get( $route->getParams() );
        $query->originalURI = $route->getPath();

        # execute route middlewares
        $middlewareReturns = [];

        foreach ($route->getMiddleWares() as $k => $middleware) {
            $r = $middleware::run( $query );
            $middlewareReturns = $r ? array_merge($middlewareReturns, $r) : $middlewareReturns;
        }

        # execute route action
        # passing queryObject and middlewares answers
        $route->getController()::{ $route->getAction() }( $query, (object) $middlewareReturns );

        # destroy session flash datas
        Session::destroyFlash();
    }

}
