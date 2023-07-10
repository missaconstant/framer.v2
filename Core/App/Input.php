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

        self::$_post = $_POST;
        self::$_post = preg_match("#json#", $type) ? json_decode(file_get_contents('php://input'), true) : self::$_post;
        self::$_post = $type === 'put' ? (function () {
            (object) parse_str(file_get_contents('php://input'), $putDatas);
            return $putDatas;
        })() : self::$_post;
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

        $headers = getallheaders();
        $isjson = preg_match("#json#", (
            $headers['Content-Type'] ?? $headers['content-type']
        ));
        self::setDataType( $isjson ? 'json' : 'put');

        return self::post($name, $secure);

    }

    /**
     * @method file
     * @param $name
     */
    static function file($name=null) {
        return $name ? self::$_files[ $name ] : self::$_files;
    }

}
