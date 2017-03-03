<?php

// lorsqu'on instancie une class le constructeur est forcement appele
// class singleton = globale a toute l'application //constante
class Connexion
{
    // Initialisation des variables globales
    //mettre dans un variable
    private static $connexion = null;

    private $pdo = null;
    private $host = "localhost";
    private $login = "root";
    private $password = "Wombat64";
    private $dbName = "mb_forteroche";

    // Constructeur de la méthode

    private function __construct() 
    {
        try
        {
            $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=utf8', $this->login, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->getMessage());

        } 
    }

    // Méthode qui appelle le constructeur de la classe

    public static function getConnexion()
    {
        if(is_null(self::$connexion))
        {
            self::$connexion = new self();
        }  
    
        return self::$connexion;
    }
 
    // Initialise l'objet PDO

    public function getPdo()
    {
        return $this->pdo;
    }


    public function tableExist($name)
    {
        // requete sql qui sélectionne la table que l'on souhaite : $name
        $sql = 'SELECT 1 FROM ' . $name . ' LIMIT 1 ';
        
        try
        {
            $result = $this->pdo->query($sql);
        }
        catch(Exception $e)
        {
            //echo "La table <b>" . $name . "</b> n'existe pas </br>";
            return false;
        } 
        
        //echo "La table <b>" . $name . "</b> existe deja </br>";
        return true;  
    }


    public function query($statement)
    {
        return $this->pdo->query($statement);
    }


    public function exec($statement)
    {
        return $this->pdo->exec($statement);
    }
}
