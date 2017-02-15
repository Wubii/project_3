<?php
// Affiche le reporting d'erreur
error_reporting(E_ALL);

require_once __DIR__ . "/../autoload.php";

$collection = new RouteCollection();
$collection->attachRoute(new Route('/', array(
    '_controller' => 'MyController::testAction',
    'methods' => 'GET'
)));

$collection->attachRoute(new Route('/test', array(
    '_controller' => 'TestController::testAction',
    'methods' => 'GET'
)));

$router = new Router($collection);
// $router->setBasePath('/');
// $route = $router->matchCurrentRequest();

// var_dump($route);