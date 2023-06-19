<?php

class Activites 
{

	/*****************Attributs***************** */

	private $_idActivite;
	private $_idEntite;
	private $_libelleActivite;
	private static $_attributes=["idActivite","idEntite","libelleActivite"];
	/***************** Accesseurs ***************** */


	public function getIdActivite()
	{
		return $this->_idActivite;
	}

	public function setIdActivite(?int $idActivite)
	{
		$this->_idActivite=$idActivite;
	}

	public function getLibelleActivite()
	{
		return $this->_libelleActivite;
	}

	public function setLibelleActivite(string $libelleActivite)
	{
		$this->_libelleActivite=$libelleActivite;
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
		return "IdActivite : ".$this->getIdActivite()."LibelleActivite : ".$this->getLibelleActivite()."\n";
	}

	
}