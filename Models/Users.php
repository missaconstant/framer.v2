<?php

namespace Framer\Models;

use Framer\Core\Model\BaseModel;

class Users extends BaseModel
{
    
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;


    public function __construct() {
        parent::__construct('users');
    }

}
