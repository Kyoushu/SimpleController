<?php

namespace Kyoushu\SimpleController;

class View{
    
    private $factory;
    private $name;
    
    public function __construct(ViewFactory $factory, $name){
        $this->factory = $factory;
        $this->name = $name;
        
        if(!$this->exists()){
            throw new \RuntimeException(sprintf(
               'The view %s does not exist',
                $this->getPath()
            ));
        }
        
    }
    
    public function getName(){
        return $this->name;
    }
    
    private function getPath(){
        return sprintf(
            '%s/%s.php',
            $this->factory->getViewsPath(),
            $this->name
        );
    }
    
    public function exists(){
        $path = $this->getPath();
        return file_exists($path);
    }
    
    public function render(array $context = null){
        
        if($context === null) $context = array();
        
        extract($context, EXTR_SKIP);
        
        $path = $this->getPath();
        ob_start();
        include($path);
        $output = ob_get_contents();
        ob_end_clean();
        
        return $output;
        
    }
    
}