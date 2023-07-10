<?php

namespace Framer\Routes;

use Framer\Controllers\DefaultsController;
use Framer\Core\Router\Route;


/**
 * ------------------------
 * ---------WEB ROUTES-----
 *
 * Here all the route that should be registered for web
 * Set your routes by method
 */


# route
Route::get('/', [ DefaultsController::class, 'index' ]);
Route::post('/login', [ DefaultsController::class, 'testLogin' ]);
Route::get('/email', [ DefaultsController::class, 'testEmail' ]);
