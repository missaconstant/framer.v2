<?php

namespace Framer\Core\App;

/**
 * Session class
 */
class Session
{
    
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
            return self::set($key, $value);
        }
        else {
            $value = self::get( $key );
            self::destroy( $key );

            return $value;
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
