<?php

class TestController extends Controller
{
	function testAction()
	{
		$article = Article::findById(1);
		Comment::findAllByArticle($article);
	}
}

?>
