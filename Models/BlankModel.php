<?php

namespace Framer\Models;

use Framer\Core\Model\BaseModel;

class Blank extends BaseModel
{
    
    public $id;
    public $field1;
    public $field2;


    public function __construct() {
        parent::__construct('blank');
    }

}
