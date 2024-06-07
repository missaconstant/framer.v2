<?php

namespace Framer\Core\App;

use Framer\Core\App\Input;

/**
 * Session class
 */
class Session
{

    /** @var array flash datas array */
    static $flashdatas = [];


    /**
     * Initializing Session class
     * 
     * @return void
     */
    static function init() {

        # set old
        self::oldForm();

    }
    
    /**
     * Set a session index
     * 
     * @param string $key the key
     * @param mixed $value the value
     * 
     * @return void
     */
    static function set($key, $value) {
        $_SESSION[ $key ] = $value;
    }


    /**
     * Get a session index
     * 
     * @param string $key the key of data to retrieve
     * 
     * @return mixed|false
     */
    static function get($key) {
        return empty($key) ? $_SESSION : ($_SESSION[ $key ] ?? false);
    }


    /**
     * Destroy a session value
     * 
     * @param string $key index to remove from session
     * 
     * @return void
     */
    static function destroy($key) {
        
        if ( isset($_SESSION[$key]) ) {
            unset( $_SESSION[$key] );
        }

    }


    /**
     * Sets/gets a flash data which means that the data can be got at once
     * 
     * @param string $key
     * @param mixed|null $value
     * 
     * @return void|mixed
     */
    static function flash($key, $value=null) {

        if ( $value !== null ) {
            return self::set('flash_' . $key, $value);
        }
        else {
            $value = self::get( 'flash_' . $key );
            return $value;
        }

    }


    /**
     * Removes all flash datas
     * 
     * @return void
     */
    static function destroyFlash() {
        
        foreach( $_SESSION as $k => $v ) {
            if ( preg_match("#^flash#", $k) ) self::destroy($k);
        }

    }


    /**
     * Store post datas as old datas in session
     * 
     * @return void
     */
    static function oldForm($vals=null) {
        
        $vals = $vals ?? Input::$_post;

        if ( !empty($vals) ) {
            foreach ( $vals as $k => $v ) {
                self::flash("old_form_data_$k", $v);
            }
        }

    }


    /**
     * Store an error in session
     * 
     * @param array The error(s)
     * 
     * @return void
     */
    static function setError($err) {

        foreach ($err as $errname => $errmsg) {
            self::flash("error_set_$errname", $errmsg);
        }

    }


    /**
     * Ends a session and destroy all datas
     * 
     * @return void
     */
    static function end() {
        session_destroy();
    }

}
