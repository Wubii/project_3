<?php

// on créé une fonction autoload avec en parametre le nom de la classe recherchée
function __autoload($className) 
{
	// récupère le fichier xml de configuration de l'autoload
	$paths = simplexml_load_file(__DIR__ . "/config/autoload.xml");

	foreach($paths as $path) 
	{
		$fileName = __DIR__ . "/" . $path->__toString() . "/" . $className . ".php";

		if(file_exists($fileName)) 
		{
			// inclu le contenu du fichier
			require_once($fileName);
		} 
	}
}
