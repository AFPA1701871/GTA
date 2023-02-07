<?php

class View_Motifs 
{

	/*****************Attributs***************** */

	private $_idMotif;
	private $_codeMotif;
	private $_libelleMotif;
	private $_idTypePrestation;
	private $_numeroTypePrestation;
	private $_libelleTypePrestation;
	private $_motifRequis;
	private $_uoRequis;
	private $_projetRequis;
	private static $_attributes=["idMotif","codeMotif","libelleMotif","idTypePrestation","numeroTypePrestation","libelleTypePrestation","motifRequis","uoRequis","projetRequis"];
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

	public function setIdTypePrestation(int $idTypePrestation)
	{
		$this->_idTypePrestation=$idTypePrestation;
	}

	public function getNumeroTypePrestation()
	{
		return $this->_numeroTypePrestation;
	}

	public function setNumeroTypePrestation(int $numeroTypePrestation)
	{
		$this->_numeroTypePrestation=$numeroTypePrestation;
	}

	public function getLibelleTypePrestation()
	{
		return $this->_libelleTypePrestation;
	}

	public function setLibelleTypePrestation(string $libelleTypePrestation)
	{
		$this->_libelleTypePrestation=$libelleTypePrestation;
	}

	public function getMotifRequis()
	{
		return $this->_motifRequis;
	}

	public function setMotifRequis(?int $motifRequis)
	{
		$this->_motifRequis=$motifRequis;
	}

	public function getUoRequis()
	{
		return $this->_uoRequis;
	}

	public function setUoRequis(?int $uoRequis)
	{
		$this->_uoRequis=$uoRequis;
	}

	public function getProjetRequis()
	{
		return $this->_projetRequis;
	}

	public function setProjetRequis(?int $projetRequis)
	{
		$this->_projetRequis=$projetRequis;
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
		return "IdMotif : ".$this->getIdMotif()."CodeMotif : ".$this->getCodeMotif()."LibelleMotif : ".$this->getLibelleMotif()."IdTypePrestation : ".$this->getIdTypePrestation()."NumeroTypePrestation : ".$this->getNumeroTypePrestation()."LibelleTypePrestation : ".$this->getLibelleTypePrestation()."MotifRequis : ".$this->getMotifRequis()."UoRequis : ".$this->getUoRequis()."ProjetRequis : ".$this->getProjetRequis()."\n";
	}
}