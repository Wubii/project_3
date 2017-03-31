<?php

class SessionController extends Controller
{
	private function str_random($length)
	{
    	$alphabet = "azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    	
    	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
	}

	public function registerAction()
	{
		$auth = new Authentification();

		echo self::$twig->load('session/register.html.twig')->render(array(
			'session' => Session::getInstance(),
			'role' => $auth->getRole()
		));	
	}

	public function registerSubmitAction($username, $email, $password)
	{
		$session = Session::getInstance();

		// Vérifier que l'utilisateur n'est pas déjà enregistrer : recherche par username et par email
		$user = User::findByUsernameOrEmail($username, $email);

		if(is_null($user) == false)
		{
			$session->setFlash('<div class="animation"> Le login ou l\'adresse email est déjà utilisé, veuillez en changer </div>');
			
			header('Location: /session/register');

			exit;	
		}

		$user = new User();

		$user->setUsername($username);
		$user->setEmail($email);
		$user->setPassword($password);
		$user->setToken($this->str_random(63));

		$user->persist();

		// Envoie du mail de confirmation

		$mail = new PHPMailer;

		// Server mail : Simple Mail Transfer Protocol (API)
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'jean.forteroche@gmail.com';        // SMTP username
		$mail->Password = 'Ardcpp64';                         // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		// port smpt 
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom('jean.forteroche@gmail.com', 'Jean Forteroche');
		$mail->addAddress($email);

		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Confirmation de votre compte';
		//$mail->Body    = 'Afin de valider votre compte merci de cliquer sur ce <a href="http://project3/session/confirm?id=' . $user->getId() . '&token=' . $user->getToken() . '"><b>lien</b></a>';

        $mail->Body    = 'Afin de valider votre compte merci de cliquer sur ce <a href="http://jeanforteroche.wubiii.com/session/confirm?id=' . $user->getId() . '&token=' . $user->getToken() . '"><b>lien</b></a>';

		// Affiche les erreurs
		$session = Session::getInstance();

		if(!$mail->send())
		{
	    	$session->setFlash('Mailer Error: ' . $mail->ErrorInfo, "danger");
		}
		else
		{
	    	$session->setFlash('<div class="animation"> Un message vient d être envoyé sur votre adresse mail, veuillez confirmer votre insription </div>' , "success");
		}

		header('Location: /');	
	}

	public function confirmAction($id, $token = null)
	{
		$session = Session::getInstance();

		$user = User::findById($id);
		
		if(is_null($user) == false)
		{
			if($user->getToken() == $token)
			{
				$user->setToken(null);

				$user->persist();

				$session->setFlash('<div class="animation"> Vous êtes bien enregistré, veuillez vous connecter </div>' , "success");

				header('Location: /session/login');

				exit;
			}
			else 
			{
				$session->setFlash('<div class="animation"> Le compte n\'est pas valide </div>');
			}
		}
		else
		{
			$session->setFlash('<div class="animation"> Identifiant non valide : veuillez vous enregistrer </div>');
		}

		header('Location: /');
	}

	public function loginAction()
	{
		$auth = new Authentification();

		echo self::$twig->load('session/login.html.twig')->render(array(
			'session' => Session::getInstance(),
			'role' => $auth->getRole()
		));
	}

	public function loginSubmitAction($login, $password)
	{
		$session = Session::getInstance();

		$auth = new Authentification();

		if($auth->isConnected() == true)
		{
			$session->setFlash('<div class="animation"> Vous êtes déjà authentifié </div>');

			header('Location: /');

			exit;
		}

		$user = $auth->login($login, $password);

		if($user == true)
		{
			$session->setFlash('<div class="animation"> Bienvenue ' . $user->getUsername() . ', je vous laisse découvrir mon livre </div>', 'info');
			
			header('Location: /');
		}
		else
		{
			$session->setFlash('<div class="animation"> Identifiant ou mot de passe non valide : veuillez d\'abord vous enregistrer </div>');	
			
			header('Location: /session/login');
		}
	}

	public function logoutAction()
	{
		$session = Session::getInstance();

		$auth = new Authentification();

		$auth->logout();

		$session->setFlash('<div class="animation"> Vous êtes bien déconnecté. À bientôt ! </div>', 'info');

		header('Location: /');
	}
}

?>
