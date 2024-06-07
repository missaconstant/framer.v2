<?php

namespace Framer\Core\Exceptions;

use Framer\Core\Exceptions\FramerException;

class DbException extends FramerException
{

    public function __construct($message) {

        parent::__construct();
        $this->setMessage($message);

    }
}
