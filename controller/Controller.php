<?php

require_once __DIR__ . '/../vendor/autoload.php';

class Controller
{
	protected $twig;

	function __construct()
	{
		$loader = new Twig_Loader_Filesystem( __DIR__ . '/../view');

		$this->twig = new Twig_Environment($loader, array(
		    'cache' => __DIR__ . '/../var/cache',
		    'debug' => true
		));
	}
}

?>
