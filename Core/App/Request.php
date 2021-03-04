<?php

namespace Framer\Core\App;

use Framer\Core\App\Helpers;

class Request
{
    
    static $uri;
    static $scriptname;
    static $method;
    static $basedir;
    static $basepath;
    static $protocol;
    static $host;
    static $basehost;
    static $headers;
    static $inited;


    /**
     * Init the class static properties
     * 
     * @return void
     */
    static function init() {

        if ( self::$inited ) return true;

        self::$scriptname = $_SERVER['SCRIPT_NAME'];
        self::$method = strtolower($_SERVER['REQUEST_METHOD']);
        self::$uri = self::setURI();
        self::$basedir = self::setBaseDir();
        self::$basepath = self::setBasePath();
        self::$protocol = self::setProtocol();
        self::$host = self::setHost();
        self::$basehost = self::setBaseHost();
        self::$headers = getallheaders();
        self::$inited = true;

    }


    /**
     * set request correct URI
     * 
     * @return string the correct uri
     */
    static function setURI($ignoreQueryString=true) {
        $uri = '';

        # when online: means not in php internal server
        if ( isset($_SERVER['BASE']) ) {
            $base = $_SERVER['BASE'] === '/' ? null : $_SERVER['BASE'];
            $uri = '/' . str_replace(Helpers::removeDoubleSlash($base), '', Helpers::removeDoubleSlash($_SERVER['REQUEST_URI']));
        }
        # if in
        else {
            if ( isset($_SERVER['PATH_INFO']) ) {
                $uri = $_SERVER['PATH_INFO'];
            }
            else {
                $uri = '/';
            }
        }

        # remove query string part
        if ($ignoreQueryString) {
            $uri = preg_replace("#\?[\s\S]+$#", "", $uri);
        }

        return Helpers::removeEndSlash(Helpers::removeDoubleSlash($uri));
    }


    /**
     * Get app base dir
     * 
     * @return string base path directory
     */
    static function setBaseDir() {
        return preg_split("#/[A-Z0-0\-_]+.php#i", $_SERVER['PHP_SELF'])[0];
    }


    /**
     * Get host
     * 
     * @return string http host
     */
    static function setHost() {
        return $_SERVER['HTTP_HOST'];
    }


    /**
     * Get http protocol
     * 
     * @return string http protocol
     */
    static function setProtocol() {
        return ($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://';
    }


    /**
     * Get the base host with host and base directory
     * 
     * @return string base host uri ex: host/basedir
     */
    static function setBaseHost() {
        return (self::$host ?? self::setHost())  . '/' . (self::$basedir ?? self::setBaseDir());
    }

    
    /**
     * Get app base path
     * 
     * @return string the app base path
     */
    static function setBasePath() {
        return Helpers::removeDoubleSlash($_SERVER['DOCUMENT_ROOT'] . self::setBaseDir());
    }


    // /**
    //  * Get app ROOT path
    //  * 
    //  * @return string root path
    //  */
    // static function setRootPath() {
    //     return str_replace('/index.php', '', $_SERVER['SCRIPT_FILENAME']);
    // }

}
