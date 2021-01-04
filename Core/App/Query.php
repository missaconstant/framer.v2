<?php

namespace Framer\Core\App;

use Framer\Core\App\Request;
use Framer\Core\App\Input;
use Framer\Core\App\Helpers;

class Query
{
    public $uri;
    public $basedir;
    public $method;
    public $headers;
    public $get;

    public function __construct() {

        # init request vals
        Request::init();

        $this->scriptname = Request::$scriptname;
        $this->method = Request::$method;
        $this->uri = Request::$uri;
        $this->basedir = Request::$basedir;
        $this->basepath = Request::$basepath;
        $this->host = Request::$host;
        $this->headers = Request::$headers;
        $this->get = [];

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
        return $this->post($name);
    }


    /**
     * @method post
     * @param $name
     * @return input value
     * Gets a form post value
     */
    public function post($name=null) {
        return !empty($name) ? Input::post( $name ) : Input::$_post;
    }
    

    /**
     * Get params
     * 
     * @param string key
     * @param mixed|null value to set for key
     * 
     * @return mixed|void
     */
    public function get($valsOrKey) {

        if ( is_array($valsOrKey) ){
            $this->get = array_merge($this->get, $valsOrKey);
            return;
        }
        else {
            return $this->get[$valsOrKey] ?? null;
        }

    }


    /**
     * @method header
     * @param $name
     * @return header
     */
    public function header($name) {
        return $this->headers[ $name ] ?? 'text';
    }

}
