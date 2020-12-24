<?php

namespace Framer\Core\App;

class Response
{
    
    /**
     * @method code
     * @param $code
     * @param $note
     * Return an answer code
     */
    static function code($code=200, $note='') {

        header("HTTP/1.1 $code" . (strlen($note) ? " $note" : ""));

    }

    /**
     * @method type
     * @param $content_type
     * @return void
     * Sets content type
     */
    static function type($content_type='text/html; charset=UTF-8') {
        header("Content-Type: $content_type");
    }

    /**
     * @method json
     * @param $content
     * Return a json answer
     */
    static function json($content, $exit=true) {
        self::type('application/json');
        echo json_encode( $content );
        $exit && exit();
    }

    /**
     * @method jsonAnswer
     * @param $error
     * @param $message
     * @param $content
     */
    static function jsonAnswer($error=true, $message="", $content=[]) {
        return self::json(array_merge([ "error" => $error, "message" => $message ], $content));
    }

    /**
     * @method jsonSuccess
     * @param $message
     * @param $content
     */
    static function jsonSuccess($message="", $content=[]) {
        return self::jsonAnswer(false, $message, $content);
    }

    /**
     * @method jsonError
     * @param $message
     * @param $content
     */
    static function jsonError($message="", $content=[]) {
        return self::jsonAnswer(true, $message, $content);
    }

}
