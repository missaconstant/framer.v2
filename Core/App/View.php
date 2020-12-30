<?php

namespace Framer\Core\App;

use Framer\Core\App\Helpers;
use Framer\Core\Exceptions\FramerException;

class View
{
    
    /**
     * Load a view
     * 
     * @param string view name
     * @param string layout name
     * @param array values to extract in view
     * 
     * @return void
     */
    static function load($view, $vars=null, $layout=null, $useTemplate=true) {

        if ( $useTemplate ) {
            self::loadTemplate($view, $vars);
            exit();
        }

        $path = Helpers::path('Views/' . $view . '.php');

        # vars extraction
        is_array($vars) && extract($vars);

        # act by file
        if ( file_exists($path) ) {
            include_once $path;
        }
        else {
            throw new FramerException("Vue introuvable.");
        }

    }


    /**
     * load view with template
     * 
     * @param string template name
     * 
     * @return void
     */
    static function loadTemplate($template, $vars) {
        
        try {
            $latte = new \Latte\Engine;

            $latte->setTempDirectory(Helpers::path('Temp/Latte'));

            $params = $vars;

            # render to output
            $latte->render(Helpers::path('Views/'. $template .'.latte'), $params);
            
            # or render to string
            // $html = $latte->renderToString('template.latte', $params);
        }
        catch (\Throwable $th) {
            throw new FramerException("Template introuvable.");
        }

    }

}
