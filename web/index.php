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
elseif ($requestUrl == "/article/new")
{
    $article1 = new Article();
    $article1->setTitle("Un nouvel article");
    $article1->setContent("contenu 0");
    $article1->persist();

    $article1->setTitle("Une nouvel article");
    $article1->setContent("contenu 1");
    $article1->persist();

    // $article2 = new Article();
    // $article2->setTitle("Un deuxieme nouvel article");
    // $article2->setContent("deuxieme contenu");
    // $article2->persist();
}
elseif ($requestUrl == "/article/remove")
{
    $article = Article::findById(22);

    if($article != null)
    {
        echo $article->getTitle() . "</br>";

        $result = $article->remove();
    }
}
elseif ($requestUrl == "/article/list")
{
    $articles = Article::findAll();

    foreach ($articles as $article) 
    {
        echo "Id : " . $article->getId() . "</br>";
        //$article->setTitle($article->getId() . "nini");
        //$article->persist();
    }
}
else 
{
	echo "Erreur : URL non valide ! ";
}





