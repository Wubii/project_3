<?php

class Comment extends Entity
{
    const LEVEL_MAX = 3;

	private $id = 0;
    private $title = null;
    private $content = null;
    private $pseudo = null;
    private $date = null;
    private $articleId = 0;
    private $commentId = 0;
    private $level = 0;
    private $alert = 0;

    private $comments = array();

    private static function createTableIfNeeded()
    {
        if(Connexion::getConnexion()->tableExist('mb_comment') == false)
        {
            // cree la table comment si elle n'existe pas
            $sql = 'CREATE TABLE IF NOT EXISTS mb_comment (
                id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                pseudo VARCHAR(40) NOT NULL,
                date DATETIME NOT NULL,
                articleId SMALLINT UNSIGNED,
                commentId SMALLINT UNSIGNED,
                level SMALLINT UNSIGNED,
                alert TINYINT UNSIGNED,
                PRIMARY KEY (id))';

            Connexion::getConnexion()->exec($sql);
        }
    }

    // A chaque "new Comment" on verifie que la table existe bien
    function __construct($articleId, $commentId = 0, $level = 1) 
    {
        // initialisation de la date
        $this->date = new DateTime("now");
        $this->articleId = $articleId;
        $this->commentId = $commentId;
        $this->level = $level;

        // Creation de la table
        self::createTableIfNeeded();
        
    }

    public function persist()
    {
        $pdo = Connexion::getConnexion()->getPdo();

    	if($this->id == 0)
        {
            $pdo->exec(
                "INSERT INTO mb_comment (title, content, pseudo, date, articleId, commentId, level, alert) VALUES (" . 
                $pdo->quote($this->title) . "," . 
                $pdo->quote($this->content) . ",'" . 
                $this->pseudo . "','" . 
                $this->date->format("Y-m-d H:i:s") . "'," . 
                $this->articleId . "," .
                $this->commentId . "," .
                $this->level . "," .
                $this->alert . 
                ")"
            );

            $this->id = Connexion::getConnexion()->getPdo()->lastInsertId();
        }
        else
        {
            $pdo->exec(
                "UPDATE mb_comment SET " .
                "title = " . $pdo->quote($this->title) . 
                ", content = " . $pdo->quote($this->content) . 
                ", pseudo = '" . $this->pseudo . "'" .
                ", date = '" . $this->date->format("Y-m-d H:i:s") . "'" .
                ", articleId = " . $this->articleId .
                ", commentId = " . $this->commentId .
                ", level = " . $this->level .
                ", alert = " . $this->alert .
                " WHERE id = " . $this->id
            );
        }
    }

    public static function findAll()
    { 
        // Creation de la table
        self::createTableIfNeeded();

        $comments = array();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_comment");


        while($data = $response->fetch())
        {
            $comment = new Comment($data['articleId'], $data['commentId'], $data['level']);

            $comment->setId($data['id']);
            $comment->setTitle($data['title']);
            $comment->setContent($data['content']);
            $comment->setPseudo($data['pseudo']);
            $comment->setDate(new DateTime($data['date']));
            $comment->setAlert($data['alert']);

            array_push($comments, $comment);
        }

        $response->closeCursor();

        return $comments;
    }

    public static function findById($id)
    {
        // Creation de la table
        self::createTableIfNeeded();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_comment WHERE id=" . $id);
        
        $dataArray = $response->fetchAll();
        if(empty($dataArray) == false)
        {
            $comment = new Comment($dataArray[0]['articleId'], $dataArray[0]['commentId'], $dataArray[0]['level']);

            $comment->setId($dataArray[0]['id']);
            $comment->setTitle($dataArray[0]['title']);
            $comment->setContent($dataArray[0]['content']);
            $comment->setPseudo($dataArray[0]['pseudo']);
            $comment->setDate(new DateTime($dataArray[0]['date']));
            $comment->setAlert($dataArray[0]['alert']);

            return $comment;
        }
        else
        {
            return null;
        }
    }

    public static function findAllByArticle($article)
    {
        // Creation de la table
        self::createTableIfNeeded();

        $comments = array();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_comment WHERE articleId = " . $article->getId() . " ORDER BY id DESC");

        while($data = $response->fetch())
        {
            $comment = new Comment($data['articleId'], $data['commentId'], $data['level']);

            $comment->setId($data['id']);
            $comment->setTitle($data['title']);
            $comment->setContent($data['content']);
            $comment->setPseudo($data['pseudo']);
            $comment->setDate(new DateTime($data['date']));
            $comment->setAlert($data['alert']);

            $comments[$comment->getId()] = $comment;
        }

        $response->closeCursor();

        // 1ère boucle level = 3, 2ème boucle level = 2
        for($level = self::LEVEL_MAX; $level > 1; $level--)
        {
            foreach ($comments as $key => $comment) 
            {
                if($comment->getLevel() == $level)
                {
                    // Ajoute le commentaire à son parent
                    $comments[$comment->getCommentId()]->addComment($comment);

                    // Supprime cette key du tableau "comments"
                    unset($comments[$key]);
                }
            }
        }

        return $comments;
    }

    public static function findAllByAlert()
    {
        // Creation de la table
        self::createTableIfNeeded();

        $comments = array();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_comment WHERE alert = 1 ");

        while($data = $response->fetch())
        {
            $comment = new Comment($data['articleId'], $data['commentId'], $data['level']);

            $comment->setId($data['id']);
            $comment->setTitle($data['title']);
            $comment->setContent($data['content']);
            $comment->setPseudo($data['pseudo']);
            $comment->setDate(new DateTime($data['date']));
            $comment->setAlert($data['alert']);

            array_push($comments, $comment);
        }

        $response->closeCursor();

        return $comments;
    }

    public static function findAllByComment($comment)
    {
        // Creation de la table
        self::createTableIfNeeded();

        $comments = array();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_comment WHERE commentId = " . $comment->getId());

        while($data = $response->fetch())
        {
            $comment = new Comment($data['articleId'], $data['commentId'], $data['level']);

            $comment->setId($data['id']);
            $comment->setTitle($data['title']);
            $comment->setContent($data['content']);
            $comment->setPseudo($data['pseudo']);
            $comment->setDate(new DateTime($data['date']));
            $comment->setAlert($data['alert']);

            array_push($comments, $comment);
        }

        $response->closeCursor();

        return $comments;
    }

    public function remove()
    {
        $comments = $this->findAllByComment($this);

        foreach ($comments as $comment) 
        {
            // Fonction recursive : on appelle le remove depuis le remove sur un objet different : les enfants du commentaire
            $comment->remove();
        }

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

    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;

        return $this;
    }

    public function getCommentId()
    {
        return $this->commentId;
    }

    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setAlert($alert)
    {
        $this->alert = $alert;

        return $this;
    }

    public function getAlert()
    {
        return $this->alert;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function addComment($comment)
    {
        array_push($this->comments, $comment);

        return $this; 
    }
}
