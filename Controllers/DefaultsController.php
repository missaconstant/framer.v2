<?php

namespace Framer\Controllers;

use Framer\Core\App\Controller;
use Framer\Core\App\Query;
use Framer\Core\App\Helpers;
use Framer\Core\App\Session;
use Framer\Core\App\Response;

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


    static function getOne(Query $query) {
        Response::json($query->get('add'));
    }


    static function make(Query $query) {

        $book = new \Framer\Models\Book;
        $book->id = 14;
        $book->title = 'Leuk la founie 5';
        $book->reading = 0;
        $book->price = 10.00;

        var_dump($book->delete());

    }

}
