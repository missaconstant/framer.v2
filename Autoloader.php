<?php
/**
* Simple autoloader, so we don't need Composer just for this.
*/
class Autoloader
{
    public static function register() {

        spl_autoload_register(function ($class) {

            $isfr = preg_match("#^Framer#", $class); // check if called class is from Framer namespace
            $file = $isfr ? str_replace('Framer\\', '', $class) : $class;
            $file = __DIR__ . ($isfr ? '/' : '/Vendors/') . str_replace('\\', DIRECTORY_SEPARATOR, $file).'.php';
            
            if (file_exists($file)) {
                require $file;
                return true;
            }
            
            return false;
            
        });

    }
}
Autoloader::register();