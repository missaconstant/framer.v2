<?php

namespace Framer\Core\App;

use Framer\Core\App\Helpers;
use Framer\Core\Exceptions\FramerException;
use Latte\Engine;

class Templater
{

    /** @var string base directory */
    static $basedir = __DIR__ . '/../../views/';


    /**
     * Default view loader : no template engin
     *
     * @param string view path
     * @param mixed variable to extract in
     * @param string layout path
     *
     * @return void
     */
    static function default($view, $vars=[], $layout=null) {

        // $path = Helpers::path('Views/' . $view . '.php');

        # vars extraction
        // is_array($vars) && extract($vars);

        # act by file
        // if ( file_exists($path) ) {
        //     include_once $path;
        // }
        // else {
        //     throw new FramerException("Vue introuvable.");
        // }

        // return;
    }


    /**
     * Latte : template engin
     *
     * @param string view path
     * @param mixed variable to extract in
     * @param string layout path
     *
     * @return void
     */
    static function latte($viewpath, $vars) {

        try {
            # get the latte engine
            $latte = new Engine();

            # setting temp path
            $latte->setTempDirectory(__DIR__ . '/../../Temp/Latte');

            # render to output
            return $latte->renderToString(__DIR__ . '/../../Src/Views/'. $viewpath .'.latte', $vars);
        }
        catch (\Exception $e) {
            throw new FramerException("Template introuvable.");
        }
    }

}
