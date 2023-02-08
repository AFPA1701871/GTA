<?php

class View_Prestations 
{

	/*****************Attributs***************** */

	private $_idPrestation;
	private $_codePrestation;
	private $_libellePrestation;
	private $_idActivite;
	private $_libelleActivite;
	private static $_attributes=["idPrestation","codePrestation","libellePrestation","idActivite","libelleActivite"];
	/***************** Accesseurs ***************** */


	public function getIdPrestation()
	{
		return $this->_idPrestation;
	}

	public function setIdPrestation(?int $idPrestation)
	{
		$this->_idPrestation=$idPrestation;
	}

	public function getCodePrestation()
	{
		return $this->_codePrestation;
	}

	public function setCodePrestation(string $codePrestation)
	{
		$this->_codePrestation=$codePrestation;
	}

	public function getLibellePrestation()
	{
		return $this->_libellePrestation;
	}

	public function setLibellePrestation(?string $libellePrestation)
	{
		$this->_libellePrestation=$libellePrestation;
	}

	public function getIdActivite()
	{
		return $this->_idActivite;
	}

	public function setIdActivite(int $idActivite)
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
		return "IdPrestation : ".$this->getIdPrestation()."CodePrestation : ".$this->getCodePrestation()."LibellePrestation : ".$this->getLibellePrestation()."IdActivite : ".$this->getIdActivite()."LibelleActivite : ".$this->getLibelleActivite()."\n";
	}
}