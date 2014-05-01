<?php

use Kyoushu\SimpleController\ResourceFactory;
use Kyoushu\SimpleController\ViewFactory;

require(__DIR__ . '/src/bootstrap.php');

$viewFactory = new ViewFactory(__DIR__ . '/view');

$resourceFactory = new ResourceFactory(
    $viewFactory,
    sprintf('%s/static', __DIR__),
    sprintf('%s/controller', __DIR__)
);

try{

    $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
    $resource = $resourceFactory->createResourceFromUri($uri);

    if($resource->hasController()){
        echo $resource->invokeController(array(
            'views' => $viewFactory
        ));
    }
    elseif($resource->hasStatic()){
        echo $resource->getStatic();
    }
    else{
        $serverProtocol = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL');
        header($serverProtocol . ' 404 Not Found');
        echo $viewFactory->createView('404')->render();
    }

}
catch(\Exception $rootException){
    
    $serverProtocol = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL');
    header($serverProtocol . ' 500 Internal Server Error');
    
    try{    
        echo $viewFactory->createView('500')->render(array(
            'error' => $rootException->getMessage()
        ));
    }
    catch(\Exception $viewException){
        header('Content-Type: text/plain');
        echo $rootException->getMessage();
    }
	
}
