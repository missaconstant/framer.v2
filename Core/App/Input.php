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
    static function setDataType($type='urlencoded') {
        $type = preg_match("#json#", $type) ? 'json' : 'urlencoded';
        self::$_post = $type === 'json' ? file_get_contents('php://input') : $_POST;
        self::$_files = $_FILES;
    }

    /**
     * @method post
     * @param $name
     */
    static function post($name, $secure=true) {
        return $secure ? htmlspecialchars(self::$_post[ $name ]) : self::$_post[ $name ];
    }

    /**
     * @method file
     * @param $name
     */
    static function file($name) {
        return self::$_files[ $name ];
    }

}
