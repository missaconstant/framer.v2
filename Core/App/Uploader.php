<?php

namespace Framer\Core\App;

use Framer\Core\App\Input;


/**
 * File uploaded class
 */
class FileUploaded {

    public $name = '';
    public $size = 0;
    public $error = 0;
    public $tmp_name = '';
    public $type = '';
    public $id = '';

    public function __construct($file) {
        
        $this->name = $file->name;
        $this->size = $file->size;
        $this->error = $file->error;
        $this->tmp_name = $file->tmp_name;
        $this->type = $file->type;
        $this->id = md5(uniqid() . microtime(true));
    }


    /**
     * Get the file id
     * @return String the id
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Get the file extension
     * 
     * @return String extension
     */
    public function getExtension() {

        $pathinfo = pathinfo( $this->name );
        return $pathinfo['extension'] ?? null;
    }


    /**
     * Check if the file contains error
     */
    public function hasError() {
        return $this->error !== 0;
    }


    public function moveFile($path, $name=null) {
        
        $name = $name ?? $this->id . '.' . $this->getExtension();
        return move_uploaded_file($this->tmp_name, $path . $name) ? $name : false;
    }

}


/**
 * Uploader class
 */
class Uploader {

    /**
     * Contains uploaded files
     * @property $files
     */
    private $files = [];

    /**
     * Are multiple files expected ?
     */
    private $multiple = true;


    public function __construct($multiple = true) {
        $this->files = Input::file();
        $this->multiple = $multiple;
        $this->orderFiles();
    }


    /**
     * Order file according to a good pattern
     * 
     * @method orderFiles
     * 
     * @return Array ordered files
     */
    private function orderFiles() {

        $ordered = [];

        foreach ($this->files as $k => $file) {
            $ordered[ $k ] = [];

            if ( is_array($file['name']) ) {
                foreach ( $file['name'] as $x => $name ) {
                    $ordered[$k][] = new FileUploaded((object) [
                        "name" => $name,
                        "error" => $file['error'][$x],
                        "type" =>  $file['type'][$x],
                        "tmp_name" =>  $file['tmp_name'][$x],
                        "size" =>  $file['size'][$x]
                    ]);
                }
            }
            else {
                $ordered[$k][] = new FileUploaded((object) $file);
            }

            if ( count($ordered[$k]) === 1 && !$this->multiple ) {
                $ordered[$k] = $ordered[$k][0];
            }
        }

        $this->files = $ordered;
    }


    /**
     * Get file list
     * @method geFiles
     * 
     * @return Array[File]
     */
    public function getFiles($name=null) {
        return $name ? $this->files[$name] : $this->files;
    }


    /**
     * Get the first file
     * @method getFirst
     * 
     * @return File
     */
    public function getFirst($name) {
        return $this->files[$name][0] ?? null;
    }


    /**
     * Checks wether there is an error on a file
     * 
     * @return Array of files
     */
    public function hasErrors() {

        $fileswitherror = [];

        foreach ($this->files as $k => $file) {
            if ($file->error) $fileswitherror[] = $file->name;
        }

        return $fileswitherror;
    }

}