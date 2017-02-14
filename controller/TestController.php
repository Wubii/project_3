<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once 'Controller.php';

class TestController extends Controller
{
	function testAction($toto)
	{
		echo $this->twig->load('MyTemplate.html.twig')->render(array("tata"=> $toto));
	}
}

?>
