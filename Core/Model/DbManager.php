<?php

namespace Framer\Core\Model;

use Framer\Core\Model\EnvModel;
use Framer\Core\Exceptions\DbException;
use Framer\Core\App\Helpers;

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
            self::$db = new \PDO($ENV->db_type . ':dbname=' . $ENV->db_name . '; host=' . $ENV->db_host, $ENV->db_user, $ENV->db_password, $pdo_options);
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

            return is_object($result) ? $result->fetchAll(\PDO::FETCH_OBJ) : $result;
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
