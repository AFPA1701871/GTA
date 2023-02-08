<?php

class ActivitesParTypes 
{

	/*****************Attributs***************** */

	private $_idActivitesParTypes;
	private $_idTypePrestation;
	private $_idActivite;
	private static $_attributes=["idActivitesParTypes","idTypePrestation","idActivite"];
	/***************** Accesseurs ***************** */


	public function getIdActivitesParTypes()
	{
		return $this->_idActivitesParTypes;
	}

	public function setIdActivitesParTypes(?int $idActivitesParTypes)
	{
		$this->_idActivitesParTypes=$idActivitesParTypes;
	}

	public function getIdTypePrestation()
	{
		return $this->_idTypePrestation;
	}

	public function setIdTypePrestation(?int $idTypePrestation)
	{
		$this->_idTypePrestation=$idTypePrestation;
	}

	public function getIdActivite()
	{
		return $this->_idActivite;
	}

	public function setIdActivite(?int $idActivite)
	{
		$this->_idActivite=$idActivite;
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
		return "IdActivitesParTypes : ".$this->getIdActivitesParTypes()."IdTypePrestation : ".$this->getIdTypePrestation()."IdActivite : ".$this->getIdActivite()."\n";
	}
}