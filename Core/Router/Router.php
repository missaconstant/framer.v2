<?php

namespace Framer\Core\Router;

use Framer\Core\Router\RouterStack;
use Framer\Core\Router\RouteInstance;

class Router
{

    /**
     * @method register
     * @param $path
     * @return 
     * 
     * register a route to stack
     */
    static function register($path, $method, $controller, $action) {

        $route = new RouteInstance($path, $method, $controller, $action);
        RouterStack::addRoute( $route );

        $route->_onNameGiven = function($r) {
            RouterStack::addNamed($r);
        };

        return $route;
    }


    /**
     * @method matchRoute
     * @param $path
     * @return RouterInstance
     * 
     * register a route to stack
     */
    static function matchRoute($path, $method) {
        return RouterStack::matchPath( $path, $method );
    }

}
