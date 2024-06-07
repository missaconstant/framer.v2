<?php

use Framer\Core\App\Helpers;
use Framer\Core\App\Session;
use Framer\Core\Model\EnvModel as Env;
use Framer\Core\App\View;
use Framer\Core\App\Response;

if ( !function_exists('view') ) {
    function view($viewpath, $vars=[], $layout=null) {
        return View::load($viewpath, $vars, $layout, Env::$vars->engine);
    }
}

if ( !function_exists('dump') ) {
    function dump($vars, $exit=true, $toformat=false) {
        return Helpers::dump($vars, $exit, $toformat);
    }
}

if ( !function_exists('json_dump') ) {
    function json_dump($vars, $exit=true) {
        return Helpers::json_dump($vars, $exit);
    }
}

if ( !function_exists('f_session') ) {
    function f_session($key, $value=null) {
        if ($value) Session::set($key, $value);
        else { return Session::get($key); }
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

if ( !function_exists('response_success') ) {
    function response_success($message="", $content=[], $code=200) {
        return Response::jsonSuccess($message, $content, $code);
    }
}

if ( !function_exists('response_error') ) {
    function response_error($message="", $content=[], $code=500) {
        return Response::jsonError($message, $content, $code);
    }
}
