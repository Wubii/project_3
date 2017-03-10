<?php

class ArticleController extends Controller
{
	public function articleListAction()
	{
		// retourne la liste de tous les articles
		$articles = Article::findAll();

		echo self::$twig->load('ArticleList.html.twig')->render(array(
			"articles"=> $articles
		));
	}

	public function articleAddAction()
	{
		// Affiche le formulaire pour ajouter un article
		echo self::$twig->load('ArticleAdd.html.twig')->render();
	}

	// Enregistre le nouvel article
	public function articleAddSubmitAction($author, $title, $content)
	{
		$article = new Article();

		$article->setAuthor($author);
		$article->setTitle($title);
		$article->setContent($content);

		$article->persist();

		header('Location: /dashboard/articles');
	}

	// Récupère l'id de l'article et affiche le formulaire d'édition
	public function articleEditAction($id)
	{
		$article = Article::findById($id);
		
		echo self::$twig->load('ArticleEdit.html.twig')->render(array(
			"article" => $article
		));
	}

	// Enregistre les modification de l'article
	public function articleEditSubmitAction($id, $author, $title, $content)
	{
		$article = Article::findById($id);

		$article->setDate(new DateTime("now"));
		$article->setAuthor($author);
		$article->setTitle($title);
		$article->setContent($content);

		$article->persist();

		header('Location: /article');
	}

	// Suppression d'un article
	public function articleDeleteAction($id)
	{
		$article = Article::findById($id);

		if(!is_null($article))
		{
			$article->remove();
		}

		header('Location: /article');
	}
}