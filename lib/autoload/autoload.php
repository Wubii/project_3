<?php

class AutoloaderInitWubiii 
{
	private static $loader;

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitcb1f2c9f9be76fa78189eca04c280e59', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInitcb1f2c9f9be76fa78189eca04c280e59', 'loadClassLoader'));

    }

}