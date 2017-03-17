<?php

class User extends Entity
{
	private $id = 0;
    private $username;
    private $mail;
    private $password;
    private $role;
    private $locked = 0;

    private static function createTableIfNeeded()
    {
        if(Connexion::getConnexion()->tableExist('mb_user') == false)
        {
            // cree la table user si elle n'existe pas
            $sql = 'CREATE TABLE IF NOT EXISTS mb_user (
                id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                username VARCHAR(255) NOT NULL,
                mail VARCHAR(255) NOT NULL,
                password VARCHAR(40) NOT NULL,
                role VARCHAR(255) NOT NULL UNSIGNED,
                locked SMALLINT UNSIGNED,
                PRIMARY KEY (id))';

            Connexion::getConnexion()->exec($sql);
        }
    }

    // A chaque "new user" on verifie que la table existe bien
    function __construct() 
    {
        // Creation de la table
        self::createTableIfNeeded();
    }

    public function persist()
    {
        $pdo = Connexion::getConnexion()->getPdo();

    	if($this->id == 0)
        {
            $pdo->exec(
                "INSERT INTO mb_user (username, mail, password, role, locked) VALUES (" . 
                $pdo->quote($this->username) . "," . 
                $pdo->quote($this->mail) . ",'" . 
                $pdo->quote($this->password) . "','" . 
                $this->role . "," .
                $this->locked . "," .
                ")"
            );

            $this->id = Connexion::getConnexion()->getPdo()->lastInsertId();
        }
        else
        {
            $pdo->exec(
                "UPDATE mb_user SET " .
                "username = " . $pdo->quote($this->username) . 
                ", mail = " . $pdo->quote($this->mail) . 
                ", password = '" . $pdo->quote($this->password) . "'" .
                ", role = '" . $this->role . "'" .
                ", locked = '" . $this->locked . "'" .
                " WHERE id = " . $this->id
            );
        }
    }

    public static function findAll()
    { 
        // Creation de la table
        self::createTableIfNeeded();

        $users = array();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_user");


        while($data = $response->fetch())
        {
            $users = new User();

            $user->setId($data['id']);
            $user->setUsername($data['username']);
            $user->setMail($data['mail']);
            $user->setPassword($data['password']);
            $user->setRole($data['role']);
            $user->setLocked($data['locked']);

            array_push($users, $user);
        }

        $response->closeCursor();

        return $users;
    }

    public static function findById($id)
    {
        // Creation de la table
        self::createTableIfNeeded();

        $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_user WHERE id=" . $id);
        
        $dataArray = $response->fetchAll();
        if(empty($dataArray) == false)
        {
            $user = new User();

            $user->setId($dataArray[0]['id']);
            $user->setUsername($dataArray[0]['username']);
            $user->setMail($dataArray[0]['mail']);
            $user->setPassword($dataArray[0]['password']);
            $user->setRole($dataArray[0]['role']);
            $user->setLocked($dataArray[0]['locked']);

            return $user;
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
            Connexion::getConnexion()->getPdo()->exec("DELETE FROM mb_user WHERE id=" . $this->id);
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

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    public function getLocked()
    {
        return $this->locked;
    }

    public function getUsers()
    {
        return User::findAll($this);
    }
}
