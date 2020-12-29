<?php

namespace Framer\Core\Exceptions;

class FramerException extends \Exception
{

    /** @var string name of the exception */
    protected $name = 'FramerException';


    public function __construct() {
        $this->setName(get_class($this));
    }


    /**
     * Get the execption name
     * 
     * @return string name of the exception
     */
    protected function getName() {
        return $this->name;
    }

    /**
     * Sets the exception name
     * 
     * @param string name of the exception
     * 
     * @return void
     */
    protected function setName($name) {
        $this->name = $name;
    }


    /**
     * Sets the exception's message
     * 
     * @param string the message of exception
     * 
     * @return void
     */
    protected function setMessage($message) {
        $this->message = $message;
    }


    /**
     * Get the main reason of exception. The file name and line.
     * 
     * @return StdClassObject
     */
    public function getCause() {
        return (object) [ "filename" => $this->file, "line" => $this->line ];
    }


    /**
     * Get exception's errors including exception's trace
     * 
     * @return StdClassObject
     */
    public function getErrors() {

        $errors = [
            "name" => $this->getName(),
            "message" => $this->getMessage(),
            "cause" => $this->getCause(),
            "trace" => $this->getTrace()
        ];

        return (object) $errors;
    }


    /**
     * Sets a global error handle
     * 
     * @return void
     */
    public static function handleErrors() {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            var_dump($errno, $errstr, $errfile, $errline);
        });
    }

}
