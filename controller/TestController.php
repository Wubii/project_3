<?php

class TestController extends Controller
{
	function testAction()
	{
		$toto = "tatadam !";
		
		echo self::$twig->load('MyTemplate.html.twig')->render(array("tata"=> $toto));
	}
}

?>
