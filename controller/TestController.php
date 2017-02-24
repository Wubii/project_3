<?php

require_once __DIR__ . '/../autoload.php';

class TestController extends Controller
{
	function testAction()
	{
		// echo $this->twig->load('MyTemplate.html.twig')->render(array("tata"=> $toto));

		echo "TestController </br> testAction";
	}
}

?>
