<?php

class View_Prestations_Pref_Point 
{

	/*****************Attributs***************** */

	private $_idPrestation;
	private $_codePrestation;
	private $_libellePrestation;
	private $_numeroTypePrestation;
	private $_libelleTypePrestation;
	private $_motifRequis;
	private $_uoRequis;
	private $_projetRequis;
	private $_idPreference;
	private $_idMotif;
	private $_codeMotif;
	private $_idUO;
	private $_numeroUO;
	private $_idProjet;
	private $_codeProjet;
	private $_idTypePrestation;
	private $_idUtilisateur;
	private $_idPointage;
	private $_datePointage;
	private $_mois;
	private static $_attributes=["idPrestation","codePrestation","libellePrestation","numeroTypePrestation","libelleTypePrestation","motifRequis","uoRequis","projetRequis","idPreference","idMotif","codeMotif","idUO","numeroUO","idProjet","codeProjet","idTypePrestation","idUtilisateur","idPointage","datePointage","mois"];
	/***************** Accesseurs ***************** */


	public function getIdPrestation()
	{
		return $this->_idPrestation;
	}

	public function setIdPrestation(int $idPrestation)
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

	public function getNumeroTypePrestation()
	{
		return $this->_numeroTypePrestation;
	}

	public function setNumeroTypePrestation(?int $numeroTypePrestation)
	{
		$this->_numeroTypePrestation=$numeroTypePrestation;
	}

	public function getLibelleTypePrestation()
	{
		return $this->_libelleTypePrestation;
	}

	public function setLibelleTypePrestation(?string $libelleTypePrestation)
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

	public function getIdPreference()
	{
		return $this->_idPreference;
	}

	public function setIdPreference(?int $idPreference)
	{
		$this->_idPreference=$idPreference;
	}

	public function getIdMotif()
	{
		return $this->_idMotif;
	}

	public function setIdMotif(?int $idMotif)
	{
		$this->_idMotif=$idMotif;
	}

	public function getIdProjet()
	{
		return $this->_idProjet;
	}

	public function setIdProjet(?int $idProjet)
	{
		$this->_idProjet=$idProjet;
	}

	public function getIdTypePrestation()
	{
		return $this->_idTypePrestation;
	}

	public function setIdTypePrestation(?int $idTypePrestation)
	{
		$this->_idTypePrestation=$idTypePrestation;
	}

	public function getIdUtilisateur()
	{
		return $this->_idUtilisateur;
	}

	public function setIdUtilisateur(?int $idUtilisateur)
	{
		$this->_idUtilisateur=$idUtilisateur;
	}

	public function getIdPointage()
	{
		return $this->_idPointage;
	}

	public function setIdPointage(?int $idPointage)
	{
		$this->_idPointage=$idPointage;
	}

	public function getDatePointage()
	{
		return is_null($this->_datePointage)?null:$this->_datePointage->format('Y-n-j');
	}

	public function setDatePointage(?string $datePointage)
	{
		$this->_datePointage=is_null($datePointage)?null:DateTime::createFromFormat("Y-n-j",$datePointage);
	}

	public function getMois()
	{
		return $this->_mois;
	}

	public function setMois(?string $mois)
	{
		$this->_mois=$mois;
	}

	public function getCodeMotif()
	{
		return $this->_codeMotif;
	}

	public function setCodeMotif($codeMotif)
	{
		$this->_codeMotif = $codeMotif;
	}

	public function getIdUO()
	{
		return $this->_idUO;
	}

	public function setIdUO($idUO)
	{
		$this->_idUO = $idUO;
	}

	public function getNumeroUO()
	{
		return $this->_numeroUO;
	}

	public function setNumeroUO($numeroUO)
	{
		$this->_numeroUO = $numeroUO;
	}

	public function getCodeProjet()
	{
		return $this->_codeProjet;
	}

	public function setCodeProjet($codeProjet)
	{
		$this->_codeProjet = $codeProjet;
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
		return "IdPrestation : ".$this->getIdPrestation()."CodePrestation : ".$this->getCodePrestation()."LibellePrestation : ".$this->getLibellePrestation()."NumeroTypePrestation : ".$this->getNumeroTypePrestation()."LibelleTypePrestation : ".$this->getLibelleTypePrestation()."MotifRequis : ".$this->getMotifRequis()."UoRequis : ".$this->getUoRequis()."ProjetRequis : ".$this->getProjetRequis()."IdPreference : ".$this->getIdPreference()."IdMotif : ".$this->getIdMotif()."IdProjet : ".$this->getIdProjet()."IdTypePrestation : ".$this->getIdTypePrestation()."IdUtilisateur : ".$this->getIdUtilisateur()."IdPointage : ".$this->getIdPointage()."DatePointage : ".$this->getDatePointage()."Mois : ".$this->getMois()."\n";
	}

}