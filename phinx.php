<?php

$env = \Framer\Core\Model\EnvModel::get();

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/Configs/Database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/Configs/Database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => $env->db_driver,
            'host' => $env->db_host,
            'name' => $env->db_name,
            'user' => $env->db_user,
            'pass' => $env->db_password,
            'port' => '',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
