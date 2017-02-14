<?php

require_once __DIR__ . "/../autoload.php";

class Controller1
{
	function toString()
	{
		$model1 = new Model1();

		return "controller1 " . $model1->toString();
	}
}
