<?php

namespace Framer\Core\App;

use Framer\Core\App\Request;
use Framer\Core\Router\RouterStack;

class Helpers
{
    
    /**
     * Removes multiple slashes from string
     * 
     * @param string - string containing slashes
     * 
     * @return string
     */
    static function removeDoubleSlash($string) {
        return preg_replace("#[/]+#", '/', $string);
    }
    
    /**
     * Removes last slashe from string
     * 
     * @param string - string containing slashe at end
     * 
     * @return string
     */
    static function removeEndSlash($string) {
        $isendslash = $string[ strlen($string) - 1 ] == '/';
        return strlen($string) > 1 && $isendslash ? substr($string, 0, strlen($string) - 1) : $string;
    }


    /**
     * Check wether a string contains a word, strict way
     * 
     * @param string the string to search on
     * @param string the word to search in
     * 
     * @return bool
     */
    static function stringContainsWord($string, $word) {

        # search match words
        $parts = explode($word, $string);
        return count($parts) > 1 ? true : false;

    }


    /**
     * Dump variable
     * 
     * @param mixed - variable to dump
     * 
     * @return void
     */
    static function dump($var, $exit=false, $toformat=false) {

        switch ($toformat) {
            case 'json':
                echo json_encode($var);
                break;

            case 'text':
                print_r($var);
                break;

            default:
                var_dump($var);
                break;
        }

        $exit && exit();

    }


    /**
     * Dump variable in json
     * 
     * @param mixed - variable to json dump
     * 
     * @return void
     */
    static function json_dump($var, $exit=false) {

        !is_array($var) && !is_object($var) && exit('Not jsonnizable');

        echo json_encode($var);
        $exit && exit();

    }
}
