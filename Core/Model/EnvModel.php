<?php

namespace Framer\Core\Model;

use Exception;

class EnvModel
{

    static $vars;
    
    /**
     * Get an .env value
     * 
     * @param string .env value key
     * 
     * @return mixed .env value
     */
    static function init() {
        if (file_exists(__DIR__ . '/../../Configs/.env')) {
            self::$vars = (object) parse_ini_file( __DIR__ . '/../../Configs/.env');
            return self::$vars;
        }
        throw new Exception("Cannot parse ./Configs/.env file.");
    }

}
