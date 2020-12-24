<?php

namespace Framer\Core\Router;

use Framer\Core\Router\RouteInstance;

class RouterStack
{
    
    /**
     * @property $routes
     * Routes list
     */
    static $stack = [];
    static $named = [];

    
    /**
     * @method addRoute
     * @param $route - RouteInstance
     * add a route to the stack
     */
    static function addRoute(RouteInstance $route) {
        
        self::$stack[ $route->getPath() ][ $route->getMethod() ] = $route;
        $route->getName() !== $route->getPath() && self::addNamed($route);

    }


    /**
     * @method addNamed
     * @param $route - RouteInstance
     * add named route
     */
    static function addNamed(RouteInstance $route) {
        
        self::$named[ $route->getName() ] = (object) [
            "method" => $route->getMethod(),
            "path" => $route->getPath()
        ];
    }


    /**
     * @method matchPath
     * @param $path - the path
     * matches path to route
     */
    static function matchPath($path, $method) {

        $item = self::$stack[ $path ] ?? null;
        $route = $item !== null ? $item[ $method ] : null;

        return $route !== null ? $route : false;

    }


    /**
     * @method matchPath
     * @param $path - the path
     * matches path to route
     */
    static function matchNamed($name) {
        return self::$named[ $name ] ?? null;
    }


    /**
     * @method getPathFromName
     * @param $name - the name
     * get path from name
     */
    static function getRouteFromName($name) {

        $named = self::matchNamed($name);
        return $named !== null ? self::$stack[ $named->path ][ $named->method ] : false;

    }

}
