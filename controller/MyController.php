<?php

require_once __DIR__ . '/../autoload.php';

class MyController extends Controller
{
	function testAction() 
	{
		// echo $this->twig->load('MyTemplate.html.twig')->render(array("tata"=> "Home"));

		echo "MyController testAction";
	}
}

?>
