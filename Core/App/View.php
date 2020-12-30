<?php

namespace Framer\Core\App;

use Framer\Core\App\Helpers;
use Framer\Core\Exceptions\FramerException;
use Framer\Core\App\Templater;

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
    static function load($viewpath, $vars=null, $layout=null, $useTemplate='default') {
    
        switch ( $useTemplate ) {
            case 'latte':
                Templater::latte($viewpath, $vars);
                break;

            default:
                Templater::default($viewpath, $vars, $layout);
                break;
        }
        
        return;
    }

}
