<?php

class DashboardController extends Controller
{
	function dashboardShowAction()
	{
		$articles = Article::findAll();
		$comments = Comment::findAll();

		echo self::$twig->load('Dashboard.html.twig')->render(array(
			"articles" => $articles,
			"comments" => $comments
		));
	}

	function dashboardArticleListAction()
	{
		$articles = Article::findAll();

		echo self::$twig->load('DashboardArticleList.html.twig')->render(array(
			"articles"=> $articles
		));
	}

	function dashboardArticleAction($id)
	{
		$article = Article::findById($id);

		echo self::$twig->load('DashboardArticle.html.twig')->render(array(
			"article"=> $article
		));
	}

	function dashboardArticleEditAction($id)
	{
		$article = Article::findById($id);

		echo self::$twig->load('DashboardArticleEdit.html.twig')->render(array(
			"article"=> $article
		));
	}

	function dashboardCommentListAction()
	{
		$comments = Comment::findAll();

		echo self::$twig->load('DashboardCommentList.html.twig')->render(array(
			"comments"=> $comments
		));
	}
}

?>
