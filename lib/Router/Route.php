<?php 

class Route 
{
	private $url;

	private $controllerAction;
	
	// Méthode qui définit la route demandée
	private $method;

	public function __construct($url, $controllerAction, $method = RequestMethodInterface::METHOD_GET)
	{
		$this->url = $url;
		$this->controllerAction = $controllerAction;
		$this->method = $method;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function setMethod($method)
	{
		$this->method = $method;

		return $this;
	}

	public function getControllerAction()
	{
		return $this->controllerAction;
	}

	public function setControllerAction($controllerAction)
	{
		$this->controllerAction = $controllerAction;

		return $this;
	}

	public function dispatch($parameters)
	{
		$list = explode("::", $this->controllerAction);
		
		$controllerName = $list[0];
		$actionName = $list[1];

		$controller = new $controllerName;

		call_user_func_array(array($controller, $actionName), $parameters);
	}
}
