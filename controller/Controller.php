<?php

class Controller
{
	protected static $twig;

	function __construct()
	{
		if(self::$twig == null) 
		{			
			$loader = new Twig_Loader_Filesystem( __DIR__ . '/../view');

			self::$twig = new Twig_Environment($loader, array(
			   'cache' => __DIR__ . '/../var/cache',
			   'debug' => true
			));
		}
	}
}

?>
