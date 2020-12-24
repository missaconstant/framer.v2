<?php

namespace Framer\Core\Model;

use Framer\Core\Model\EnvModel;
use Framer\Core\Exceptions\DbException;

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
            $pdo_options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION ;
            self::$db = new \PDO($ENV->db_type . ':db_name=' . $ENV->db_name . '; host=' . $ENV->db_host, $ENV->db_user, $ENV->db_password, $pdo_options) ;
            self::$db->exec("set names utf8");
        }
        catch (\Throwable $th) {
            throw new DbException($th->getMessage());
        }

        return self::$db;
    }


    /**
     * Executes a query string
     * 
     * @param string the query string
     * @param array datas to pass in query
     * 
     * @return mixed query result
     */
    static function executeQuery($queryString, $queryDatas=[]) {

        self::connect();
        $toPrepare = count($queryDatas);

        try {
            $query = $toPrepare ? self::$db->prepare($queryString) : self::$db->query($queryString);
            $result = $toPrepare ? $query->execute($queryDatas) : $query;

            return $result->fetchAll(\PDO::FETCH_OBJ);
        }
        catch (\Throwable $th) {
            throw new DbException($th->getMessage());
        }
    }

}
