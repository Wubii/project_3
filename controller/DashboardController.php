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

	/*---------------------------------------------------------------------*/
	/* Articles                                                            */
	/*---------------------------------------------------------------------*/

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

	/*---------------------------------------------------------------------*/
	/* Comments                                                            */
	/*---------------------------------------------------------------------*/

	function dashboardCommentListAction()
	{
		$comments = Comment::findAll();

		echo self::$twig->load('DashboardCommentList.html.twig')->render(array(
			"comments" => $comments
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

	/*---------------------------------------------------------------------*/
	/* Users                                                               */
	/*---------------------------------------------------------------------*/

	function dashboardUserListAction()
	{
		$users = User::findAll();

		echo self::$twig->load('DashboardUserList.html.twig')->render(array(
			"users"=> $users
		));
	}

	public function dashboardUserAddAction($username, $mail, $password)
	{
		$user = new User();

		$user->setUsername($username);
		$user->setMail($mail);
		$user->setPassword($password);
		$user->setRole(0);
		$user->setLocked(0);

		$user->persist();
	}

	public function dashboardUserDeleteAction($id)
	{
		$user = User::findById($id);

		if(!is_null($user))
		{
			echo $id;
			$user->remove();
		}
	}

	public function dashboardUserLockToggle($id)
	{
        $user = User::findById($id);

        $user->lockToggle();

        $user->persist();

        header('Location: /dashboard/users');

	}

}

?>
