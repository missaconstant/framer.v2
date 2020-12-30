<?php

use Framer\Core\App\Helpers;
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
    function view($view, $vars=null, $layout=null, $useTemplate=true) {
        View::load($view, $vars, $layout, $useTemplate);
    }
}