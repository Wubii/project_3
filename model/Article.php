<?php

class Article extends Entity
{
    private $id = 0;
    private $title = "";
    private $content = "";
    private $author = "Jean FORTEROCHE";
    private $date = null;

    private $isNew = true;

    // A chaque "new Article" on verifie que la table existe bien
    function __construct() 
    {
        // initialisation de la date
        $this->date = new DateTime("now");

        // Creation de la table
        if(Connexion::getConnexion()->tableExist('mb_article') == false)
        {
            // cree la table article si elle n'existe pas
            $sql = 'CREATE TABLE IF NOT EXISTS mb_article (
                id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                title VARCHAR(250) NOT NULL,
                content TEXT NOT NULL,
                author VARCHAR(40) NOT NULL,
                date DATETIME NOT NULL,
                PRIMARY KEY (id))';

            Connexion::getConnexion()->exec($sql);
            echo "Table mb_article created successfully </br>";
        }
    }

    public function persist()
    {
        
    }

    public function remove()
    {

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
} 

