<?php

class Pointages 
{

	/*****************Attributs***************** */

	private $_idPointage;
	private $_idMotif;
	private $_idPrestation;
	private $_idProjet;
	private $_idUO;
	private $_idUtilisateur;
	private $_idTypePrestation;
	private $_datePointage;
	private $_validePointage;
	private $_reportePointage;
	private $_nbHeuresPointage;
	private static $_attributes=["idPointage","idMotif","idPrestation","idProjet","idUO","idUtilisateur","idTypePrestation","datePointage","validePointage","reportePointage","nbHeuresPointage"];
	/***************** Accesseurs ***************** */


	public function getIdPointage()
	{
		return $this->_idPointage;
	}

	public function setIdPointage(?int $idPointage)
	{
		$this->_idPointage=$idPointage;
	}

	public function getIdMotif()
	{
		return $this->_idMotif;
	}

	public function setIdMotif(?int $idMotif)
	{
		$this->_idMotif=$idMotif;
	}

	public function getIdPrestation()
	{
		return $this->_idPrestation;
	}

	public function setIdPrestation(?int $idPrestation)
	{
		$this->_idPrestation=$idPrestation;
	}

	public function getIdProjet()
	{
		return $this->_idProjet;
	}

	public function setIdProjet(?int $idProjet)
	{
		$this->_idProjet=$idProjet;
	}

	public function getIdUO()
	{
		return $this->_idUO;
	}

	public function setIdUO(?int $idUO)
	{
		$this->_idUO=$idUO;
	}

	public function getIdUtilisateur()
	{
		return $this->_idUtilisateur;
	}

	public function setIdUtilisateur(int $idUtilisateur)
	{
		$this->_idUtilisateur=$idUtilisateur;
	}

	public function getDatePointage()
	{
		return is_null($this->_datePointage)?null:$this->_datePointage->format('Y-n-j');
	}

	public function setDatePointage(string $datePointage)
	{
		$this->_datePointage=DateTime::createFromFormat("Y-n-j",$datePointage);
	}

	public function getValidePointage()
	{
		return $this->_validePointage;
	}

	public function setValidePointage(?int $validePointage)
	{
		$this->_validePointage=$validePointage;
	}

	public function getReportePointage()
	{
		return $this->_reportePointage;
	}

	public function setReportePointage(?int $reportePointage)
	{
		$this->_reportePointage=$reportePointage;
	}

	public function getNbHeuresPointage()
	{
		return $this->_nbHeuresPointage;
	}

	public function setNbHeuresPointage(?float $nbHeuresPointage)
	{
		$this->_nbHeuresPointage=$nbHeuresPointage;
	}

	public function getIdTypePrestation()
	{
		return $this->_idTypePrestation;
	}

	public function setIdTypePrestation($idTypePrestation)
	{
		$this->_idTypePrestation = $idTypePrestation;
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
		return "IdPointage : ".$this->getIdPointage()."IdMotif : ".$this->getIdMotif()."IdPrestation : ".$this->getIdPrestation()."IdProjet : ".$this->getIdProjet()."IdUO : ".$this->getIdUO()."IdUtilisateur : ".$this->getIdUtilisateur()."DatePointage : ".$this->getDatePointage()."ValidePointage : ".$this->getValidePointage()."ReportePointage : ".$this->getReportePointage()."NbHeuresPointage : ".$this->getNbHeuresPointage()."\n";
	}

}