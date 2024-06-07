<?php

namespace Framer\Core\Useful\Interfaces;

use Framer\Core\App\Query;

interface MiddlewareInterface {

    /**
     * Runs the middleware
     *
     * @param Query The query object
     * @param StdClass middle data from previous middlewares called
     *
     * @return void
     */
    public function run($middles);

}
