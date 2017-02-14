<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once 'Controller.php';

class MyController extends Controller
{
	function testAction() 
	{
		echo $this->twig->load('MyTemplate.html.twig')->render(array("tata"=> "Home"));
	}
}

?>
