<?php

namespace Framer\Controllers;

use Framer\Core\App\Query;
use Framer\Core\App\Helpers;
use Framer\Core\App\Response;
use Framer\Core\App\Session;
use Framer\Core\App\Controller;
use Framer\Core\Model\BaseModel;
use Framer\Models\Book;

class DefaultsController extends Controller
{
    
    static function index(Query $query) {

        // $model = new Book;
        // $model->title = "Leuk le Lièvre 2";
        // $model->reading = 0;
        // $model->price = 15.99;

        // Response::json( $model->create() );

        // $model = new Book;
        // Response::json($model->get());

        $model = new Book;
        $model->id = 3;
        Response::json($model->delete());
    }

}
