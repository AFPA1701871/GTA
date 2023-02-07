<?php

class Associations 
{

	/*****************Attributs***************** */

	private $_idAssociation;
	private $_idPrestation;
	private $_idProjet;
	private static $_attributes=["idAssociation","idPrestation","idProjet"];
	/***************** Accesseurs ***************** */


	public function getIdAssociation()
	{
		return $this->_idAssociation;
	}

	public function setIdAssociation(?int $idAssociation)
	{
		$this->_idAssociation=$idAssociation;
	}

	public function getIdPrestation()
	{
		return $this->_idPrestation;
	}

	public function setIdPrestation(?int $idPrestation)
	{
		$this->_idPrestation=$idPrestation;
	}

	public function getIdProjet()
	{
		return $this->_idProjet;
	}

	public function setIdProjet(?int $idProjet)
	{
		$this->_idProjet=$idProjet;
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
		return "IdAssociation : ".$this->getIdAssociation()."IdPrestation : ".$this->getIdPrestation()."IdProjet : ".$this->getIdProjet()."\n";
	}
}