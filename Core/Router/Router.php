<?php

namespace Framer\Core\Router;

use MiladRahimi\PhpRouter\Router as PhpRouterRouter;

class Router
{

    static function init() {
        $router = PhpRouterRouter::create();

        if ( $folder = opendir(__DIR__ . '/../../Src/Routes') ) {
            while ( false !== ($entry = readdir($folder)) ) {
                if ( preg_match("#Routes.php$#i", $entry) ) {
                    $name = strtolower(str_replace("Routes.php", "", $entry));
                    
                    if ($name !== 'web') {
                        $router->group(['prefix' => "/$name"], function (PhpRouterRouter $router) use ($entry) {
                            include_once __DIR__ . '/../../Src/Routes/' . $entry;
                        });
                    }
                    else {
                        include_once __DIR__ . '/../../Src/Routes/' . $entry;
                    }
                }
            }
            closedir($folder);
        }

        $router->dispatch();
    }

}
