<?php

use Framer\Core\App\Helpers;
use Framer\Core\App\Session;
use Framer\Core\Model\EnvModel;
use Framer\Core\App\View;


if ( !function_exists('dump') ) {
    function dump($vars, $exit=true) {
        return Helpers::dump($vars, $exit);
    }
}


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

if ( !function_exists('flash') ) {
    function flash($key) {
        return Session::flash($key);
    }
}

if ( !function_exists('old') ) {
    function old($key) {
        return Session::flash('old_form_data_' . $key);
    }
}

if ( !function_exists('error') ) {
    function error($err) {
        return Session::flash('error_set_' . $err);
    }
}