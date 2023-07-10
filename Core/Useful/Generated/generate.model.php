<?php

namespace Framer\Core\Useful\Classes\Generated;

function generateModel($name, $tablename) {
    $name = ucfirst($name);
    $string =

<<<EOD
<?php

namespace Framer\Models;

use Illuminate\Database\Eloquent\Model;

class $name extends Model
{
    
    protected \$table = '$tablename';
    
}

EOD;

    return $string;

}


function getTableColumns($tablename) {
    return DbManager::getTableColumns($tablename);
}
