<?php

namespace Framer;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

# start sessions
session_start();

# mark execution time start
$tstart = microtime(true);

# app feature
use Framer\Core\App\App;
use Framer\Core\App\Query;
use Framer\Core\App\Request;
use Framer\Core\App\Response;
use Framer\Core\App\Session;
use Framer\Core\Exceptions\FramerException;
use Framer\Core\Router\Router;

# include the polyfills
require_once __DIR__ . '/Core/Useful/Polyfills/index.php';

# the autoloader
require_once __DIR__ . '/Vendors/autoload.php';

try {
    # callables
    require_once __DIR__ . '/Core/App/Callables.php';

    # start app
    App::start();

    # destroy session flash datas
    Session::destroyFlash();
}
catch (FramerException $e) {
    Response::code(500);
    Response::json($e->getErrors());
}

# mark execution time end
$tend = microtime(true) - $tstart;
