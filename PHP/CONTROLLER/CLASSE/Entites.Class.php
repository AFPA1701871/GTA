<?php

class Entites 
{

	/*****************Attributs***************** */

	private $_idEntite;
	private $_libelleEntite;
	private static $_attributes=["idEntite","libelleEntite"];
	/***************** Accesseurs ***************** */


	

	public function getLibelleEntite()
	{
		return $this->_libelleEntite;
	}

	public function setLibelleEntite(string $libelleEntite)
	{
		$this->_libelleEntite=$libelleEntite;
	}
	public function getIdEntite()
	{
		return $this->_idEntite;
	}

	public function setIdEntite($idEntite)
	{
		$this->_idEntite = $idEntite;
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
		return "IdEntite : ".$this->getIdEntite()."LibelleEntite : ".$this->getLibelleEntite()."\n";
	}

	
}