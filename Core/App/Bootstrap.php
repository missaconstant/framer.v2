<?php
namespace Framer\Core\App;

use Framer\Core\Model\EnvModel;
use Illuminate\Database\Capsule\Manager as Capsule;

class Bootstrap {

    static function setDb($env) {
        $capsule = new Capsule;

        $capsule->addConnection([
            "driver" => $env->db_driver,
            "host" => $env->db_host,
            "database" => $env->db_name,
            "username" => $env->db_user,
            "password" => $env->db_password,
            'charset' => $env->db_charset ?? 'utf8mb4',
            'collation' => $env->db_collation ?? 'utf8mb4_unicode_ci'
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }


    static function handlePreFlight(Query $query) {
        if($query->method === 'options') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Max-Age: 60');
            header('Access-Control-Allow-Headers: *');
            header("HTTP/1.1 200 OK");
            die();
        }
    }


    static function boot() {
        # get env vars
        $env = EnvModel::get();

        # init db
        $env->use_db && self::setDb($env);

        # init Logger
        Logger::init();
    }
}
