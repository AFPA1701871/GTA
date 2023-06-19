<?php

class Contrats 
{

	/*****************Attributs***************** */

	private $_idContrat;
	private $_idEntite;
	private $_idCentre;
	private $_idUtilisateur;
	private $_dateDebutContrat;
	private $_dateFinContrat;
	private static $_attributes=["idContrat","idEntite","idCentre","idUtilisateur","dateDebutContrat","dateFinContrat"];
	/***************** Accesseurs ***************** */


	public function getIdContrat()
	{
		return $this->_idContrat;
	}

	public function setIdContrat(?int $idContrat)
	{
		$this->_idContrat=$idContrat;
	}

	public function getIdCentre()
	{
		return $this->_idCentre;
	}

	public function setIdCentre(?int $idCentre)
	{
		$this->_idCentre=$idCentre;
	}

	public function getIdUtilisateur()
	{
		return $this->_idUtilisateur;
	}

	public function setIdUtilisateur(?int $idUtilisateur)
	{
		$this->_idUtilisateur=$idUtilisateur;
	}

	public function getDateDebutContrat()
	{
		return is_null($this->_dateDebutContrat)?null:$this->_dateDebutContrat->format('Y-n-j');
	}

	public function setDateDebutContrat(string $dateDebutContrat)
	{
		$this->_dateDebutContrat=DateTime::createFromFormat("Y-n-j",$dateDebutContrat);
	}

	public function getDateFinContrat()
	{
		return is_null($this->_dateFinContrat)?null:$this->_dateFinContrat->format('Y-n-j');
	}

	public function setDateFinContrat(string $dateFinContrat)
	{
		$this->_dateFinContrat=DateTime::createFromFormat("Y-n-j",$dateFinContrat);
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
		return "IdContrat : ".$this->getIdContrat()."IdCentre : ".$this->getIdCentre()."IdUtilisateur : ".$this->getIdUtilisateur()."DateDebutContrat : ".$this->getDateDebutContrat()."DateFinContrat : ".$this->getDateFinContrat()."\n";
	}
}