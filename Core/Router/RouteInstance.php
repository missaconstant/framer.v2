<?php

namespace Framer\Core\Router;

use Framer\Core\Exceptions\UndefinedActionException;

class RouteInstance
{
    
    private $name;
    private $path;
    private $method; # POST | GET | PUT | DELETE | PATCH
    private $controller;
    private $action;
    private $middlewares = [];
    private $params = [];
    public $_onNameGiven = false; # Event

    /**
     * @method __constrcuct
     * 
     * @param $path - the path
     * @param $controller - the controller
     * @param $action - the action
     * 
     * @return RouterInstance
     */
    public function __construct($path, $method, $controller, $action, $name=null) {

        if ( !method_exists($controller, $action) ) {
            throw new UndefinedActionException;
            return;
        }

        $this->path = $path;
        $this->method = $method;
        $this->controller = $controller;
        $this->action = $action;
        $this->name = $name ?? $path;

        return $this;
    }

    /**
     * @method giveName
     * gives a name to the route
     */
    public function giveName($name) {
        $this->name = $name;
        $f = $this->_onNameGiven;
        $f && $f($this);
    }

    /**
     * @method middleware
     * add middleware to route
     */
    public function middleware($middleware) {
        $this->middlewares[] = $middleware;
    }

    /**
     * @method getName
     * getter
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @method getController
     * getter
     */
    public function getController() {
        return $this->controller;
    }

    /**
     * @method getAction
     * getter
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * @method getMiddleWares
     * getter
     */
    public function getMiddlewares() {
        return $this->middlewares;
    }

    /**
     * @method getPath
     * getter
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @method getPath
     * getter
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @method getParams
     * getter
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @method setParams
     * setter
     */
    public function setParams($params) {
        return $this->params = $params;
    }

}
