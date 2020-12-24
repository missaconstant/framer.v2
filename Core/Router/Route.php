<?php

namespace Framer\Core\Router;

use Framer\Core\Router\Router;

class Route
{
    
    /**
     * @method do
     * @param $method - query method
     * @param $path - the query path
     * @param $control - action array
     * Does the action according to query
     */
    static function do($method, $path, $control) {
        return Router::register($path, $method, $control[0], ($control[1] ?? 'index'));
    }


    /**
     * @method get
     * @param $path
     * @param $control
     */ 
    static function get($path, $control) {
        return self::do('get', $path, $control);
    }


    /**
     * @method post
     * @param $path
     * @param $control
     */ 
    static function post($path, $control) {
        return self::do('post', $path, $control);
    }


    /**
     * @method put
     * @param $path
     * @param $control
     */ 
    static function put($path, $control) {
        return self::do('put', $path, $control);
    }


    /**
     * @method delete
     * @param $path
     * @param $control
     */ 
    static function delete($path, $control) {
        return self::do('delete', $path, $control);
    }


    /**
     * @method patch
     * @param $path
     * @param $control
     */ 
    static function patch($path, $control) {
        return self::do('patch', $path, $control);
    }

}
