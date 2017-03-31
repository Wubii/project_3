<?php

class Authentification
{
    public function connect($user)
    {
        Session::getInstance()->write('auth', $user);
    }

    public function isConnected()
    {
        if(is_null(Session::getInstance()->read('auth')) == false)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function login($login, $password)
    {
        $user = User::findByUsernameOrEmail($login, $login);

        if(is_null($user) == false)
        {
            if($user->getPassword() == $password)
            {
                $this->connect($user);

                return $user;
            }
        }

        return null;
    }

    public function logout()
    {
        if($this->isConnected() == true)
        {        
            Session::getInstance()->delete('auth');
        }
    }

    // Role demandé
    public function isAuthorized($role)
    {
        $result = false;

        $user = Session::getInstance()->read('auth');

        // Si la personne n'est pas authentifiée
        if(is_null($user) == true)
        {
            if($role == User::ROLE_ANONYMOUS)
            {
                $result = true;
            }
        }
        // Si la personne est authentifiée
        else
        {
            switch($user->getRole())
            {
                case User::ROLE_GUEST:
                    
                    switch($role)
                    {   
                        case User::ROLE_ANONYMOUS:
                            $result = true;
                            break;

                        case User::ROLE_GUEST:
                            $result = true;
                            break;
                    }   

                    break;

                case User::ROLE_ADMIN:

                    switch($role)
                    {   
                        case User::ROLE_ANONYMOUS:
                            $result = true;
                            break;

                        case User::ROLE_GUEST:
                            $result = true;
                            break;

                        case User::ROLE_ADMIN:
                            $result = true;
                            break;
                    }
                    break;
            }
        }

        return $result;
    }

    public function getRole()
    {
        $user = Session::getInstance()->read('auth');

        // Si la personne n'est pas authentifiée
        if(is_null($user) == true)
        {
            return 0;
        }
        // Si la personne est authentifiée
        else
        {
            return $user->getRole();
        }
    }
}
