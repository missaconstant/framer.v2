<?php
/**
* Simple autoloader, so we don't need Composer just for this.
*/
class Autoloader
{
    public static function register() {

        spl_autoload_register(function ($class) {

            $file = str_replace('Framer\\', '', $class);
            $file = __DIR__ . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $file).'.php';
            
            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
            
        });

    }
}
Autoloader::register();