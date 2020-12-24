<?php

namespace Framer\Core\Exceptions;

use Framer\Core\Exceptions\FramerException;

class UndefinedActionException extends FramerException
{
    public function __construct() {

        parent::__construct();
        $this->setMessage('Action introuvable');

    }
}
