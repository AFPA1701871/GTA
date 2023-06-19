<?php
class Parametres
{
	private static $_host;
	private static $_port;
	private static $_dbname;
	private static $_login;
	private static $_pwd;
	private static $_nbEltParPage;
	private static $_anneeDisponible;
	private static $_jourInformation;
	private static $_jourRelanceDebut;
	private static $_jourRelanceFin;
	private static $_assistantes;
	static function getHost()
	{
		return self::$_host;
	}

	static function getPort()
	{
		return self::$_port;
	}

	static function getDbname()
	{
		return self::$_dbname;
	}

	static function getLogin()
	{
		return self::$_login;
	}

	static function getPwd()
	{
		return self::$_pwd;
	}
	static function getNbEltParPage()
	{
		return self::$_nbEltParPage;
	}
	static function getAnneeDisponible()
	{
		return self::$_anneeDisponible;
	}
	public static function getJourInformation()
	{
		return self::$_jourInformation;
	}

	public static function getJourRelanceDebut()
	{
		return self::$_jourRelanceDebut;
	}

	public static function getJourRelanceFin()
	{
		return self::$_jourRelanceFin;
	}
	public static function getAssistantes()
	{
		return self::$_assistantes;
	}
	static function init()
	{
		if (file_exists("config.json")) {
			$parametre  = json_decode(file_get_contents("config.json"));
			self::$_host = decode($parametre->Host);
			self::$_port = $parametre->Port;
			self::$_dbname = decode($parametre->DbName);
			self::$_login = decode($parametre->Login);
			self::$_anneeDisponible = decode($parametre->AnneeDisponible);
			if (strlen($parametre->Pwd) == 0)
				self::$_pwd = $parametre->Pwd; //developpement
			else
				self::$_pwd = decode($parametre->Pwd); //production
		}
	}
	static function initByEntite($idEntite)
	{
		if (file_exists("config.json")) {
			$parametre  = json_decode(file_get_contents("config.json"));
			foreach ($parametre->Entites as $entite) {
				if ($entite->IdEntite == $idEntite) {
					self::$_nbEltParPage = decode($entite->NbEltParPage);
					self::$_jourInformation = $entite->JourInformation;
					self::$_jourRelanceDebut = $entite->JourRelanceDebut;
					self::$_jourRelanceFin = $entite->JourRelanceFin;
					self::$_assistantes = $entite->Assistantes;
				}
			}
		}
	}
}
