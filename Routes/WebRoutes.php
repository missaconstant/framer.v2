<?php

namespace Framer\Routes;

use Framer\Core\Router\Route;
use Framer\Controllers\DefaultsController;
use Framer\Middlewares\DefaultsMiddleware;


/**
 * ------------------------
 * ---------WEB ROUTES-----
 * 
 * Here all the route that should be registered for web
 * Set your routes by method
 */


# route
Route::get('/', [ DefaultsController::class, 'index' ]);