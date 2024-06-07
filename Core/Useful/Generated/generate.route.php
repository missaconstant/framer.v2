<?php

namespace Framer\Core\Useful\Classes\Generated;

function generateRoute($name) {
    $upname = strtoupper($name);
    $string =
<<<EOD
<?php

namespace Framer\Routes;

// use MiladRahimi\PhpRouter\Router \$router variable to create your routes
// you don't need to instanciate router just use it
// \$router->...
// Doc: https://github.com/miladrahimi/phprouter

use Framer\Controllers\DefaultsController;
/**
 * ------------------------
 * ---------$upname ROUTES-----
 *
 * Here all the route that should be registered for web
 * Set your routes by method
 */
\$router->get('/', [DefaultsController::class, 'index']);

EOD;
return $string;
}
