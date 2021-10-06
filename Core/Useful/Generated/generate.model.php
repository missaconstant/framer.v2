<?php

namespace Framer\Core\Useful\Classes\Generated;
use Framer\Core\Model\DbManager;

function generateModel($name) {

    $name = ucfirst($name);
    $sname = strtolower($name);

    $defaultcolumns = [
        (object) ["COLUMN_NAME" => "id", "COLUMN_DEFAULT" => null]
    ];

    // try getting table columns if table exists
    $defaultcolumns = getTableColumns($sname) ?? $defaultcolumns;

    // print column list
    $list = [];

    foreach ($defaultcolumns as $k => $column) {
        
        $list[] = "public $$column->COLUMN_NAME" . ($column->COLUMN_DEFAULT != NULL ? " = $column->COLUMN_DEFAULT" : "") . ";";
    }

    $list = implode("\n\t", array_map(function ($item) {
        return "$item";
    }, $list));


    $string =

<<<EOD
<?php

namespace Framer\Models;

use Framer\Core\Model\BaseModel;

class $name extends BaseModel
{
    
    $list


    public function __construct() {
        parent::__construct('$sname');
    }

}

EOD;

    return $string;

}


function getTableColumns($tablename) {
    return DbManager::getTableColumns($tablename);
}