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
        
        # try simple route search
        $item = self::$stack[ $path ] ?? null;

        # try complex route search
        if ( empty($item) ) {
            $parm = [];

            foreach ( self::$stack as $k => $v ) {
                # getting GET keys
                $n = preg_match_all("#\{([a-z]+)\}#", $k, $matches);
                $n = $matches[1] ?? [];

                # replacing {xy} by regexp
                $k = preg_replace("#\{[a-z]+\}#", "([\S\s]+)", $k);
                
                if ( preg_match_all("#^$k$#", $path, $matches_2) ) {
                    $islonger = false;

                    for ( $i=0; $i<count($n); $i++ ) {
                        # ensure that route completely matches
                        # when a slash appears in a get value,
                        # then the query string is longer than the route path
                        if ( strpos($matches_2[$i+1][0], '/') ) {
                            $islonger = true;
                            break;
                        }
                        
                        # then match key to value
                        $parm[$n[$i]] = $matches_2[$i+1][0];
                    }

                    $item = $islonger ? null : $v;
                    !empty($item) && $item[$method]->setParams($parm);
                    break;
                }
            }
        }

        $route = $item !== null ? $item[$method] : null;

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
