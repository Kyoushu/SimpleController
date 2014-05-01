<?php

namespace Kyoushu\SimpleController;

set_error_handler(function($errno, $errstr, $errfile, $errline){
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

function getResourceName($uri){
	if($uri === '/') return 'index';
	$trimmedUri = preg_replace('/^\/([^\?#]+)([\?#].+)?$/', '${1}', $uri);
	$resourceName = str_replace(
		'/',
		'_',
		preg_replace('/[^a-z0-9\-\/]/i', '', strtolower($trimmedUri))
	);
    
    if(!$resourceName) return null;
    return $resourceName;
}

function controllerExists($resourceName){
	$path = getControllerPath($resourceName);
	return file_exists($path);
}

function staticExists($resourceName){
	$path = getStaticPath($resourceName);
	return file_exists($path);
}

function getControllerPath($resourceName){
	return sprintf('%s/controller/%s.php', __DIR__, $resourceName);
}

function getStaticPath($resourceName){
	return sprintf('%s/static/%s.html', __DIR__, $resourceName);
}

function getViewPath($viewName){
	return sprintf('%s/view/%s.php', __DIR__, $viewName);
}

function invokeController($resourceName, array $context = null){
	$path = getControllerPath($resourceName);
    
	if(!file_exists($path)){
		throw new \RuntimeException(sprintf('Controller %s does not exist', $resourceName));
	}
    
	if($context === null) $context = array();
	extract($context, EXTR_SKIP);
    
	ob_start();
	include($path);
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

function getStatic($resourceName){
	$path = getStaticPath($resourceName);
    
    if(!file_exists($path)){
		throw new \RuntimeException(sprintf('Static %s does not exist', $resourceName));
	}
    
    return file_get_contents($path);
}

function renderView($viewName, array $context = null){
	$path = getViewPath($viewName);
	if($context === null) $context = array();
	extract($context, EXTR_SKIP);
	ob_start();
	include($path);
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

try{

	$uri = $_SERVER['REQUEST_URI'];
	$resourceName = getResourceName($uri);

	if(controllerExists($resourceName)){
		echo invokeController($resourceName);
	}
	elseif(staticExists($resourceName)){
		echo getStatic($resourceName);
	}
    else{
		echo renderView('404');
	}

}
catch(\Exception $e){
	echo renderView('500', array(
		'error' => $e->getMessage()
	));
}
