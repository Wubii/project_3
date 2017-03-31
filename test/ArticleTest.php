<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../autoload.php';

class ArticleTest extends TestCase
{
	private $id = 4;
	private $title = "title";
	private $content = "blablablabla";
	private $author = "Jean Giono";
	private $date = new DateTime("now");


	private $updatedId = 4;
	private $updatedTitle = "title has been updated";
	private $updatedContent = "content has been updated";
	private $updatedAuthor = "Jean Giono updated";
	private $date = new DateTime("now");

	public function testArticleCreation()
	{
		$article = new Article();

		$this->assertEquals($article->getId(), $this->id);
		$this->assertEquals($article->getTitle(), $this->title);
		$this->assertEquals($article->getContent(), $this->content);
		$this->assertEquals($article->getAuthor(), $this->author);
	}

	public function testArticleSetter()
	{
		$date = new DateTime("now");

		$article = new Article();

		$article->setId($this->id);
		$article->setTitle($this->updatedTitle);
		$article->setContent($this->updatedContent);
		$article->setAuthor($this->updatedAuthor);
		$article->setDate($this->updatedDate);
	}

	public function testArticleGetter()
	{
		$article = new Article();

		$this->assertEquals($article->getId(), 4);
		$this->assertEquals($article->getTitle(), $this->updatedTitle);
		$this->assertEquals($article->getContent(), $this->updatedContent);
		$this->assertEquals($article->getAuthor(), $this->updatedAuthor);
		$this->assertEquals($article->getDate(), $this->updatedDate);
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
