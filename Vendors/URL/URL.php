<?php

/**
 * URL class
 * @author ATOMIXIAN
 * @license TESTLICENCE 1.0 (:D)
 */

namespace URL;

class URL
{

    /** @var CURLObject */
    private static $ch;

    /**
     * Initialization method
     * 
     * @param string | request type
     * @param string | target path
     * @param array  | request datas for post
     * 
     * @return void
     */
    private static function init($type, $route, $datas=[]) {

        $stringed = $datas ? http_build_query($datas) : '';

        self::$ch = curl_init();

        curl_setopt(self::$ch, CURLOPT_URL, $route . ($type=='get' && strlen(trim($stringed)) ? '?' . $stringed : ''));
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, false);

        if (strtolower($type) == 'post') {
            curl_setopt(self::$ch, CURLOPT_POST, 1);
            curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $stringed);
        }

    }

    /**
     * Execute the request
     * 
     * @return string | http answer
     */
    private static function execute() {

        try {
            $response = curl_exec(self::$ch);
            curl_close(self::$ch);
            return $response;
        }
        catch (Exception $e) {
            die($e->getMessage());
        }

    }

    /**
     * Post method to send POST datas
     * 
     * @param string  | target path
     * @param array   | datas to send
     * 
     * @return string | http response
     */
    public static function post($route, $datas) {
        return self::do('post', $route, $datas);
    }

    /**
     * Get method to send GET datas
     * 
     * @param string  | target path
     * @param array   | datas to send
     * 
     * @return string | http response
     */
    public static function get($route, $datas=false) {
        return self::do('get', $route, $datas);
    }

    /**
     * Do method to send GET or POST datas
     * 
     * @param string  | query type
     * @param string  | target path
     * @param array   | datas to send
     * 
     * @return string | http response
     */
    public static function do($type, $route, $datas=[]) {

        self::init($type, $route, $datas);
        return self::execute();

    }
}
