<?php

class Router
{
	private $routes = array();
	private $namedRoutes = array();

	public function __construct($routes)
	{
		$this->routes = $routes;
	}

	public function matchCurrentRequest()
	{
		$requestUrl = $_SERVER['REQUEST_URI'];
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		$requestParameters = "";

		// strpos renvoie la position de '?' 
		// substr garde la chaine de caractère comprise entre le début de la chaine et le caractère '?'
		if (($pos = strpos($requestUrl, '?')) !== false) 
		{
            $requestParameters	= substr($requestUrl, $pos + 1, strlen($requestUrl) - ($pos + 1));
            
            $requestUrl = substr($requestUrl, 0, $pos);
        }

		foreach($this->routes as $route)
		{
			if($route->getUrl() !== $requestUrl)
			{
				continue;
			}

			if($route->getMethod() !== $requestMethod)
			{
				continue;
			}

			$parameters = array();

			switch($requestMethod)
			{
				case RequestMethodInterface::METHOD_GET:

		            foreach(explode("&", $requestParameters) as $parameter)
		            {
		            	$list = explode("=", $parameter);

		            	if(count($list) !== 2)
		            	{
		            		continue;
		            	}

		            	$parameters[$list[0]] = $list[1];
		            }

					break;

				case RequestMethodInterface::METHOD_POST:
					$parameters = $_POST;
					break;
				
				case RequestMethodInterface::METHOD_PUT:
					break;
				
				case RequestMethodInterface::METHOD_DELETE:
					echo "DELETE";
					break;				
			}

			$auth = new Authentification();

			// Si la personne est pas autorisée 
			if($auth->isAuthorized($route->getRole()) == false)
			{
				$session = Session::getInstance();
					
				if($auth->isConnected() == true)
				{
					$session->setFlash('<div class="animation"> Vous n\'êtes pas authorisé à consulter cette page </div>');
				
					header('Location: /');
				}
				else
				{
					header('Location: /session/login');
				}

				exit;
			}

			$route->dispatch($parameters);
		}
	}
}