<?php

class Article extends Entity
{
    private $id = 0;
    private $title = "";
    private $content = "";
    private $author = "Jean FORTEROCHE";
    private $date = null;

    private $comments = array();
    private $newComments = array();

    private static function createTableIfNeeded()
    {
        // Creation de la table
        if(Connexion::getConnexion()->tableExist('mb_article') == false)
        {
            // cree la table article si elle n'existe pas
            $sql = 'CREATE TABLE IF NOT EXISTS mb_article (
                id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                author VARCHAR(40) NOT NULL,
                date DATETIME NOT NULL,
                PRIMARY KEY (id))';

            Connexion::getConnexion()->exec($sql);
            //echo "Table mb_article created successfully </br>";
        }
    }

    // A chaque "new Article" on verifie que la table existe bien
    public function __construct() 
    {
        // initialisation de la date
        $this->date = new DateTime("now");

        self::createTableIfNeeded();
        
    }

    public function addComment($comment)
    {
        array_push($this->newComments, $comment);
    }

    public function removeComment($comment)
    {

    }

    public function persist()
    {
        $pdo = Connexion::getConnexion()->getPdo();

        if($this->id == 0)
        {
            $pdo->exec(
                "INSERT INTO mb_article (title, content, author, date) VALUES (" . 
                $pdo->quote($this->title) . "," . 
                $pdo->quote($this->content) . ",'" . 
                $this->author . "','" . 
                $this->date->format("Y-m-d H:i:s") . 
                "')"
            );

            $this->id = Connexion::getConnexion()->getPdo()->lastInsertId();
        }
        else
        {

            $pdo->exec(
                "UPDATE mb_article SET " .
                "title = " . $pdo->quote($this->title) . 
                ", content = " . $pdo->quote($this->content) . 
                ", author = '" . $this->author . 
                "', date = '" . $this->date->format("Y-m-d H:i:s") . 
                "' WHERE id = " . $this->id
            );
        }

        $newComments = array();
    }

    public function remove()
    {
        try
        {
            Connexion::getConnexion()->getPdo()->exec("DELETE FROM mb_article WHERE id=" . $this->id);
        }
        catch(Exception $e)
        { 
            return false;
        } 

        return true;
    }

    public static function findAll()
    {
        self::createTableIfNeeded();

        $articles = array();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_article");

        while($data = $response->fetch())
        {
            $article = new Article();

            $article->setId($data['id']);
            $article->setTitle($data['title']);
            $article->setContent($data['content']);
            $article->setAuthor($data['author']);
            $article->setDate(new DateTime($data['date']));

            array_push($articles, $article);
        }

        $response->closeCursor();

        return $articles;
    }

    public static function findById($id)
    {
        self::createTableIfNeeded();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_article WHERE id=" . $id);
        
        $dataArray = $response->fetchAll();

        if(empty($dataArray) == false)
        {
            $article = new Article();

            $article->setId($dataArray[0]['id']);
            $article->setTitle($dataArray[0]['title']);
            $article->setContent($dataArray[0]['content']);
            $article->setAuthor($dataArray[0]['author']);
            $article->setDate(new DateTime($dataArray[0]['date']));

            return $article;
        }
        else
        {
            return null;
        }
    }

    public static function findLastOne()
    {
        self::createTableIfNeeded();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_article ORDER BY date DESC LIMIT 1");
        
        $dataArray = $response->fetchAll();

        $data = end($dataArray);

        if(is_null($data) == false)
        {
            $article = new Article();

            $article->setId($data['id']);
            $article->setTitle($data['title']);
            $article->setContent($data['content']);
            $article->setAuthor($data['author']);
            $article->setDate(new DateTime($data['date']));

            return $article;
        }
        else
        {
            return null;
        }   
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

    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
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

    public function getComments()
    {
        return Comment::findAllByArticle($this);
    }
} 

