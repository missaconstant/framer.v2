<?php

namespace Framer\Controllers;

use Framer\Core\App\Query;
use Framer\Core\App\Helpers;
use Framer\Core\App\Response;
use Framer\Core\App\Session;
use Framer\Core\App\Controller;
use Framer\Core\Model\DbManager;

class DefaultsController extends Controller
{
    
    public function index(Query $query) {

        DbManager::connect();
        echo 'ok';
    }

}
