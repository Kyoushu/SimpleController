<?php

set_error_handler(function($errno, $errstr, $errfile, $errline){
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

function getResourceName($uri){
	if($uri === '/') return 'index';
	$trimmedUri = preg_replace('/^\/([^\?#]+)([\?#].+)?$/', '${1}', $uri);
	return str_replace(
		'/',
		'_',
		preg_replace('/[^a-z0-9\-\/]/i', '', strtolower($trimmedUri))
	);
}

function generateUrl($resourceName, array $query = null){
	if($resourceName === 'index'){
		$url = '/';
	}
	else{
		$url = sprintf('/%s', preg_replace('_', '/', $resourceName));
	}
	return $url . ($query !== null ? http_build_query($query) : '');
}

function getControllerPath($uri){
	$resourceName = getResourceName($uri);
	return sprintf('%s/controller/%s.php', __DIR__, $resourceName);
}

function getStaticPath($uri){
	$resourceName = getResourceName($uri);
	return sprintf('%s/static/%s.html', __DIR__, $resourceName);
}

try{

	$uri = $_SERVER['REQUEST_URI'];

	$controllerPath = getControllerPath($uri);
	$staticPath = getStaticPath($uri);

	if($controllerPath && file_exists($controllerPath)){
		include($controllerPath);
	}
	elseif($staticPath && file_exists($staticPath)){
		echo file_get_contents($staticPath);
	}
	else{
		include(__DIR__ . '/view/404.php');
	}

}
catch(Exception $e){
	$error = $e->getMessage();
	include(__DIR__ . '/view/500.php');
}
