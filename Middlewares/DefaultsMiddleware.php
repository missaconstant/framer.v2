<?php

namespace Framer\Middlewares;

use Framer\Core\App\Query;
use Framer\Core\Useful\Interfaces\MiddlewareInterface;

class DefaultsMiddleware implements MiddlewareInterface
{
    
    public function run(Query $query) {
        echo 'Am a middleware and you have to pass through me !';
        exit();
    }

}
