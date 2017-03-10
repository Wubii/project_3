<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../autoload.php';

class ArticleTest extends TestCase
{
	public function testArticleCreation()
	{
		$article = new Article();

		$this->assertEquals($article->getId(), 0);
		$this->assertEquals($article->getTitle(), "");
		$this->assertEquals($article->getContent(), "");
		$this->assertEquals($article->getAuthor(), "Jean FORTEROCHE");
	}

	public function testArticleGetterSetter()
	{
		$date = new DateTime("now");

		$article = new Article();

		$article->setId(4);
		$article->setTitle("title");
		$article->setContent("blabla");
		$article->setAuthor("Jean giono");
		$article->setDate($date);


		$this->assertEquals($article->getId(), 4);
		$this->assertEquals($article->getTitle(), "title");
		$this->assertEquals($article->getContent(), "blabla");
		$this->assertEquals($article->getAuthor(), "Jean giono");
		$this->assertEquals($article->getDate(), $date);
	}

	public function testArticlePersist()
	{
		$date = new DateTime("now");

		$article = new Article();

		$article->setTitle("title");
		$article->setContent("blabla");
		$article->setAuthor("Jean giono");
		$article->setDate($date);

		$article->persist();
		$id = $article->getId();

		$article2 = Article::findById($id);

		$this->assertEquals($article2->getId(), $id);
		$this->assertEquals($article2->getTitle(), "title");
		$this->assertEquals($article2->getContent(), "blabla");
		$this->assertEquals($article2->getAuthor(), "Jean giono");
		$this->assertEquals($article2->getDate(), $date);
	}

	public function testArticleRemove()
	{
		$article = new Article();

		$article->persist();

		$id = $article->getId();

		$article2 = Article::findById($id);
		
		$this->assertEquals($article2->remove(), true);
		$this->assertEquals($article2->remove(), false);
		


	}
}

?>
