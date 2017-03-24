<?php

class SessionController extends Controller
{
	private function str_random($length)
	{
    	$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    	
    	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
	}

	public function registerAction()
	{
		echo self::$twig->load('session/register.html.twig')->render();		
	}

	public function registerSubmitAction($username, $email, $password)
	{
		// Vérifier que l'utilisateur n'est pas déjà enregistrer : recherche par username et par email

		$user = new User();

		$user->setUsername($username);
		$user->setEmail($email);
		$user->setPassword($password);
		$user->setToken($this->str_random(63));

		$user->persist();

		$mail = new PHPMailer;

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'jean.forteroche@gmail.com';        // SMTP username
		$mail->Password = 'Ardcpp64';                         // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom('jean.forteroche@gmail.com', 'Mailer');
		$mail->addAddress($email);

		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Confirmation de votre compte';
		$mail->Body    = 'Afin de valider votre compte merci de cliquer sur ce <a href="http://jeanforteroche.wubiii.com/session/confirm?token=' . $user->getToken() . '"><b>lien</b></a>';

		$session = Session::getInstance();

		if(!$mail->send())
		{
	    	$session->setFlash('Mailer Error: ' . $mail->ErrorInfo, "danger");
		}
		else
		{
	    	$session->setFlash('Message has been sent', "success");
		}

		header('Location: /');	
	}

	public function confirmAction()
	{
		
	}

	public function loginAction()
	{
		echo self::$twig->load('session/login.html.twig')->render();
	}

	public function loginSubmitAction($username, $password)
	{
		header('Location: /');
	}

	public function logoutAction()
	{
		
	}
}

?>
