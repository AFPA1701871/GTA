<?php

class Fermetures 
{

	/*****************Attributs***************** */

	private $_idFermeture;
	private $_idEntite;
	private $_dateFermeture;
	private static $_attributes=["idFermeture","idEntite","dateFermeture"];
	/***************** Accesseurs ***************** */


	public function getIdFermeture()
	{
		return $this->_idFermeture;
	}

	public function setIdFermeture(?int $idFermeture)
	{
		$this->_idFermeture=$idFermeture;
	}

	public function getDateFermeture()
	{
		return is_null($this->_dateFermeture)?null:$this->_dateFermeture->format('Y-n-j');
	}

	public function setDateFermeture(string $dateFermeture)
	{
		$this->_dateFermeture=DateTime::createFromFormat("Y-n-j",$dateFermeture);
	}public function getIdEntite()
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
		return "IdFermeture : ".$this->getIdFermeture()."DateFermeture : ".$this->getDateFermeture()."\n";
	}
}