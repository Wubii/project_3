<?php

class User extends Entity
{
    const ROLE_ANONYMOUS = 0;
    const ROLE_GUEST = 1;
    const ROLE_ADMIN = 2;

	private $id = 0;
    private $username = "";
    private $email = "";
    private $password = ""; 
    private $token = null;
    private $role = self::ROLE_GUEST;
    private $locked = 0;

    private static function createTableIfNeeded()
    {
        if(Connexion::getConnexion()->tableExist('mb_user') == false)
        {
            // cree la table user si elle n'existe pas
            $sql = 'CREATE TABLE IF NOT EXISTS mb_user (
                id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(40) NOT NULL,
                token VARCHAR(64),
                role SMALLINT UNSIGNED,
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
                "INSERT INTO mb_user (username, email, password, token, role, locked) VALUES (" . 
                $pdo->quote($this->username) . "," . 
                $pdo->quote($this->email) . "," . 
                $pdo->quote($this->password) . "," . 
                $pdo->quote($this->token) . "," . 
                $this->role . "," .
                $this->locked .
                ")"
            );

            $this->id = Connexion::getConnexion()->getPdo()->lastInsertId();
        }
        else
        {
            $pdo->exec(
                "UPDATE mb_user SET " .
                "username = " . $pdo->quote($this->username) . 
                ", email = " . $pdo->quote($this->email) . 
                ", password = " . $pdo->quote($this->password) .
                ", token = " . $pdo->quote($this->token) .
                ", role = " . $this->role .
                ", locked = " . $this->locked .
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
            $user = new User();

            $user->setId($data['id']);
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->setToken($data['token']);
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

        try
        {
            $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_user WHERE id=" . $id);
        
            $dataArray = $response->fetchAll();
        }
        catch(Exception $e)
        {
            return null;
        }

        if(empty($dataArray) == false)
        {
            $user = new User();

            $user->setId($dataArray[0]['id']);
            $user->setUsername($dataArray[0]['username']);
            $user->setEmail($dataArray[0]['email']);
            $user->setPassword($dataArray[0]['password']);
            $user->setToken($dataArray[0]['token']);
            $user->setRole($dataArray[0]['role']);
            $user->setLocked($dataArray[0]['locked']);

            return $user;
        }
        else
        {
            return null;
        }
    }

    public static function findByUsername($username)
    {
        // Creation de la table
        self::createTableIfNeeded();

        try
        {
            $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_user WHERE username='" . $username . "'");
        
            $dataArray = $response->fetchAll();
        }
        catch(Exception $e)
        {
            print_r($e);
            exit;

            return null;
        }

        if(empty($dataArray) == false)
        {
            $user = new User();

            $user->setId($dataArray[0]['id']);
            $user->setUsername($dataArray[0]['username']);
            $user->setEmail($dataArray[0]['email']);
            $user->setPassword($dataArray[0]['password']);
            $user->setToken($dataArray[0]['token']);
            $user->setRole($dataArray[0]['role']);
            $user->setLocked($dataArray[0]['locked']);

            return $user;
        }
        else
        {
            return null;
        }
    }

    public static function findByUsernameOrEmail($username, $email)
    {
        // Creation de la table
        self::createTableIfNeeded();

        try
        {
            $response = Connexion::getConnexion()->getPdo()->query("SELECT * FROM mb_user WHERE username='" . $username . "' OR email='" . $email . "'");
        
            $dataArray = $response->fetchAll();
        }
        catch(Exception $e)
        {
            print_r($e);
            exit;

            return null;
        }

        if(empty($dataArray) == false)
        {
            $user = new User();

            $user->setId($dataArray[0]['id']);
            $user->setUsername($dataArray[0]['username']);
            $user->setEmail($dataArray[0]['email']);
            $user->setPassword($dataArray[0]['password']);
            $user->setToken($dataArray[0]['token']);
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

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
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

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
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
}
