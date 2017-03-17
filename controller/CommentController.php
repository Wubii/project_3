<?php

class CommentController extends Controller
{
	public function commentListAction($id)
	{
		$comment = Comment::findById($id);


		echo self::$twig->load('Comment.json.twig')->render(array(
			"comment"=> $comment
		));
	}

	public function commentAddAction($articleId)
	{
		echo self::$twig->load('commentAdd.html.twig')->render(array(
			'articleId' => $articleId
		));
	}

	public function commentAddToArticleSubmitAction($articleId, $pseudo, $title, $content)
	{
		$comment = new Comment($articleId);

		$comment->setPseudo($pseudo);
		$comment->setTitle($title);
		$comment->setContent($content);
		$comment->setLevel(1);

		$comment->persist();

		$article = Article::findById($articleId);
		$article->addComment($comment);

		$article->persist();

		header('Location: /article?id=' . $articleId);
	}

	public function commentAddToCommentSubmitAction($commentId, $pseudo, $content)
	{
		$parent = Comment::findById($commentId);

		$comment = new Comment(0, $commentId);

		$comment->setPseudo($pseudo);
		$comment->setContent($content);
		$comment->setLevel($parent->getLevel() + 1);		

		$comment->persist();
	}

	public function commentEditAction($id)
	{
		$comment = Comment::findById($id);
		
		echo self::$twig->load('CommentEdit.html.twig')->render(array(
			"comment" => $comment
		));
	}

	public function commentEditSubmitAction($id, $title, $content)
	{
		$comment = Comment::findById($id);

		$comment->setDate(new DateTime("now"));
		$comment->setTitle($title);
		$comment->setContent($content);

		$comment->persist();
	}

	public function commentAlertAction($id)
	{
		$comment = Comment::findById($id);

		if(!is_null($comment))
		{
			$comment->setAlert(1);
			$comment->persist();
		}
	}

	public function commentDeleteAction($id)
	{
		$comment = Comment::findById($id);

		if(!is_null($comment))
		{
			$comment->remove();
		}
	}
}