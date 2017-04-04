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

		$mail->Subject = 'Confirmation de votre compte sur le site jeanforteroche.com';
		$mail->Body    = 'Bonjour ' . $user->getUsername() .'<br><br>Merci de vous être enregistré sur mon site, afin de valider votre compte cliquez sur le <a href="http://project3/session/confirm?id=' . $user->getId() . '&token=' . $user->getToken() . '"><b>lien</b></a> suivant <br><h3>Il ne me reste plus qu\'à vous souhaiter une bonne lecture et n\'hésitez pas à laisser des commentaires ! </h3></a><br><br>Jean Forteroche';

        //$mail->Body    = 'Afin de valider votre compte merci de cliquer sur ce <a href="http://jeanforteroche.wubiii.com/session/confirm?id=' . $user->getId() . '&token=' . $user->getToken() . '"><b>lien</b></a>';

		// Affiche les erreurs
		$session = Session::getInstance();

		if(!$mail->send())
		{
	    	$session->setFlash('Mailer Error: ' . $mail->ErrorInfo, "danger");
		}
		else
		{
	    	$session->setFlash('Un message vient d\'être envoyé sur votre adresse mail, veuillez confirmer votre insription ' , "success");
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

				$session->setFlash('Vous êtes bien enregistré, vous pouvez vous connecter ' , "success");

				header('Location: /session/login');

				exit;
			}
			else 
			{
				$session->setFlash('Le compte n\'est pas valide ');
			}
		}
		else
		{
			$session->setFlash('Identifiant ou mot de passe non valide. Si vous êtes un nouvel arrivant, veuillez d\'abord vous enregistrer ');
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
			$session->setFlash('Vous êtes déjà authentifié');

			header('Location: /');

			exit;
		}

		$user = $auth->login($login, $password);

		

		if(is_null($user) == false)
		{
			if($user->getLocked() == true)
			{
				$auth->logout();

				$session->setFlash('L\'administrateur du site a bloqué votre compte');

				header('Location: /');

				exit;
			}

			$session->setFlash('Bienvenue ' . $user->getUsername() . ', je vous laisse découvrir mon livre', 'info');
			
			header('Location: /');
		}
		else
		{
			$session->setFlash('Identifiant ou mot de passe non valide. Si vous êtes un nouvel arrivant, veuillez d\'abord vous enregistrer');	
			
			header('Location: /session/login');
		}
	}

	public function logoutAction()
	{
		$session = Session::getInstance();

		$auth = new Authentification();

		$auth->logout();

		$session->setFlash('Vous êtes bien déconnecté. À bientôt !', 'info');

		header('Location: /');
	}
}

?>
