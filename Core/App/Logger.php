<?php

namespace Framer\Core\App;

use Katzgrau\KLogger\Logger as LogR;

class Logger {

    static $logdir = __DIR__.'/../../Temp/Logs';

    static $instance = null;

    static function init($new_dir=null) {
        if (!self::$instance || $new_dir) {
            self::$instance = new LogR($new_dir ?? self::$logdir);
        }
    }

    static function info($log) {
        self::$instance->info($log);
    }

    static function error($log) {
        self::$instance->error($log);
    }

    static function debug($log, $data) {
        self::$instance->debug($log, $data);
    }

}
