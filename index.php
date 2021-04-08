<?php

namespace Framer;

# start sessions
session_start();

# mark execution time start
$tstart = microtime(true);

# include the polyfills
require_once __DIR__ . '/Core/Useful/Polyfills/index.php';

# the autoloader
require_once __DIR__ . '/Autoloader.php';

# app feature
use Framer\Core\App\App;
use Framer\Core\App\Query;
use Framer\Core\App\Request;
use Framer\Core\App\Response;
use Framer\Core\App\Session;
use Framer\Core\Model\EnvModel;
use Framer\Core\Exceptions\FramerException;


try {
    # callables
    require_once __DIR__ . '/Core/App/Callables.php';
    
    # init request vals
    Request::init();

    # add routes
    $base = '/';

    if ( $folder = opendir(__DIR__ . '/Routes') ) {
        while ( false !== ($entry = readdir($folder)) ) {
            $b = '';
            
            if ( preg_match("#^[A-Za-z0-9]+Routes#i", $entry) && is_file(__DIR__ . '/Routes/' . $entry) ) {
                $b = str_replace("routes.php", "", ucfirst(strtolower($entry)));

                if ( preg_match("#^/$b#i", Request::$uri) ) {
                    $base = strtolower("/$b");

                    require_once __DIR__ . '/Routes/' . $entry;
                    break;
                }
            }
        }
        
        closedir($folder);
        $base === '/' && require_once __DIR__ . '/Routes/WebRoutes.php';
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