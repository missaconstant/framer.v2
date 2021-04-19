<?php

function generateModel($name, $tblname='blank') {

$name = ucfirst($name);
$string = <<<EOD
<?php

namespace Framer\Models;

use Framer\Core\Model\BaseModel;

class $name extends BaseModel
{
    
    public \$id;


    public function __construct() {
        parent::__construct('$tblname');
    }

}

EOD;

return $string;

}