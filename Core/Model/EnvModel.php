<?php

namespace Framer\Core\Model;

class EnvModel
{
    
    /**
     * Get an .env value
     * 
     * @param string .env value key
     * 
     * @return mixed .env value
     */
    static function get($key=null) {

        $env = parse_ini_file( __DIR__ . '/../../Configs/.env');
        return is_null($key) ? (object) $env : $env[$key];

    }

}
