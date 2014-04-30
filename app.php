<?php

function getResourceName($uri){
	if($uri === '/') return 'index';
	$trimmedUri = preg_replace('/^\/([^\?#]+)([\?#].+)?$/', '${1}', $uri);
	return str_replace(
		'/',
		'_',
		preg_replace('/[^a-z0-9\-\/]/i', '', strtolower($trimmedUri))
	);
}

function getControllerPath($uri){
	$resourceName = getResourceName($uri);
	return sprintf('%s/controller/%s.php', __DIR__, $resourceName);
}

function getStaticPath($uri){
	$resourceName = getResourceName($uri);
	return sprintf('%s/static/%s.html', __DIR__, $resourceName);
}

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
	include(__DIR__ . '/controller/404.php');
}
