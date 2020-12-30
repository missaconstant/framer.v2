<?php

namespace Framer\Controllers;

use Framer\Core\App\Controller;
use Framer\Core\App\Query;

class DefaultsController extends Controller
{
    
    static function index(Query $query) {

        view('FramerViews/template', [ "name" => "Framer" ]);
    }

}
