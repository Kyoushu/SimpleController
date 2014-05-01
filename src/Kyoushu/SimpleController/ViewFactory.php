<?php

namespace Kyoushu\SimpleController;

class ViewFactory{
    
    private $viewsPath;
    
    public function __construct($viewsPath){
        $this->viewsPath = $viewsPath;
    }
    
    public function createView($name){
        return new View($this, $name);
    }
    
    public function create($name){
        return $this->createView($name);
    }
    
    public function getViewsPath(){
        return $this->viewsPath;
    }
    
}
