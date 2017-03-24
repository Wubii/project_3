<?php

class Session
{
    static $instance;

    static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new Session();
        }

        return self::$instance;
    }

    public function __construct()
    {
        session_start();
    }

    public function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function read($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public function setFlash($message, $type = 'danger')
    {
        $_SESSION['flash'] = array(
            "message" => $message,
            "type" => $type
        );
    }

    public function hasFlash()
    {
        return isset($_SESSION['flash']);
    }

    public function getFlash()
    {
        $flash = '';

        if(isset($_SESSION['flash']))
        {    
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        return $flash;
    }
}
