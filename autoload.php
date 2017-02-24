<?php

spl_autoload_register(function ($class)
{
	$fileName = __DIR__ . "/model/" . $class . ".php";

	if(file_exists($fileName)) 
	{
		require_once($fileName);
	} 
});

spl_autoload_register(function ($class)
{
	$fileName = __DIR__ . "/controller/" . $class . ".php";

	if(file_exists($fileName)) 
	{
		require_once($fileName);
	} 
});

require_once(__DIR__ . "/lib/Twig/Autoloader.php");

Twig_Autoloader::register();
