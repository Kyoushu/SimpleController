<?php

set_error_handler(function($errno, $errstr, $errfile, $errline){
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

spl_autoload_register(function($class){
    $path = sprintf(
        '%s/%s.php',
        __DIR__,
        preg_replace(
            '/^\\\\/',
            '',
            str_replace('\\', DIRECTORY_SEPARATOR, $class)
        )
    );
    if(file_exists($path)) require_once($path);
});