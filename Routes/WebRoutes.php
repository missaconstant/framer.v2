<?php

namespace Framer\Routes;

use Framer\Core\Router\Route;
use Framer\Controllers\DefaultsController;


/**
 * ------------------------
 * ---------WEB ROUTES-----
 * 
 * Here all the route that should be registered for web
 * Set your routes by method
 */


# route
Route::get('/', [ DefaultsController::class, 'index' ]);
Route::get('/list/{add}/{id}/{ot}', [ DefaultsController::class, 'getOne' ]);
Route::post('/post/make', [ DefaultsController::class, 'make' ]);