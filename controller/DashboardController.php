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

	function dashboardArticleShowAction()
	{
		$articles = Article::findAll();

		echo self::$twig->load('DashboardArticle.html.twig')->render(array(
			"articles"=> $articles
		));
	}

	function dashboardCommentShowAction()
	{
		$comments = Comment::findAll();

		echo self::$twig->load('DashboardComment.html.twig')->render(array(
			"comments"=> $comments
		));
	}
}

?>
