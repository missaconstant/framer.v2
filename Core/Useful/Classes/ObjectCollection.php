<?php

namespace Framer\Core\Useful\Classes;

class ObjectCollection extends \ArrayObject {

    public function __construct($initialObjects=[]) {
        parent::__construct( $initialObjects );
    }


    /**
     * Convert collection to readable array
     * 
     * @return Array
     */
    public function toNativeArray() {
        $nativeArray = new \ArrayObject;

        foreach ($this as $k => $object) {
            $nativeArray->append( get_object_vars($object) );
        }

        return $nativeArray;
    }

}