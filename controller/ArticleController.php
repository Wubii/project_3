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
	public function articleAddSubmitAction($title, $content)
	{
		$article = new Article();

		$article->setAuthor("Jean Forteroche");
		$article->setTitle($title);
		$article->setContent($content);

		$article->persist();

		header('Location: /dashboard/articles');
	}

	// Récupère l'id de l'article et affiche le formulaire d'édition
	public function articleEditAction($id)
	{
		$article = Article::findById($id);
		
		echo self::$twig->load('DashboardArticleEdit.html.twig')->render(array(
			"article" => $article
		));
	}

	// Enregistre les modification de l'article
	public function articleEditSubmitAction($id, $title, $content)
	{
		$article = Article::findById($id);

		$article->setDate(new DateTime("now"));
		$article->setAuthor("Jean Forteroche");
		$article->setTitle($title);
		$article->setContent($content);

		$article->persist();

		header('Location: /dashboard/articles');
	}

	// Suppression d'un article
	public function articleDeleteAction($id)
	{
		$article = Article::findById($id);

		if(!is_null($article))
		{
			$article->remove();
		}

		header('Location: /dashboard/articles');
	}

	public function articleAction($id)
	{
		$article = Article::findById($id);
		echo self::$twig->load('Article.html.twig')->render(array(
			"article"=> $article
		));
	}
}










