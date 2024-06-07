<?php

namespace Framer\Core\App;

use Framer\Core\Router\Router;
use Framer\Core\Exceptions\FramerException;
use Framer\Core\Model\EnvModel;

class App
{

    /**
     * @method start
     * @param $uri - path
     * starts app
     */
    static function start(): void {
        # init session
        Session::init();

        # set the global error handler
        FramerException::handleErrors();

        # init .env vars
        EnvModel::init();

        # init routes
        Router::init();

        # boot
        Bootstrap::boot();
    }

}
