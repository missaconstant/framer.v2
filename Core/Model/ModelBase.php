<?php

namespace Framer\Core\Model;

class ModelBase
{
 
    /** @var array query datas */
    private $queryDatas = [];
    

    public function __construct($tablename=null) {

        !is_null($tablename) ? $this->table($tablename) : '';
        return $this;

    }


    /**
     * Add table name to query
     * 
     * @param string the table name
     * 
     * @return ModelBase
     */
    public function table($tablename) {
        
        $this->queryDatas['tablle'] = $tablename;
        return $this;
    }


    /**
     * Add selection to query
     * 
     * @param array|string selection
     * 
     * @return ModelBase
     */
    public function select($selection) {

        $datas = is_string($selection) ? explode(',', $selection) : $selection;
        $this->queryDatas['select'][] = $datas;

        return $this;
    }


    /**
     * Where to search
     * 
     * @param string where string
     * 
     * @return ModelBase
     */
    public function where($key, $value, $sign) {

        $this->queryDatas['where'] = $wherestring;
        return $this;
    }

}
