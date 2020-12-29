<?php

namespace Framer\Models;

use Framer\Core\Model\BaseModel;

class Book extends BaseModel
{
    
    public $id;
    public $title;
    public $reading;
    public $price;


    public function __construct() {
        parent::__construct('book');
    }

}
