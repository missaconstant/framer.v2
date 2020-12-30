<?php

namespace Framer\Controllers;

use Framer\Core\App\Controller;
use Framer\Core\App\Query;

class DefaultsController extends Controller
{
    
    /**
     * Index Page
     * 
     * @param Query query object
     * 
     * @return View
     */
    static function index(Query $query) {

        view('FramerViews/template', [ "name" => "Framer" ]);
    }

}
