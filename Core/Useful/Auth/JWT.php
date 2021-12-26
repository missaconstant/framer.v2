<?php

namespace Framer\Core\Useful\Auth;

use Firebase\JWT\JWT as JWTJWT;
use Firebase\JWT\Key;
use Framer\Core\Model\EnvModel;

class JWT {

    static $configs = null;
    static $usermodel = null;

    /**
     * setUserModel
     * 
     * @param usermodel the users model
     * 
     * @return void
     */
    static function setUserModel($usermodel) {
        self::$usermodel = $usermodel;
    }

    /**
     * authentificate
     * 
     * @param username the user name - credentials
     * @param password the user password - credentials
     * 
     * @return object | bool
     */
    static function authentificate($username, $password, $duration=0, $tostore=[]) {

        // get configs
        self::getConfigs();

        if ( $user = self::findUserFromCred($username, $password) ) {
            $key = self::generateKey($username . $password);
            $pyd = array_merge([
                "user" => $user->toArray(),
                "creation" => getdate()[0],
                "remote_addr" => $_SERVER['REMOTE_ADDR'],
                "expire_in" => $duration
            ], $tostore);
            $token = JWTJWT::encode($pyd, $key, self::$configs->jwt_algorithm);

            // update with key and token
            $user->{ self::$configs->user_key_field } = $key;
            $user->{ self::$configs->user_token_field } = $token;

            if ( $user->update() ) {
                return (object) ["token" => $token, "user" => $user];
            }
        }

        return false;
    }

    /**
     * trypass
     * 
     * @param token json token
     * 
     * @return boolean
     */
    static function trypass($token) {

        // configs
        $configs = self::getConfigs();

        // find user from token
        $user = new self::$usermodel;
        $user = $user->where("$configs->user_token_field='$token'")->getFirst();

        if ($user) {
            $payload = JWTJWT::decode(
                $user->{ $configs->user_token_field },
                new Key($user->{ $configs->user_key_field }, $configs->jwt_algorithm)
            );

            return $payload;
        }

        return false;
    }

    /**
     * generateKey
     * 
     * @return string
     */
    static function generateKey($string) {
        return hash('sha256', $string . date('YmdHis') . uniqid());
    }

    /**
     * findUserFromCred
     * 
     * @param username the user name - credentials
     * @param password the user password - credentials
     * 
     * @return StdClassObject
     */
    static function findUserFromCred($username, $password) {

        $configs = self::getConfigs();

        // instanciate user model and concerning user
        $user = new self::$usermodel;
        $user = $user->where("$configs->user_name_field='$username' AND $configs->user_password_field='$password'")->getFirst();

        return $user;
    }

    /**
     * getConfigs
     * 
     * @return StdClass
     */
    static function getConfigs() {
        self::$configs = self::$configs ?? EnvModel::get();
        return self::$configs;
    }

}