<?php

require_once __DIR__ . "/../autoload.php";

class Controller1
{
	function toStringAction()
	{
		$model1 = new Model1();

		echo "controller1 </br>" . $model1->toString();
	}
}
