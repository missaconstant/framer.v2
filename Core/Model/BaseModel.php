<?php

namespace Framer\Core\Model;

use Framer\Core\Model\DbManager;
use Framer\Core\Model\DbQueryFactory;
use Framer\Core\Exceptions\FramerException;
use Framer\Core\Useful\Classes\ObjectCollection;

class BaseModel
{
 
    /** @var array query datas */
    protected $__queryDatas = [
        "select" => ["*"]
    ];
    

    public function __construct($tablename=null) {

        !is_null($tablename) ? $this->table($tablename) : '';
        return $this;

    }


    /**
     * Return query datas
     * 
     * @return array query datas
     */
    public function getQuerydatas() {
        return $this->__queryDatas;
    }


    /**
     * Add table name to query
     * 
     * @param string the table name
     * 
     * @return ModelBase
     */
    public function table($tablename) {
        
        $this->__queryDatas['table'] = $tablename;
        return $this;
    }


    /**
     * Get table name
     * 
     * @return string table name
     */
    public function getTable() {
        return $this->__queryDatas['table'];
    }


    /**
     * Add selection to query
     * 
     * @param array|string selection
     * 
     * @return ModelBase
     */
    public function select($selection) {

        # remove the first (*)
        if ( $this->__queryDatas['select'][0] === '*' ) {
            unset($this->__queryDatas['select'][0]);
        }

        $datas = is_string($selection) ? explode(',', $selection) : $selection;
        $this->__queryDatas['select'] = array_merge($this->__queryDatas['select'], $datas);

        return $this;
    }


    /**
     * Where to search
     * 
     * @param string where string
     * @param string sign
     * 
     * @return BaseModel
     */
    public function where($wherestring, $sign='AND') {

        $finalString = [];

        if ( is_string($wherestring) ) {
            $finalString[] = $wherestring;
        }
        else if (is_array($wherestring)) {
            foreach ($wherestring as $k => $string) {
                if ( $string ) {
                    $finalString[] = count($string) > 1 ? $string[0] .' '. $string[1] : $string[0];
                }
            }
        }

        $finalString = implode(' ', $finalString);

        $this->__queryDatas['where'][] = [
            "str" => is_array($wherestring) ? "($finalString)" : $finalString,
            "sgn" => count($this->__queryDatas['where'] ?? []) === 0 ? '' : $sign
        ];

        return $this;
    }


    /**
     * Reinitialize all where clause and starts by a new one
     * 
     * @param string where string
     * @param sting sign
     * 
     * @return BaseModel
     */
    public function dropWhere($wherestring, $sign='AND') {

        $this->__queryDatas['where'] = [];
        return $this->where($wherestring, $sign);
    }


    /**
     * AND WHERE string
     * 
     * @param string where string
     * 
     * @return BaseModel
     */
    public function andWhere($wherestring) {

        $this->where($wherestring, 'AND');
        return $this;
        
    }


    /**
     * OR WHERE string
     * 
     * @param string where string
     * 
     * @return BaseModel
     */
    public function orWhere($wherestring) {

        $this->where($wherestring, 'OR');
        return $this;

    }

    /**
     * Group datas
     * 
     * @param string field to group on
     * 
     * @return BaseModel
     */
    public function groupBy($field) {

        $this->__queryDatas['groupby'] = $field;
        return $this;

    }


    /**
     * Ordering query
     * 
     * @param string field to order by
     * @param string order way
     * 
     * @return BaseModel
     */
    public function order($field, $way='ASC') {

        $this->__queryDatas['order'] = [ "by" => $field, "way" => $way ];
        return $this;

    }


    /**
     * Joins datas
     * 
     * @param string table to join
     * @param string joinning on
     * @param array field to take from joinning
     * 
     * @return BaseModel
     */
    public function join($what, $on, $takes=[]) {

        # adding join to queryDatas
        $this->__queryDatas['join'][] = [ "table" => $what, "chain" => $on, "select" => $takes ];

        return $this;

    }


    /**
     * Add prepared values
     * 
     * @param array params
     * 
     * @return BaseModel
     */
    public function arguments($args) {

        $this->__queryDatas['args'] = $args;
        return $this;

    }


    /**
     * Limits query result
     * 
     * @return void
     */
    public function limit($limit) {
        $this->__queryDatas['limit'] = $limit;
        return $this;
    }


    /**
     * Limits query result by some ranges
     * 
     * @param int page
     * @param int length
     * 
     * @return void
     */
    public function paginate($page, $length=10) {

        $from = (($page - 1) * $length);

        $this->__queryDatas['limit'] = "$from, $length";
        return $this;

    }


    /**
     * Compile query string from Query datas
     * 
     * @param string action to do
     * 
     * @return string SQL query string
     */
    public function compileQuery($action='get') {
        switch ($action) {
            case 'add':
                return DbQueryFactory::generateInsert($this);
                break;
            
            case 'set':
                return DbQueryFactory::generateUpdate($this);
                break;

            case 'del':
                return DbQueryFactory::generateDelete($this);
                break;

            default:
                return DbQueryFactory::generateSelect($this);
        }
    }


    /**
     * Create a model in database
     * 
     * @return mixed
     */
    public function create() {

        $vars = get_object_vars($this);
        unset($vars['__queryDatas']);

        return DbManager::executeQuery($this->compileQuery('add'), $vars, 'INSERT');
    }


    /**
     * Update a model in databse
     * 
     * @return mixed new model or false
     */
    public function update() {

        $vars = $this->toArray();

        # if id exists add it in where clause
        if ( empty($this->id) ) {
            throw new FramerException("Specifier l'ID de l'instance à mettre à jour.");
            return false;
        }

        $this->where('id=:id');

        # execute the query
        $ok = DbManager::executeQuery(self::compileQuery('set'), $vars);

        return $ok ? $this : false;
    }


    /**
     * Delete a model from databse
     * 
     * @param int id
     * 
     * @return bool
     */
    public function delete($id=null) {
        
        # fill object id with given id
        $this->id = $id ?? $this->id;
        
        # if id exists add it in where clause
        if ( empty($this->id) ) {
            throw new FramerException("Specifier l'ID de l'instance à supprimer");
            return false;
        }

        $this->where('id=' . $this->id);

        # execute the query
        $ok = DbManager::executeQuery(self::compileQuery('del'), null, 'DELETE');

        return $ok;
    }


    /**
     * Get an instance or a collection
     * 
     * @param int id
     * 
     * @return collection
     */
    public function get($id=null) {

        # fill object id with given id
        $this->id = $id ?? $this->id;

        # if id exists add it in where clause
        !empty($this->id) && $this->where($this->__queryDatas['table'] . '.id=' . $this->id);

        # get list
        $list = DbManager::executeQuery($this->compileQuery('get'));

        # to get one
        !empty($this->id) && $this->fill($this, $list[0] ?? []);

        # collection
        $collection = new ObjectCollection;

        if ( empty($this->id) ) {
            $class = get_class($this);

            foreach ($list as $key => $value) {
                $collection[] = $this->fill(new $class, $value);
            }
        }

        return !empty($this->id) ? (count($list) ? $this : false) : $collection;

    }


    public function getFirst() {
        return $this->limit([0, 1])->get()[0] ?? null;
    }


    /**
     * Fills object from given values
     * 
     * @param BaseModel
     * @param array values to fill with
     * 
     * @return BaseModel
     */
    public function fill(BaseModel $object, $values) {

        foreach ($values as $key => $value) {
            $object->{ $key } = $value;
        }

        return $object;
    }


    /**
     * Convert BaseModel into array
     * 
     * @return array
     */
    public function toArray() {

        $vars = get_object_vars($this);
        unset($vars['__queryDatas']);

        return $vars;

    }

}
