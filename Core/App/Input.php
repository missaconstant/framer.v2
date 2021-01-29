<?php

namespace Framer\Core\App;

class Input
{
    static $_post;
    static $_files;

    /**
     * @method setDataType
     * @param $type - content type
     */
    static function setDataType($type='urlencoded', $method='') {

        self::$_post = $type === 'json' ? json_decode(file_get_contents('php://input')) : $_POST;
        self::$_post = $type === 'put' ? (function () {
            (object) parse_str(file_get_contents('php://input'), $putDatas);
            return $putDatas;
        })() : $_POST;
        self::$_files = $_FILES;

    }

    /**
     * @method post
     * @param $name
     * @param $secure
     */
    static function post($name=null, $secure=true) {
        return $name ? ($secure && is_string(self::$_post[ $name ]) ? htmlspecialchars(self::$_post[ $name ]) : self::$_post[ $name ]) : self::$_post;
    }

    /**
     * @method put
     * @param $name
     * @param $secure
     */
    static function put($name=null, $secure=true) {

        self::setDataType('put');
        return self::post($name, $secure);

    }

    /**
     * @method file
     * @param $name
     */
    static function file($name) {
        return self::$_files[ $name ];
    }

}
