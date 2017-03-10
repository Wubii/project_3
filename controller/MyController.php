<?php

require_once __DIR__ . '/../autoload.php';

class MyController extends Controller
{
	function homeAction() 
	{
		echo self::$twig->load('Home.html.twig')->render();
	}
}

?>
