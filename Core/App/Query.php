<?php

namespace Framer\Core\App;

use Framer\Core\App\Input;
use Framer\Core\App\Helpers;

class Query
{
    public $uri;
    public $basedir;
    public $method;
    public $headers;
    public $get;
    public $originalURI;

    public function __construct($uribase='/') {

        $this->scriptname = Request::$scriptname;
        $this->method = Request::$method;
        $this->uri = Helpers::removeDoubleSlash(str_replace($uribase, "/", Request::$uri));
        $this->basedir = Request::$basedir;
        $this->basepath = Request::$basepath;
        $this->host = Request::$host;
        $this->headers = Request::$headers;
        $this->get = $_GET;

        # set content type
        Input::setDataType( $this->header('Content-Type') );

    }


    /**
     * @method input
     * @param $name
     * @return mixed value
     * Gets a form input value
     */
    public function input($name=null) {
        return $this->{ $this->method }($name);
    }


    /**
     * @method post
     * @param $name
     * @return input value
     * Gets a form post value
     */
    public function post($name=null) {
        return Input::post( $name );
    }


    /**
     * @method put
     * @param $name
     * @return input value
     * Gets a form post value
     */
    public function put($name=null) {
        return Input::put( $name );
    }


    /**
     * @method file
     * @param $name
     * @return input value
     * Gets a form post value
     */
    public function file($name=null) {
        return Input::file( $name );
    }
    

    /**
     * Get params
     * 
     * @param string key
     * @param mixed|null value to set for key
     * 
     * @return mixed|void
     */
    public function get($valsOrKey=null) {

        if ( is_array($valsOrKey) ){
            $this->get = array_merge($this->get, $valsOrKey);
            return;
        }
        else if ( is_null($valsOrKey) ) {
            return $this->get;
        }
        else if ( is_string($valsOrKey) ) {
            return $this->get[$valsOrKey] ?? null;
        }

    }


    /**
     * @method header
     * @param $name
     * @return header
     */
    public function header($name) {
        return $this->headers[ strtolower($name) ] ?? 'text';
    }

}
