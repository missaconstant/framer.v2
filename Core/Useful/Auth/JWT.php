<?php

namespace Framer\Core\Useful\Auth;

use Firebase\JWT\JWT as JWTJWT;
use Firebase\JWT\Key;
use Framer\Core\Exceptions\FramerException;
use Framer\Core\Model\EnvModel;
use Illuminate\Database\Eloquent\Model;

class JWT {
    static $configs = null;

    static $usermodel = null;

    /**
     * setUserModel
     *
     * @param $usermodel string users model
     *
     * @return void
     */
    static function setUserModel($usermodel=null) {
        self::$usermodel = !$usermodel ? (
            self::$usermodel ?? self::$configs->user_model_class
        ) : $usermodel;
    }

    /**
     * authentificate
     *
     * @param $username string user name - credentials
     * @param $password string user password - credentials
     *
     * @return \stdClass|null
     */
    static function authentificate($username, $password, $duration=0, $tostore=[]) {
        # get configs
        self::getConfigs();

        # default model
        self::setUserModel();

        if ( $user = self::findUserFromCred($username, $password) ) {
            $key = self::generateKey($username . $password);
            $pyd = array_merge([
                "user" => $user->id,
                "creation" => getdate()[0],
                "remote_addr" => $_SERVER['REMOTE_ADDR'],
                "expire_in" => $duration
            ], $tostore);
            $token = JWTJWT::encode($pyd, $key, self::$configs->jwt_algorithm);

            // update with key and token
            $user->{ self::$configs->user_key_field } = $key;
            $user->{ self::$configs->user_token_field } = $token;

            if ( $user->save() ) {
                return (object) ["token" => $token, "user" => $user];
            }
        }

        return null;
    }

    /**
     * trypass
     *
     * @param $token string json token
     *
     * @return \stdClass|null
     */
    static function trypass($token) {
        # configs
        $configs = self::getConfigs();

        # default model
        self::setUserModel();

        # find user from token
        $user = self::$usermodel::where("$configs->user_token_field", $token)->first();

        if ($user) {
            return JWTJWT::decode(
                $user->{ $configs->user_token_field },
                new Key($user->{ $configs->user_key_field }, $configs->jwt_algorithm)
            );
        }

        return null;
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
     * @param $username string user name - credentials
     * @param $password string user password - credentials
     *
     * @return Model
     */
    static function findUserFromCred($username, $password) {
        $configs = self::getConfigs();

        // instanciate user model and concerning user
        $user = self::$usermodel::where([
            "$configs->user_name_field" => $username,
            "$configs->user_password_field" => $password
        ])->first();

        return $user;
    }

    /**
     * getConfigs
     *
     * @return \stdClass
     */
    static function getConfigs() {
        self::$configs = self::$configs ?? EnvModel::get();
        return self::$configs;
    }


    /**
     * userModelGuard
     * @throws FramerException
     */
    static function userModelGuard() {
        if (!self::$usermodel)
            throw new FramerException("Model d'utilisateur introuvable.");
    }

}
