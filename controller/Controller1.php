<?php

class Controller1
{
	function toStringAction()
	{
		$model1 = new Model1();

		echo "Cette URL appelle le Controller1 et la fonction toStringAction() qui affiche le contenu de l'objet model1 : <b>" . $model1->toString() . "</b>";
	}
}
