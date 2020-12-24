<?php

namespace Framer\Core\Exceptions;

use Framer\Core\Exceptions\FramerException;

class RouteNotFoundException extends FramerException
{

    public function __construct() {

        parent::__construct();
        $this->setMessage('Route introuvable ou methode non existance pour la route.');

    }
}
