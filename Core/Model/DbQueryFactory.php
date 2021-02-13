<?php

namespace Framer\Core\Model;

class DbQueryFactory
{
    
    static $queryString;


    /**
     * Compile where clause
     * 
     * @param array query datas: where
     * 
     * @return string where clause
     */
    static function compileWhere($qd_where=null, $qd_groupby=null) {
        $wh = [];
        $gr = '';

        # conditions
        foreach ( ($qd_where ?? []) as $k => $v ) {
            $v = (object) $v;
            $wh[] = $v->sgn . ' ' . $v->str;
        }

        # group by
        $gr = $qd_groupby ? " GROUP BY $qd_groupby" : '';

        return (count($wh) ? 'WHERE ' . implode(' ', $wh) : '') . $gr;
    }


    /**
     * generate SELECT query
     * 
     * @param BaseModel model to work on
     * 
     * @return string the query string
     */
    static function generateSelect(BaseModel $object) {

        $qd = $object->getQueryDatas();
        $qs = '';


        # PART 1: compile select part
        $sl = [];

        foreach ( ($qd['select'] ?? []) as $k => $v ) {
            $v = explode(':', trim($v));
            $prefix = preg_match("#[\S]+\.[\S]+#", $v[0]) || preg_match("#^[\S]+\([\S]+\)$#", $v[0]) ? '' : $qd['table'] . '.';
            $sl[] = ($prefix . $v[0]) . (isset($v[1]) ? ' AS ' . $v[1] : '');
        }


        # PART 2: Joinning
        $jns = [];
        $slc = [];

        foreach ( ($qd['join'] ?? []) as $k => $v ) {
            $v = (object) $v;

            # add joinning
            $jns[] = 'LEFT JOIN ' . $v->table .' ON '. $v->chain;

            # add fields to take from joinning
            foreach ( ($v->select ?? []) as $kk => $field ) {
                $select = explode(':', $field);
                $slc[] = count($select) > 1 ? 
                    (preg_match("#^[\S]+\([\S]+\)$#", $v[0]) ? '' : $v->table .'.') . $select[0] .' AS '. $select[1]
                :
                    $v->table .'.'. $select[0] .' AS '. $v->table .'_'. $select[0]
                ;
            }
        }

        # merge selected and joinned
        $sl = array_merge($sl, $slc);
        $sl = 'SELECT ' . implode(',', $sl);


        # PART 3: Where
        $wh = self::compileWhere( $qd['where'], ($qd['groupby'] ?? null) );


        # PART 4: order
        $od = isset($qd['order']) ? 'ORDER BY ' . $qd['order']['by'] . ' ' . $qd['order']['way'] : '';


        # PART 5: limit
        $lt = !isset($qd['limit']) ? '' : 'LIMIT ' . (is_array($qd['limit']) ? $qd['limit'][0] : $qd['limit']) . (is_array($qd['limit']) && isset($qd['limit'][1]) ? ',' . $qd['limit'][1] : '');


        # LAST PART: compile whole string
        $qs = $sl . ' FROM ' .$qd['table'] . ' ' . implode(' ', $jns) . ' ' . $wh . ' ' . $od . ' ' . $lt;
        
        return $qs;
    }


    /**
     * Generate INSERT INTO query
     * 
     * @param BaseModel model to work on
     * 
     * @return string query string
     */
    static function generateInsert(BaseModel $object) {

        $vars = array_keys(get_class_vars( get_class($object) ));

        $dotvars = array_map(function ($item) {
            return ':' . $item;
        }, $vars);

        $strg = 'INSERT INTO ' . $object->getTable() . '(' . implode(',', $vars) . ') VALUES('. implode(',', $dotvars) .')';
        
        return $strg;
    }


    /**
     * Generate UPDATE query
     * 
     * @param BaseModel model to work on
     * 
     * @return string query string
     */
    static function generateUpdate(BaseModel $object) {

        # getting object structure
        $vars = array_keys(get_class_vars( get_class($object) ));

        # getting query datas
        $qd = $object->getQueryDatas();

        # creating double dotted vals
        $dotvars = array_map(function ($item) use ($object) {
            if ( $item !== 'id' && !is_null($object->{ $item }) )
                return $item . '=:' . $item;
        }, $vars);

        # remove null
        $dotvars = array_filter($dotvars, function ($item) { return !is_null($item); });

        # where clause
        $wh = self::compileWhere($qd['where']);

        $strg = 'UPDATE ' . $object->getTable() . ' SET ' . implode(',', $dotvars) . ' ' . $wh;

        return $strg;
    }


    /**
     * Generate DELETE query
     * 
     * @param BaseModel model to delete
     * 
     * @return string query string
     */
    static function generateDelete(BaseModel $object) {

        # getting query datas
        $qd = $object->getQueryDatas();

        # where clause
        $wh = self::compileWhere($qd['where']);

        $strg = 'DELETE FROM ' . $object->getTable() . ' ' . $wh;

        return $strg;
    }

}
