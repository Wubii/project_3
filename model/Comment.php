<?php

class Comment extends Entity
{
	private $id = 0;
    private $title = null;
    private $content = null;
    private $pseudo = null;
    private $date = null;
    private $articleId = 0;

    private $stmtCreate = null;
    private $stmtUpdate = null;
    private $stmtRemove = null;

    // A chaque "new Comment" on verifie que la table existe bien
    function __construct($articleId) 
    {
        // initialisation de la date
        $this->date = new DateTime("now");
        $this->articleId = $articleId;

        // Creation de la table
        if(Connexion::getConnexion()->tableExist('mb_comment') == false)
        {
            // cree la table comment si elle n'existe pas
            $sql = 'CREATE TABLE IF NOT EXISTS mb_comment (
                id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                pseudo VARCHAR(40) NOT NULL,
                date DATETIME NOT NULL,
                articleId SMALLINT UNSIGNED NOT NULL,
                PRIMARY KEY (id),
                FOREIGN KEY (articleId) REFERENCES mb_article(id))';

            Connexion::getConnexion()->exec($sql);
        }

        // CREATE new comment
        $this->stmtCreate = Connexion::getConnexion()->getPdo()->prepare("INSERT INTO mb_comment (title, content, pseudo, date, articleId) VALUES (:title, :content, :pseudo, :date, :articleId)");
        
        // UPDATE comment
        $this->stmtUpdate = Connexion::getConnexion()->getPdo()->prepare("UPDATE mb_comment SET title = :title, content = :content, pseudo = :pseudo, date = :date WHERE id = :id");
    }

    public function persist()
    {
    	if($this->id == 0)
        {
            $this->stmtCreate->execute(array(
                'title' => $this->title,
                'content' => $this->content,
                'pseudo' => $this->pseudo,
                'date' => $this->date->format("Y-m-d H:i:s"),
                'articleId' => $this->articleId
            ));

            $this->id = Connexion::getConnexion()->getPdo()->lastInsertId();
        }
        else
        {
            $this->stmtUpdate->execute(array(
                'title' => $this->title,
                'content' => $this->content,
                'pseudo' => $this->pseudo,
                'date' => $this->date->format("Y-m-d H:i:s"),
                'id' => $this->id
            ));
        }
    }

    public static function findAll()
    {
        $comments = array();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_comment");


        while($data = $response->fetch())
        {
            $comment = new Comment(0);

            $comment->setId($data['id']);
            $comment->setTitle($data['title']);
            $comment->setContent($data['content']);
            $comment->setPseudo($data['pseudo']);
            $comment->setDate(new DateTime($data['date']));

            array_push($comments, $comment);
        }

        $response->closeCursor();

        return $comments;
    }

    public static function findAllByArticle($article)
    {
        $comments = array();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_comment INNER JOIN mb_article WHERE mb_comment.articleId = " . $article->getId());


        while($data = $response->fetch())
        {
            $comment = new Comment($article->getId());

            $comment->setId($data['id']);
            $comment->setTitle($data['title']);
            $comment->setContent($data['content']);
            $comment->setPseudo($data['pseudo']);
            $comment->setDate(new DateTime($data['date']));
            $comment->setArticleId($data['articleId']);

            array_push($comments, $comment);
        }

        $response->closeCursor();

        return $comments;
    }

    public static function findById($id)
    {
        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_comment WHERE id=" . $id);
        
        $dataArray = $response->fetchAll();
        if(empty($dataArray) == false)
        {
            $comment = new Comment();

            $comment->setId($dataArray[0]['id']);
            $comment->setTitle($dataArray[0]['title']);
            $comment->setContent($dataArray[0]['content']);
            $comment->setPseudo($dataArray[0]['pseudo']);
            $comment->setDate(new DateTime($dataArray[0]['date']));
            $comment->setArticleId($data['articleId']);

            return $comment;
        }
        else
        {
            return null;
        }
    }

    public function remove()
    {
    	try
        {
            Connexion::getConnexion()->getPdo()->exec("DELETE FROM mb_comment WHERE id=" . $this->id);
        }
        catch(Exception $e)
        { 
            return false;
        } 

        return true;
    }

   public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;

        return $this;
    }

    public function getArticleId()
    {
        return $this->articleId;
    }
}
