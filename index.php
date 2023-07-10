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
use Framer\Core\App\Bootstrap;
use Framer\Core\App\Query;
use Framer\Core\App\Request;
use Framer\Core\App\Response;
use Framer\Core\Exceptions\FramerException;

# include the polyfills
require_once __DIR__ . '/Core/Useful/Polyfills/index.php';

# the autoloader
require_once __DIR__ . '/Vendors/autoload.php';

try {
    # callables
    require_once __DIR__ . '/Core/App/Callables.php';

    # init request vals
    Request::init();

    # add routes
    $base = '/';

    if ( $folder = opendir(__DIR__ . '/Src/Routes') ) {
        while ( false !== ($entry = readdir($folder)) ) {
            $b = '';

            if ( preg_match("#^[A-Za-z0-9]+Routes#i", $entry) && is_file(__DIR__ . '/Src/Routes/' . $entry) ) {
                $b = str_replace("routes.php", "", ucfirst(strtolower($entry)));

                if ( preg_match("#^/$b#i", Request::$uri) ) {
                    $base = strtolower("/$b");

                    require_once __DIR__ . '/Routes/' . $entry;
                    break;
                }
            }
        }

        closedir($folder);
        $base === '/' && require_once __DIR__ . '/Src/Routes/WebRoutes.php';
    }

    # Query
    $query = new Query( $base );

    # start app
    App::start( $query );
}
catch (FramerException $e) {
    Response::code(500);
    Response::json($e->getErrors());
}

# mark execution time end
$tend = microtime(true) - $tstart;
