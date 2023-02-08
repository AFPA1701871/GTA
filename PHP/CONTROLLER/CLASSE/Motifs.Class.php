<?php

class Motifs 
{

	/*****************Attributs***************** */

	private $_idMotif;
	private $_codeMotif;
	private $_libelleMotif;
	private $_idTypePrestation;
	private static $_attributes=["idMotif","codeMotif","libelleMotif","idTypePrestation"];
	/***************** Accesseurs ***************** */


	public function getIdMotif()
	{
		return $this->_idMotif;
	}

	public function setIdMotif(?int $idMotif)
	{
		$this->_idMotif=$idMotif;
	}

	public function getCodeMotif()
	{
		return $this->_codeMotif;
	}

	public function setCodeMotif(int $codeMotif)
	{
		$this->_codeMotif=$codeMotif;
	}

	public function getLibelleMotif()
	{
		return $this->_libelleMotif;
	}

	public function setLibelleMotif(string $libelleMotif)
	{
		$this->_libelleMotif=$libelleMotif;
	}

	public function getIdTypePrestation()
	{
		return $this->_idTypePrestation;
	}

	public function setIdTypePrestation(?int $idTypePrestation)
	{
		$this->_idTypePrestation=$idTypePrestation;
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
		return "IdMotif : ".$this->getIdMotif()."CodeMotif : ".$this->getCodeMotif()."LibelleMotif : ".$this->getLibelleMotif()."IdTypePrestation : ".$this->getIdTypePrestation()."\n";
	}
}