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
    static function removeDoubleSlash($string) {
        return preg_replace("#[/]+#", '/', $string);
    }


    /**
     * Check wether a string contains a word, strict way
     * 
     * @param string the string to search on
     * @param string the word to search in
     * 
     * @return bool
     */
    static function stringContainsWord($string, $word) {

        # search match words
        preg_match_all("#" . $word ."[\S]*#", $string, $matches);

        return in_array($word, $matches[0]);

    }


    /**
     * Dump variable
     * 
     * @param mixed - variable to dump
     * 
     * @return void
     */
    static function dump($var, $exit=false) {

        var_dump($var);
        $exit && exit();

    }


    /**
     * Get route from path or name
     * 
     * @param string the path or name
     * @param array values to include in route
     * 
     * @return string the route
     */
    static function route($pathorname, $vars=null) {

        $named = RouterStack::getRouteFromName( $pathorname );

        if ( $named && $named !== null ) {
            return Request::setProtocol() . self::removeDoubleSlash(Request::setBaseHost() .'/'. $named->getPath());
        }
        else {
            return Request::setProtocol() . self::removeDoubleSlash(Request::setBaseHost() .'/'. $pathorname);
        }
    }


    /**
     * Get file uri
     * 
     * @param string file path
     * 
     * @return string file uri
     */
    static function uri($filepath='') {
        return Request::setProtocol() . self::removeDoubleSlash(Request::setBaseHost() .'/'. $filepath);
    }


    /**
     * Get file path
     * 
     * @param string file path
     * 
     * @return string file path
     */
    static function path($filepath='') {
        return self::removeDoubleSlash(Request::setBasePath() .'/'. $filepath);
    }


    /**
     * Redirect to a route
     * 
     * @param string route path or name
     * 
     * @return void
     */
    static function redirect($pathorname) {
        header("Location: " . self::route($pathorname));
    }

}
