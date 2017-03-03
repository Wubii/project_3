<?php

class CommentController extends Controller
{
	public function commentListAction()
	{
		$comments = Comment::findAll();

		echo self::$twig->load('CommentList.html.twig')->render(array(
			"comments"=> $comments
		));
	}

	public function commentAddAction($articleId)
	{
		echo self::$twig->load('commentAdd.html.twig')->render(array(
			'articleId' => $articleId
		));
	}

	public function commentAddSubmitAction($articleId, $pseudo, $title, $content)
	{
		$comment = new Comment($articleId);

		$comment->setPseudo($pseudo);
		$comment->setTitle($title);
		$comment->setContent($content);

		$comment->persist();

		$article = Article::findById($articleId);
		$article->addComment($comment);

		$article->persist();

		header('Location: /article');
	}

	public function commentEditAction($id)
	{
		$comment = Comment::findById($id);
		
		echo self::$twig->load('CommentEdit.html.twig')->render(array(
			"comment" => $comment
		));
	}

	public function commentEditSubmitAction($id, $pseudo, $title, $content)
	{
		$comment = Comment::findById($id);

		$comment->setDate(new DateTime("now"));
		$comment->setPseudo($pseudo);
		$comment->setTitle($title);
		$comment->setContent($content);

		$comment->persist();

		header('Location: /comment');
	}

	public function commentDeleteAction($id)
	{
		$comment = Comment::findById($id);

		if(!is_null($comment))
		{
			$comment->remove();
		}

		header('Location: /comment');
	}
}