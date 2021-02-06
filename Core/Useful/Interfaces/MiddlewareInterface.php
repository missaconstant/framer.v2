<?php

namespace Framer\Core\Useful\Interfaces;

use Framer\Core\App\Query;

interface MiddlewareInterface {

    /**
     * Runs the middleware
     * 
     * @param Query The query object
     * 
     * @return void
     */
    public function run(Query $query);

}