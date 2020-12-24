<?php

namespace Framer\Core\App;

use Framer\Core\App\Request;
use Framer\Core\Router\RouterStack;

class Helpers
{
    
    /**
     * Removes multiple slashes from string
     * 
     * @param string - string containing slashes
     * 
     * @return string
     */
    function removeDoubleSlash($string) {
        return preg_replace("#[/]+#", '/', $string);
    }


    /**
     * Get route from path or name
     * 
     * @param string the path or name
     * @param array values to include in route
     * 
     * @return string the route
     */
    function route($pathorname, $vars=null) {

        $named = RouterStack::getRouteFromName( $pathorname );

        if ( $named && $named !== null ) {
            return Request::setProtocol() . self::removeDoubleSlash(Request::setBaseHost() .'/'. $named->getPath());
        }
        else {
            return Request::setProtocol() . self::removeDoubleSlash(Request::setBaseHost() .'/'. $pathorname);
        }
    }


    /**
     * Redirect to a route
     * 
     * @param string route path or name
     * 
     * @return void
     */
    function redirect($pathorname) {
        header("Location: " . self::route($pathorname));
    }

}
