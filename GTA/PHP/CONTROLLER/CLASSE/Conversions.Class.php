<?php

class Conversions 
{

	/*****************Attributs***************** */

	private $_idConversion;
	private $_nbHeureConversion;
	private $_coeffConversion;
	private static $_attributes=["idConversion","nbHeureConversion","coeffConversion"];
	/***************** Accesseurs ***************** */


	public function getIdConversion()
	{
		return $this->_idConversion;
	}

	public function setIdConversion(?int $idConversion)
	{
		$this->_idConversion=$idConversion;
	}

	public function getNbHeureConversion()
	{
		return $this->_nbHeureConversion;
	}

	public function setNbHeureConversion(int $nbHeureConversion)
	{
		$this->_nbHeureConversion=$nbHeureConversion;
	}

	public function getCoeffConversion()
	{
		return $this->_coeffConversion;
	}

	public function setCoeffConversion(?float $coeffConversion)
	{
		$this->_coeffConversion=$coeffConversion;
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
		return "IdConversion : ".$this->getIdConversion()."NbHeureConversion : ".$this->getNbHeureConversion()."CoeffConversion : ".$this->getCoeffConversion()."\n";
	}
}