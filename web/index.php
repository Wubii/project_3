<?php
// Affiche le reporting d'erreur
error_reporting(E_ALL);

require_once __DIR__ . "/../autoload.php";

$requestUrl = $_SERVER['REQUEST_URI'];

switch($requestUrl)
{
	/* PAGE D'ACCUEIL--------------------------------------------------*/

	case "/" :
		
		$controller = new MyController();

		$controller->testAction();
		break;


	/* PAGE TEST ------------------------------------------------------*/

	case "/test" :
	
		$controller = new TestController();
		$controller->testAction();

		break;
		

	/* PAGE TEST AUTOLOAD ----------------------------------------------*/

	case "/autoload" :

		$controller = new Controller1();

		$controller->toStringAction();

		break;
		

	/* CRÉATION ET MODIFICATION D'UN ARTICLE ---------------------------*/

	case "/article/new" :

	    $article1 = new Article();
	    $article1->setTitle("Un nouvel article");
	    $article1->setContent("contenu 0");
	    $article1->persist();
	    echo "L'article a bien été ajouté </br>";

	    $article1->setTitle("Un nouvel article");
	    $article1->setContent("contenu 1");
	    $article1->persist();
	    echo "L'article a bien été modifié </br>";

	    $article2 = new Article();
	    $article2->setTitle("Un deuxieme nouvel article");
	    $article2->setContent("deuxieme contenu");
	    $article2->persist();
	    echo "Le deuxième article a bien été créé </br>";

		break;
		

	/* AFFICHE TOUS LES ARTICLES --------------------------------------*/

	case "/article/list" :

	    $articles = Article::findAll();

    	foreach ($articles as $article) 
    	{
        	echo "</br> Id : " . $article->getId() . "</br>" . $article->getTitle() . " Author : " . $article->getAuthor() . " Écrit le : " . $article->getDate()->format('Y-m-d H:i:s') . "</br>" . $article->getContent(). "</br>";
    	}

		break;
		

	/* AFFICHE UN ARTICLE----------------------------------------------*/

	case "/article/find_by_id" :
    	
    	$article = Article::findById(6);

        echo $article->getTitle() . " Author : " . $article->getAuthor() . " Écrit le : " . $article->getDate()->format('Y-m-d H:i:s') . "</br>" . $article->getContent();

    	break;
		

	/* SUPPRIME UN ARTICLE---------------------------------------------*/

	case "/article/remove" :
    	
    	$article = Article::findById(3);

    	if($article != null)
    	{
        	echo $article->getTitle() . "</br>";

        	$result = $article->remove();
    	}

		break;
		

	/* AJOUTE UN COMMENTAIRE ------------------------------------------*/

	case "/comment/new" :

	    $comment1 = new Comment();
	    $comment1->setTitle("Un nouvel commentaire");
	    $comment1->setContent("Contenu du premier commentaire");
	    $comment1->setPseudo("Wubiii");
	    $comment1->persist();
	    echo "Le commentaire a bien été ajouté </br>";

	    $comment1->setTitle("Un nouvel commentaire");
	    $comment1->setContent("Contenu modifié du premier commentaire");
	    $comment1->setPseudo("Wubiii");
	    $comment1->persist();
	    echo "Le commentaire a bien été modifié </br>";

	    $comment2 = new Comment();
	    $comment2->setTitle("Un deuxieme commentaire");
	    $comment2->setContent("Contenu du deuxième commentaire");
	    $comment2->setPseudo("Comos");
	    $comment2->persist();
	    echo "Le deuxième commentaire a bien été créé </br>";

		break;
		

	/* LISTE TOUS LES COMMENTAIRES ------------------------------------*/

	case "/comment/list" :

	    $comments = Comment::findAll();

    	foreach ($comments as $comment) 
    	{
        	echo "</br> Id : " . $comment->getId() . "</br>" . $comment->getTitle() . " Author : " . $comment->getPseudo() . " Écrit le : " . $comment->getDate()->format('Y-m-d H:i:s') . "</br>" . $comment->getContent(). "</br>";
    	}

		break;
		

	/* AFFICHE UN COMMENTAIRE -----------------------------------------*/

	case "/comment/find_by_id" :
    	
    	$comment = Comment::findById(6);

        echo $comment->getTitle() . " Pseudo : " . $comment->getPseudo() . " Écrit le : " . $comment->getDate()->format('Y-m-d H:i:s') . "</br>" . $comment->getContent();

    	break;
		

	/* SUPRRIME UN COMMENTAIRE ----------------------------------------*/

	case "/comment/remove" :
    	
    	$comment = Comment::findById(4);

    	if($comment != null)
    	{
        	$result = $comment->remove();

        	echo "Le commentaire : \'". $comment->getTitle() . "\' a été supprimé</br>";
    	}

		break;

	default :
		
		echo "Erreur : URL non valide ! ";

		break;
}




