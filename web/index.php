<?php
// Affiche le reporting d'erreur
error_reporting(E_ALL);

require_once __DIR__ . "/../autoload.php";

// instanciation de la classe
$model1 = new Model1();

// appel de la fonction toString
echo $model1->toString();

$controller1 = new controller1();

echo "</br>";

echo $controller1->toString();

	