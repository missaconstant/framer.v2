<?php

namespace Framer\Core\Useful\Classes;

class ObjectCollection extends \ArrayObject {

    public function __construct($initialObjects=[]) {
        parent::__construct( $initialObjects );
    }


    /**
     * Convert collection to readable array
     * 
     * @param $stdclassArray determine if should return an array of stdClassObject
     * 
     * @return Array
     */
    public function toArray($stdclassArray=false) {
        $nativeArray = new \ArrayObject;

        foreach ($this as $k => $object) {
            $objVars = get_object_vars($object);
            $nativeArray->append( $stdclassArray ? (object) $objVars : $objVars );
        }

        return $nativeArray->getArrayCopy();
    }


    /**
     * Convert collection to readable stdClassObject array
     * 
     * @return Array[StdClass]
     */
    public function toObjArray() {
        return $this->toArray(true);
    }

}