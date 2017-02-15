<?php

require_once __DIR__ . '/../autoload.php';

class TestController extends Controller
{
	function testAction($toto)
	{
		echo $this->twig->load('MyTemplate.html.twig')->render(array("tata"=> $toto));
	}
}

?>
