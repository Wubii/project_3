<?php

class DashboardController extends Controller
{
	function dashboardShowAction()
	{
		$articles = Article::findAll();
		$comments = Comment::findAllByAlert();

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

	function dashboardCommentAction()
	{
		$comments = Comment::findAll();

		echo self::$twig->load('DashboardCommentList.html.twig')->render(array(
			"comments"=> $comments
		));
	}

	public function dashboardCommentAlertListAction()
	{
		$comments = Comment::findAllByAlert();

		echo self::$twig->load('DashboardCommentList.html.twig')->render(array(
			"comments"=> $comments
		));
	}

	public function dashboardCommentAlertShowAction($id)
	{
		$comment = Comment::findById($id);

		echo self::$twig->load('DashboardCommentShow.html.twig')->render(array(
			"comment"=> $comment
		));
	}

	public function dashboardCommentAlertDeleteAction($id)
	{
		$comment = Comment::findById($id);

		if(!is_null($comment))
		{
			$comment->remove();
		}

		header('Location: /dashboard/comments');
	}

	public function dashboardCommentAlertPublishAction($id)
	{
		$comment = Comment::findById($id);

	    $comment->setAlert(0);
	    $comment->persist();

		header('Location: /dashboard/comments');
	}
}

?>
