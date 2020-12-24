<?php

namespace Framer\Core\App;

use Framer\Core\App\Request;
use Framer\Core\Router\Router;
use Framer\Core\Exceptions\RouteNotFoundException;
use Framer\Core\Exceptions\Traces;

class App
{
    
    /**
     * @method start
     * @param $uri - path
     * starts app
     */
    static function start(Query $query) {

        # get the route from uri
        $route = Router::matchRoute( $query->uri, $query->method );

        # check route
        if ( !$route ) {
            throw new RouteNotFoundException;
            return;
        }
        
        # execute route
        $route->getController()::{ $route->getAction() }( $query );
        
    }

}
