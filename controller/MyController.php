<?php

require_once __DIR__ . '/../autoload.php';

class MyController extends Controller
{
	function homeAction() 
	{
		echo self::$twig->load('Home.html.twig')->render(array(
			'session' => Session::getInstance()
		));
	}

	function testAction() 
	{
		$session = Session::getInstance();
		$session->setFlash("tartampion", "success");
		header('Location: /');
	}
}

?>
