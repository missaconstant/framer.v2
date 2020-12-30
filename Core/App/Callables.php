<?php

use Framer\Core\App\Helpers;
use Framer\Core\Model\EnvModel;
use Framer\Core\App\View;


if ( !function_exists('uri') ) {
    function uri($filepath) {
        return Helpers::uri($filepath);
    }
}

if ( !function_exists('path') ) {
    function path($filepath) {
        return Helpers::path($filepath);
    }
}

if ( !function_exists('route') ) {
    function route($pathorname, $vars=null) {
        return Helpers::route($pathorname, $vars);
    }
}

if ( !function_exists('redirect') ) {
    function redirect($pathorname) {
        return Helpers::redirect($pathorname);
    }
}

if ( !function_exists('view') ) {
    function view($viewpath, $vars=null, $layout=null) {
        View::load($viewpath, $vars, $layout, EnvModel::get('engine'));
    }
}

if ( !function_exists('assets') ) {
    function assets($path) {
        return uri('Assets/' . $path);
    }
}