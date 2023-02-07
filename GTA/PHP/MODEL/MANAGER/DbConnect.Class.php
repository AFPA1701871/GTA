<?php
class DbConnect{
	private static $db;

	public static function getDb()
	{
		return DbConnect::$db;
	}

	public static function init()
	{
		try {
			self::$db= new PDO ( 'mysql:host='. Parametres::getHost().';port='. Parametres::getPort() .';dbname='. Parametres::getDbname().';charset=utf8', Parametres::getLogin(), Parametres::getPwd());
		}
		catch (Exception $e)
		{
			die('Erreur :'. $e->getMessage());
		}
	}
}