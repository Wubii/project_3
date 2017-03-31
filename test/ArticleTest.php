<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../autoload.php';

class ArticleTest extends TestCase
{
	private $id = 4;
	private $title = "title";
	private $content = "blablablabla";
	private $author = "Jean Giono";
	private $date;

	public function __construct()
	{
		$date = new DateTime("now");
	}

	private $updatedId = 4;
	private $updatedTitle = "title has been updated";
	private $updatedContent = "content has been updated";
	private $updatedAuthor = "Jean Giono updated";

	public function testArticleCreation()
	{
		$article = new Article();

		$this->assertEquals($article->getId(), 0);
		$this->assertEquals($article->getTitle(), "");
		$this->assertEquals($article->getContent(), "");
		$this->assertEquals($article->getAuthor(), "Jean FORTEROCHE");
	}

	public function testArticleSetter()
	{
		$article = new Article();

		$article->setId($this->id);
		$article->setTitle($this->updatedTitle);
		$article->setContent($this->updatedContent);
		$article->setAuthor($this->updatedAuthor);
		$article->setDate($this->date);
	}

	public function testArticleGetter()
	{
		$article = new Article();

		$articleId = $article->getId();
		$articleTitle = $article->getTitle();
		$articleContent = $article->getContent();
		$articleAuthor = $article->getAuthor();
		$articleDate = $article->getDate();

		var_dump($articleId);


		$this->assertEquals($article->getId(), $this->id);
		$this->assertEquals($article->getTitle(), $this->updatedTitle);
		$this->assertEquals($article->getContent(), $this->updatedContent);
		$this->assertEquals($article->getAuthor(), $this->updatedAuthor);
		$this->assertEquals($article->getDate(), $this->date);
	}

	public function testArticlePersist()
	{
		$date = new DateTime("now");

		$article = new Article();

		$article->setTitle($this->title);
		$article->setContent($this->content);
		$article->setAuthor($this->author);
		$article->setDate($date);

		$article->persist();
		$id = $article->getId();

		$article2 = Article::findById($id);

		$this->assertEquals($article2->getId(), $id);
		$this->assertEquals($article2->getTitle(), $this->title);
		$this->assertEquals($article2->getContent(), $this->content);
		$this->assertEquals($article2->getAuthor(), $this->author);
		$this->assertEquals($article2->getDate(), $date);
	}

	public function testArticleRemove()
	{
		$article = new Article();

		$article->persist();

		$id = $article->getId();

		$article2 = Article::findById($id);
		
		$this->assertEquals($article2->remove(), true);
		//$this->assertEquals($article2->remove(), false);
	}
}

?>
