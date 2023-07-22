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

    static function boot() {
        $env = EnvModel::get();
        $env->use_db && self::setDb($env);
    }
}
