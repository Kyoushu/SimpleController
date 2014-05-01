<?php

namespace Kyoushu\SimpleController;

class Resource{
    
    private $name;
    private $factory;
    
    static function trimUri($uri){
        return preg_replace('/^\/([^\?#]+)([\?#].+)?$/', '${1}', $uri);
    }
    
    static function trasnformUri($uri){
        if($uri === '/') return 'index';
        $trimmedUri = self::trimUri($uri);
        $name = str_replace(
            '/',
            '_',
            preg_replace('/[^a-z0-9\-\/]/i', '', strtolower($trimmedUri))
        );
        if(!$name) return null;
        return $name;
    }
    
    public function __construct(ResourceFactory $factory, $name){
        $this->factory = $factory;
        $this->name = $name;
    }
    
    public function getName(){
        return $this->name;
    }
    
    private function getControllerPath(){
        return sprintf(
            '%s/%s.php',
            $this->factory->getControllerPath(),
            $this->name
        );
    }
    
    private function getStaticPath(){
        return sprintf(
            '%s/%s.html',
            $this->factory->getStaticPath(),
            $this->name
        );
    }
    
    public function hasStatic(){
        $path = $this->getStaticPath();
        return file_exists($path);
    }
    
    public function hasController(){
        $path = $this->getControllerPath();
        return file_exists($path);
    }
    
    public function getStatic(){
        if(!$this->hasStatic()){
            throw new \RuntimeException(sprintf('Static content not available for resource %s', $this->name));
        }
        $path = $this->getStaticPath();
        return file_get_contents($path);
    }
    
    public function invokeController(array $context = null){
        
        if($context === null){
            $context = array();
        }
        
        if(!$this->hasController()){
            throw new \RuntimeException(sprintf('Controller not available for resource %s', $this->name));
        }
        
        extract($context, EXTR_SKIP);
        
        $path = $this->getControllerPath();
        ob_start();
        include($path);
        $output = ob_get_contents();
        ob_end_clean();
        
        return $output;
        
    }
    
}