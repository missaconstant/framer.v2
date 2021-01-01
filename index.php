<?php

namespace Framer;

# start sessions
session_start();

# mark execution time start
$tstart = microtime(true);

# the autoloader
require_once __DIR__ . '/Autoloader.php';

# app feature
use Framer\Core\App\App;
use Framer\Core\App\Query;
use Framer\Core\App\Response;
use Framer\Core\App\Session;
use Framer\Core\Model\EnvModel;
use Framer\Core\Exceptions\FramerException;


try {
    # callables
    require_once __DIR__ . '/Core/App/Callables.php';

    # web routes
    require_once __DIR__ . '/Routes/WebRoutes.php';

    # Query
    $query = new Query();

    # start app
    App::start( $query );
}
catch (FramerException $e) {
    Response::code(500);
    Response::json($e->getErrors());
}

# mark execution time end
$tend = microtime(true) - $tstart;