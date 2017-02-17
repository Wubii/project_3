<?php

require_once __DIR__ . '/../autoload.php';

class Controller
{
	protected static $twig;

	function __construct()
	{
		// if($twig == null) 
		// {			
		// 	$loader = new Twig_Loader_Filesystem( __DIR__ . '/../view');

		// 	$this->twig = new Twig_Environment($loader, array(
		// 	    'cache' => __DIR__ . '/../var/cache',
		// 	    'debug' => true
		// 	));
		// }
	}
}

?>
