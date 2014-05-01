<?php

namespace Kyoushu\SimpleController;

class ResourceFactory{
    
    private $viewFactory;
    private $staticPath;
    private $controllerPath;
    
    /**
     * 
     * @param \Kyoushu\SimpleController\ViewFactory $viewFactory
     * @param string $staticPath Path to static directory
     * @param string $controllerPath Path to controller directory
     */
    public function __construct(ViewFactory $viewFactory, $staticPath, $controllerPath){
        $this->viewFactory = $viewFactory;
        $this->staticPath = $staticPath;
        $this->controllerPath = $controllerPath;
    }
    
    /**
     * @param string $uri
     * @return \Kyoushu\SimpleController\Resource
     */
    public function createResourceFromUri($uri){
        $name = Resource::trasnformUri($uri);
        return new Resource($this, $name);
    }
    
    /**
     * Get path to static directory
     * @return string
     */
    public function getStaticPath(){
        return $this->staticPath;
    }
    
    /**
     * Get path to controller directory
     * @return type
     */
    public function getControllerPath(){
        return $this->controllerPath;
    }
    
}