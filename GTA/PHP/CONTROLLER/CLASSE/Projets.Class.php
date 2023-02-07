<?php

class Projets 
{

	/*****************Attributs***************** */

	private $_idProjet;
	private $_codeProjet;
	private $_libelleProjet;
	private static $_attributes=["idProjet","codeProjet","libelleProjet"];
	/***************** Accesseurs ***************** */


	public function getIdProjet()
	{
		return $this->_idProjet;
	}

	public function setIdProjet(?int $idProjet)
	{
		$this->_idProjet=$idProjet;
	}

	public function getCodeProjet()
	{
		return $this->_codeProjet;
	}

	public function setCodeProjet(string $codeProjet)
	{
		$this->_codeProjet=$codeProjet;
	}

	public function getLibelleProjet()
	{
		return $this->_libelleProjet;
	}

	public function setLibelleProjet(string $libelleProjet)
	{
		$this->_libelleProjet=$libelleProjet;
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
		return "IdProjet : ".$this->getIdProjet()."CodeProjet : ".$this->getCodeProjet()."LibelleProjet : ".$this->getLibelleProjet()."\n";
	}
}