<?php

class View_Pointages 
{

	/*****************Attributs***************** */

	private $_idPointage;
	private $_datePointage;
	private $_periode;
	private $_validePointage;
	private $_reportePointage;
	private $_nbHeuresPointage;
	private $_idUtilisateur;
	private $_nomUtilisateur;
	private $_mailUtilisateur;
	private $_matriculeUtilisateur;
	private $_passwordUtilisateur;
	private $_idUO_Utilisateur;
	private $_idRole;
	private $_idManager;
	private $_idUO_Pointage;
	private $_numeroUO;
	private $_libelleUO;
	private $_idMotif;
	private $_codeMotif;
	private $_libelleMotif;
	private $_idTypePrestation;
	private $_idProjet;
	private $_codeProjet;
	private $_libelleProjet;
	private $_idPrestation;
	private $_codePrestation;
	private $_libellePrestation;
	private $_idActivite;
	private static $_attributes=["idPointage","datePointage","validePointage","reportePointage","nbHeuresPointage","idUtilisateur","nomUtilisateur","mailUtilisateur","matriculeUtilisateur","passwordUtilisateur","idUO_Utilisateur","idRole","idManager","idUO_Pointage","numeroUO","libelleUO","idMotif","codeMotif","libelleMotif","idTypePrestation","idProjet","codeProjet","libelleProjet","idPrestation","codePrestation","libellePrestation","idActivite"];
	/***************** Accesseurs ***************** */


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

	public function setDatePointage(string $datePointage)
	{
		$this->_datePointage=DateTime::createFromFormat("Y-n-j",$datePointage);
	}

	public function getPeriode()
	{
		return $this->_periode;
	}

	public function setPeriode(?string $periode)
	{
		$this->_periode=$periode;
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

	public function getIdUtilisateur()
	{
		return $this->_idUtilisateur;
	}

	public function setIdUtilisateur(?int $idUtilisateur)
	{
		$this->_idUtilisateur=$idUtilisateur;
	}

	public function getNomUtilisateur()
	{
		return $this->_nomUtilisateur;
	}

	public function setNomUtilisateur(?string $nomUtilisateur)
	{
		$this->_nomUtilisateur=$nomUtilisateur;
	}

	public function getMailUtilisateur()
	{
		return $this->_mailUtilisateur;
	}

	public function setMailUtilisateur(?string $mailUtilisateur)
	{
		$this->_mailUtilisateur=$mailUtilisateur;
	}

	public function getMatriculeUtilisateur()
	{
		return $this->_matriculeUtilisateur;
	}

	public function setMatriculeUtilisateur(?string $matriculeUtilisateur)
	{
		$this->_matriculeUtilisateur=$matriculeUtilisateur;
	}

	public function getPasswordUtilisateur()
	{
		return $this->_passwordUtilisateur;
	}

	public function setPasswordUtilisateur(?string $passwordUtilisateur)
	{
		$this->_passwordUtilisateur=$passwordUtilisateur;
	}

	public function getIdUO_Utilisateur()
	{
		return $this->_idUO_Utilisateur;
	}

	public function setIdUO_Utilisateur(?int $idUO_Utilisateur)
	{
		$this->_idUO_Utilisateur=$idUO_Utilisateur;
	}

	public function getIdRole()
	{
		return $this->_idRole;
	}

	public function setIdRole(?int $idRole)
	{
		$this->_idRole=$idRole;
	}

	public function getIdManager()
	{
		return $this->_idManager;
	}

	public function setIdManager(?int $idManager)
	{
		$this->_idManager=$idManager;
	}

	public function getIdUO_Pointage()
	{
		return $this->_idUO_Pointage;
	}

	public function setIdUO_Pointage(?int $idUO_Pointage)
	{
		$this->_idUO_Pointage=$idUO_Pointage;
	}

	public function getNumeroUO()
	{
		return $this->_numeroUO;
	}

	public function setNumeroUO(?int $numeroUO)
	{
		$this->_numeroUO=$numeroUO;
	}

	public function getLibelleUO()
	{
		return $this->_libelleUO;
	}

	public function setLibelleUO(?string $libelleUO)
	{
		$this->_libelleUO=$libelleUO;
	}

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

	public function setCodeMotif(?int $codeMotif)
	{
		$this->_codeMotif=$codeMotif;
	}

	public function getLibelleMotif()
	{
		return $this->_libelleMotif;
	}

	public function setLibelleMotif(?string $libelleMotif)
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

	public function setCodeProjet(?string $codeProjet)
	{
		$this->_codeProjet=$codeProjet;
	}

	public function getLibelleProjet()
	{
		return $this->_libelleProjet;
	}

	public function setLibelleProjet(?string $libelleProjet)
	{
		$this->_libelleProjet=$libelleProjet;
	}

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

	public function setCodePrestation(?string $codePrestation)
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

	public function setIdActivite(?int $idActivite)
	{
		$this->_idActivite=$idActivite;
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
		return "IdPointage : ".$this->getIdPointage()."DatePointage : ".$this->getDatePointage()."ValidePointage : ".$this->getValidePointage()."ReportePointage : ".$this->getReportePointage()."NbHeuresPointage : ".$this->getNbHeuresPointage()."IdUtilisateur : ".$this->getIdUtilisateur()."NomUtilisateur : ".$this->getNomUtilisateur()."MailUtilisateur : ".$this->getMailUtilisateur()."MatriculeUtilisateur : ".$this->getMatriculeUtilisateur()."PasswordUtilisateur : ".$this->getPasswordUtilisateur()."IdUO_Utilisateur : ".$this->getIdUO_Utilisateur()."IdRole : ".$this->getIdRole()."IdManager : ".$this->getIdManager()."IdUO_Pointage : ".$this->getIdUO_Pointage()."NumeroUO : ".$this->getNumeroUO()."LibelleUO : ".$this->getLibelleUO()."IdMotif : ".$this->getIdMotif()."CodeMotif : ".$this->getCodeMotif()."LibelleMotif : ".$this->getLibelleMotif()."IdTypePrestation : ".$this->getIdTypePrestation()."IdProjet : ".$this->getIdProjet()."CodeProjet : ".$this->getCodeProjet()."LibelleProjet : ".$this->getLibelleProjet()."IdPrestation : ".$this->getIdPrestation()."CodePrestation : ".$this->getCodePrestation()."LibellePrestation : ".$this->getLibellePrestation()."IdActivite : ".$this->getIdActivite()."\n";
	}
}