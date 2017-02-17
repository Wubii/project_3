<?php
// Affiche le reporting d'erreur
error_reporting(E_ALL);

require_once __DIR__ . "/../autoload.php";

$requestUrl = $_SERVER['REQUEST_URI'];

if($requestUrl == "/") 
{
	$controller = new MyController();

	$controller->testAction();
}
elseif ($requestUrl == "/test")
{
	$controller = new TestController();

	$controller->testAction();
}
elseif ($requestUrl == "/autoload")
{
	$controller = new Controller1();

	$controller->toStringAction();
}
else 
{
	echo "Erreur : URL non valide ! ";
}





