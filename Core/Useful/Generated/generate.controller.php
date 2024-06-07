<?php

namespace Framer\Core\Useful\Classes\Generated;

function generateController($name) {

$name = ucfirst($name);
$string = <<<EOD
<?php

namespace Framer\Controllers;

use Framer\Core\App\Query;
use Framer\Core\App\Helpers;
use Framer\Core\App\Session;
use Framer\Core\App\Response;
use Framer\Core\App\Controller;

class $name extends Controller
{
    
    /**
     * Index Page
     * 
     * @param Query query object
     * 
     * @return View
     */
    static function index(Query \$query) {
        view('home', [ "foo" => "bar" ]);
    }

}

EOD;
return $string;

}