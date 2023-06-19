<?php

class Centres 
{

	/*****************Attributs***************** */

	private $_idCentre;
	private $_idEntite;
	private $_nomCentre;
	private $_numeroCentre;
	private static $_attributes=["idCentre","idEntite","nomCentre","numeroCentre"];
	/***************** Accesseurs ***************** */


	public function getIdCentre()
	{
		return $this->_idCentre;
	}

	public function setIdCentre(?int $idCentre)
	{
		$this->_idCentre=$idCentre;
	}

	public function getNomCentre()
	{
		return $this->_nomCentre;
	}

	public function setNomCentre(string $nomCentre)
	{
		$this->_nomCentre=$nomCentre;
	}

	public function getNumeroCentre()
	{
		return $this->_numeroCentre;
	}

	public function setNumeroCentre(string $numeroCentre)
	{
		$this->_numeroCentre=$numeroCentre;
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
		return "IdCentre : ".$this->getIdCentre()."NomCentre : ".$this->getNomCentre()."NumeroCentre : ".$this->getNumeroCentre()."\n";
	}
}