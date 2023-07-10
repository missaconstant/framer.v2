<?php

namespace Framer\Core\Model;

use Framer\Core\App\Helpers;
use Framer\Core\Model\EnvModel;
use Framer\Core\Exceptions\DbException;
use Framer\Core\Useful\Classes\ObjectCollection;

class DbManager
{

    /** @var PDO database connexion object */
    static $db = null;

    /**
     * Connect app to database
     *
     * @return void
     */
    static function connect() {

        # get .env vars
        $ENV = EnvModel::get();

        try {
            $pdo_options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;
            self::$db = new \PDO($ENV->db_driver . ':dbname=' . $ENV->db_name . '; host=' . $ENV->db_host, $ENV->db_user, $ENV->db_password, $pdo_options);
            self::$db->exec("set names utf8");
        }
        catch (\Throwable $th) {
            // throw new DbException($th->getMessage());
        }

        return self::$db;
    }


    /**
     * Check if db instance is setted
     *
     * @return boolean
     */
    static function isDb($throwError) {
        $isdb = !empty(self::$db);

        if (!$isdb && $throwError) {
            throw new DbException("Database connexion failed !");
            exit();
        }

        return $isdb;
    }


    /**
     * Get tables from db
     *
     * @return mixed table list
     */
    static function getTables() {

        if ( !self::$db ) return null;

        # get .env vars
        $ENV = EnvModel::get();

        $r = self::$db->query("SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA='$ENV->db_name'");
        $r = $r->fetchAll(\PDO::FETCH_OBJ);

        return $r;
    }


    /**
     * Get table's columns from db
     *
     * @return mixed columns list
     */
    static function getTableColumns($tablename) {

        if ( !self::$db ) return null;

        # get .env vars
        $ENV = EnvModel::get();

        $r = self::$db->query("SELECT * FROM information_schema.columns WHERE TABLE_SCHEMA='$ENV->db_name' AND TABLE_NAME='$tablename'");
        $r = $r->fetchAll(\PDO::FETCH_OBJ);

        return count($r) ? $r : null;
    }


    /**
     * Executes a query string
     *
     * @param string the query string
     * @param array datas to pass in query
     *
     * @return mixed query result
     */
    static function executeQuery($queryString, $queryDatas=[], $action=null) {

        self::isDb(true);

        $toPrepare = count($queryDatas ?? []);
        $queryDatas = self::sortDatasByQueryString($queryString, ($queryDatas ?? []));

        try {
            $query = $toPrepare ? self::$db->prepare($queryString) : self::$db->{ $action==='DELETE' ? 'exec' : 'query' }($queryString);
            $result = $toPrepare ? $query->execute($queryDatas) : $query;
            $result = $action === 'INSERT' ? self::$db->lastInsertId() : $result;

            $return = is_object($result) ?
                        new ObjectCollection($result->fetchAll(\PDO::FETCH_OBJ))
                        :
                        $result;

            return $return;
        }
        catch (\Throwable $th) {
            throw new DbException($th->getMessage());
        }
    }


    /**
     * Sorts query datas to keep only the needed
     *
     * @param array query datas
     *
     * @return array query datas without unecessary field
     */
    static function sortDatasByQueryString($queryString, $queryDatas) {

        $q = [];

        foreach ($queryDatas as $key => $value) {
            if ( Helpers::stringContainsWord($queryString, ":$key") ) {
                $q[$key] = $value;
            }
        }

        return $q;
    }

}
