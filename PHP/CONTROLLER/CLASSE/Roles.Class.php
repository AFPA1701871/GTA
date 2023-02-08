<?php

class Roles 
{

	/*****************Attributs***************** */

	private $_idRole;
	private $_nomRole;
	private static $_attributes=["idRole","nomRole"];
	/***************** Accesseurs ***************** */


	public function getIdRole()
	{
		return $this->_idRole;
	}

	public function setIdRole(?int $idRole)
	{
		$this->_idRole=$idRole;
	}

	public function getNomRole()
	{
		return $this->_nomRole;
	}

	public function setNomRole(string $nomRole)
	{
		$this->_nomRole=$nomRole;
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
		return "IdRole : ".$this->getIdRole()."NomRole : ".$this->getNomRole()."\n";
	}
}