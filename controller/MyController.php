<?php

require_once __DIR__ . '/../autoload.php';

class MyController extends Controller
{
	function homeAction() 
	{
		$article = Article::findLastOne();
		$auth = new Authentification();

		echo self::$twig->load('Home.html.twig')->render(array(
			'session' => Session::getInstance(),
			'role' => $auth->getRole(),
			'article' => $article
		));
	}

	function testAction() 
	{}
}

?>
