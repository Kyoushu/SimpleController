<?php

function getScriptPath($uri){
	if($uri === '/'){
		$filename = 'index.php';
	}
	else{
		$trimmedUri = preg_replace('/^\/([^\?#]+)([\?#].+)?$/', '${1}', $uri);
		$filename = str_replace(
			'/',
			'_',
			preg_replace('/[^a-z0-9\-\/]/i', '', strtolower($trimmedUri))
		);
	}
	return sprintf('%s/controller/%s.php', __DIR__, $filename);
}

$uri = $_SERVER['REQUEST_URI'];
$path = getScriptPath($uri);

if(file_exists($path)){
	include($path);
}
else{
	include(__DIR__ . '/controller/404.php');
}
