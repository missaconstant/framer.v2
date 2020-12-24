<?php

namespace Framer\Core\Exceptions;

use Framer\Core\Exceptions\FramerException;

class Traces
{

    static $stack;

    static function addTrace(FramerException $exception) {
        self::$stack[] = $exception;
    }

}
