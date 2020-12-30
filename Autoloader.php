<?php
/**
* Simple autoloader, so we don't need Composer just for this.
*/
class Autoloader
{
    static $pathbase = __DIR__;
    static $fileIterator = null;


    /**
     * Register class call
     * 
     * @return bool
     */
    public static function register() {

        spl_autoload_register(function ($class) {

            $ENV = self::getConfigs();
            $spc = explode('\\', $class);
            $nsp = $spc[0];
            $cls = $spc[count($spc) - 1];
            $inc = $ENV->autoload_class[$nsp] ?? false;
            $typ = 'default';
            $pth = null;

            if ( $inc ) {
                $typ = $inc['type'];
                $pth = !empty($inc['path']) ? self::$pathbase .'/'. $inc['path'] : null;
            }

            switch ($typ) {
                case 'classmap':
                    return self::classmap($cls,  $pth);

                case 'pathfollow':
                case 'default':
                    return self::pathfollow($class, $pth);
            }
            
            return false;
            
        });

    }


    /**
     * Path follow loader
     * 
     * @param string class namestring
     * 
     * @return bool
     */
    static function pathfollow($class, $dir=null) {

        $isfr = preg_match("#^Framer#", $class);
        $dir  = $dir ?? ($isfr ? self::$pathbase : (self::$pathbase . '/Vendors/'));
        $file = $isfr ? str_replace('Framer\\', '', $class) : $class;
        $file = $dir .'/'. str_replace('\\', DIRECTORY_SEPARATOR, $file).'.php';
        
        if (file_exists($file)) {
            require $file;
            return true;
        }
    }


    /**
     * Class map autoloade
     * 
     * @param string class name
     * @param string mapping base directory
     * 
     * @return bool
     */
    public static function classmap($className, $dir=null)
    {

        $dir = $dir ?? self::$pathbase;
        $directory = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);

        if (is_null(static::$fileIterator)) {
            static::$fileIterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::LEAVES_ONLY);
        }

        $filename = $className . '.php';

        foreach (static::$fileIterator as $file) {
            if (strtolower($file->getFilename()) === strtolower($filename)) {
                if ($file->isReadable()) {
                    include_once $file->getPathname();
                }
                break;
            }
        }

    }


    /**
     * Get configs values
     * 
     * @param string key
     * 
     * @return array
     */
    public static function getConfigs($key=null) {

        $env = json_decode(file_get_contents(__DIR__ . '/Configs/autoloader.json'), true);
        return is_null($key) ? (object) $env : $env[$key];

    }
}

Autoloader::register();