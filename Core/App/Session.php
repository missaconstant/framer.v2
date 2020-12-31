<?php

namespace Framer\Core\App;

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

        # removes all flash
        self::removeFlash();

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
        return $_SESSION[ $key ] ?? false;
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
            self::$flashdatas[$key] = $value;
            return self::set($key, $value);
        }
        else {
            $value = self::get( $key );
            unset(self::$flashdatas[$key]);
            self::destroy( $key );

            return $value;
        }

    }


    /**
     * Removes all flash datas
     * 
     * @return void
     */
    static function removeFlash() {

        foreach( self::$flashdatas as $k => $v ) {
            self::destroy($k);
        }

    }


    static function oldForm() {

        if ( empty($key) ) {
            $vals = Input::input();

            foreach ( $vals as $k => $v ) {
                self::flash("old_form_data_$k", $v);
            }
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
