<?php

class Preferences 
{

	/*****************Attributs***************** */

	private $_idPreference;
	private $_idPrestation;
	private $_idUtilisateur;
	private static $_attributes=["idPreference","idPrestation","idUtilisateur"];
	/***************** Accesseurs ***************** */


	public function getIdPreference()
	{
		return $this->_idPreference;
	}

	public function setIdPreference(?int $idPreference)
	{
		$this->_idPreference=$idPreference;
	}

	public function getIdPrestation()
	{
		return $this->_idPrestation;
	}

	public function setIdPrestation(?int $idPrestation)
	{
		$this->_idPrestation=$idPrestation;
	}

	public function getIdUtilisateur()
	{
		return $this->_idUtilisateur;
	}

	public function setIdUtilisateur(?int $idUtilisateur)
	{
		$this->_idUtilisateur=$idUtilisateur;
	}

	public static function getAttributes()
	{
		return self::$_attributes;
	}

	/*****************Constructeur***************** */

	public function __construct(array $options = [])
	{
 		if (!empty($options)) // empty : renvoi vrai si le tableau est vide
		{
			$this->hydrate($options);
		}
	}
	public function hydrate($data)
	{
 		foreach ($data as $key => $value)
		{
 			$methode = "set".ucfirst($key); //ucfirst met la 1ere lettre en majuscule
			if (is_callable(([$this, $methode]))) // is_callable verifie que la methode existe
			{
				$this->$methode($value===""?null:$value);
			}
		}
	}

	/*****************Autres Méthodes***************** */

	/**
	* Transforme l'objet en chaine de caractères
	*
	* @return String
	*/
	public function toString()
	{
		return "IdPreference : ".$this->getIdPreference()."IdPrestation : ".$this->getIdPrestation()."IdUtilisateur : ".$this->getIdUtilisateur()."\n";
	}
}