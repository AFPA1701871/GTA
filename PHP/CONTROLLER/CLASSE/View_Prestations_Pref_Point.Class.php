<?php

class View_Prestations_Pref_Point
{

	/*****************Attributs***************** */

	private $_idPrestation;
	private $_idEntite;
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
	private $_libelleMotif;
	private $_idUo;
	private $_numeroUo;
	private $_libelleUo;
	private $_idProjet;
	private $_codeProjet;
	private $_libelleProjet;
	private $_idTypePrestation;
	private $_idUtilisateur;
	private $_idPointage;
	private $_datePointage;
	private $_periode;
	private static $_attributes = ["idPrestation", "idEntite", "codePrestation", "libellePrestation", "numeroTypePrestation", "libelleTypePrestation", "motifRequis", "uoRequis", "projetRequis", "idPreference", "idMotif", "codeMotif", "libelleMotif", "idUo", "numeroUo", "libelleUo", "idProjet", "codeProjet", "libelleProjet", "idTypePrestation", "idUtilisateur", "idPointage", "datePointage", "periode"];
	/***************** Accesseurs ***************** */


	public function getIdPrestation()
	{
		return $this->_idPrestation;
	}

	public function setIdPrestation(int $idPrestation)
	{
		$this->_idPrestation = $idPrestation;
	}

	public function getCodePrestation()
	{
		return $this->_codePrestation;
	}

	public function setCodePrestation(string $codePrestation)
	{
		$this->_codePrestation = $codePrestation;
	}

	public function getLibellePrestation()
	{
		return $this->_libellePrestation;
	}

	public function setLibellePrestation(?string $libellePrestation)
	{
		$this->_libellePrestation = $libellePrestation;
	}

	public function getNumeroTypePrestation()
	{
		return $this->_numeroTypePrestation;
	}

	public function setNumeroTypePrestation(?int $numeroTypePrestation)
	{
		$this->_numeroTypePrestation = $numeroTypePrestation;
	}

	public function getLibelleTypePrestation()
	{
		return $this->_libelleTypePrestation;
	}

	public function setLibelleTypePrestation(?string $libelleTypePrestation)
	{
		$this->_libelleTypePrestation = $libelleTypePrestation;
	}

	public function getMotifRequis()
	{
		return $this->_motifRequis;
	}

	public function setMotifRequis(?int $motifRequis)
	{
		$this->_motifRequis = $motifRequis;
	}

	public function getUoRequis()
	{
		return $this->_uoRequis;
	}

	public function setUoRequis(?int $uoRequis)
	{
		$this->_uoRequis = $uoRequis;
	}

	public function getProjetRequis()
	{
		return $this->_projetRequis;
	}

	public function setProjetRequis(?int $projetRequis)
	{
		$this->_projetRequis = $projetRequis;
	}

	public function getIdPreference()
	{
		return $this->_idPreference;
	}

	public function setIdPreference(?int $idPreference)
	{
		$this->_idPreference = $idPreference;
	}

	public function getIdMotif()
	{
		return $this->_idMotif;
	}

	public function setIdMotif(?int $idMotif)
	{
		$this->_idMotif = $idMotif;
	}

	public function getIdProjet()
	{
		return $this->_idProjet;
	}

	public function setIdProjet(?int $idProjet)
	{
		$this->_idProjet = $idProjet;
	}

	public function getIdTypePrestation()
	{
		return $this->_idTypePrestation;
	}

	public function setIdTypePrestation(?int $idTypePrestation)
	{
		$this->_idTypePrestation = $idTypePrestation;
	}

	public function getIdUtilisateur()
	{
		return $this->_idUtilisateur;
	}

	public function setIdUtilisateur(?int $idUtilisateur)
	{
		$this->_idUtilisateur = $idUtilisateur;
	}

	public function getIdPointage()
	{
		return $this->_idPointage;
	}

	public function setIdPointage(?int $idPointage)
	{
		$this->_idPointage = $idPointage;
	}

	public function getDatePointage()
	{
		return is_null($this->_datePointage) ? null : $this->_datePointage->format('Y-n-j');
	}

	public function setDatePointage(?string $datePointage)
	{
		$this->_datePointage = is_null($datePointage) ? null : DateTime::createFromFormat("Y-n-j", $datePointage);
	}

	public function getPeriode()
	{
		return $this->_periode;
	}

	public function setPeriode(?string $periode)
	{
		$this->_periode = $periode;
	}

	public function getCodeMotif()
	{
		return $this->_codeMotif;
	}

	public function setCodeMotif($codeMotif)
	{
		$this->_codeMotif = $codeMotif;
	}

	public function getIdUo()
	{
		return $this->_idUo;
	}

	public function setIdUo($idUo)
	{
		$this->_idUo = $idUo;
	}

	public function getNumeroUo()
	{
		return $this->_numeroUo;
	}

	public function setNumeroUo($numeroUo)
	{
		$this->_numeroUo = $numeroUo;
	}

	public function getCodeProjet()
	{
		return $this->_codeProjet;
	}

	public function setCodeProjet($codeProjet)
	{
		$this->_codeProjet = $codeProjet;
	}

	public function getLibelleMotif()
	{
		return $this->_libelleMotif;
	}

	public function setLibelleMotif($libelleMotif)
	{
		$this->_libelleMotif = $libelleMotif;
	}

	public function getLibelleUo()
	{
		return $this->_libelleUo;
	}

	public function setLibelleUo($libelleUo)
	{
		$this->_libelleUo = $libelleUo;
	}

	public function getLibelleProjet()
	{
		return $this->_libelleProjet;
	}

	public function setLibelleProjet($libelleProjet)
	{
		$this->_libelleProjet = $libelleProjet;
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
		foreach ($data as $key => $value) {
			$methode = "set" . ucfirst($key); //ucfirst met la 1ere lettre en majuscule
			if (is_callable(([$this, $methode]))) // is_callable verifie que la methode existe
			{
				$this->$methode($value === "" ? null : $value);
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
		return "IdPrestation : " . $this->getIdPrestation() . "CodePrestation : " . $this->getCodePrestation() . "LibellePrestation : " . $this->getLibellePrestation() . "NumeroTypePrestation : " . $this->getNumeroTypePrestation() . "LibelleTypePrestation : " . $this->getLibelleTypePrestation() . "MotifRequis : " . $this->getMotifRequis() . "UoRequis : " . $this->getUoRequis() . "ProjetRequis : " . $this->getProjetRequis() . "IdPreference : " . $this->getIdPreference() . "IdMotif : " . $this->getIdMotif() . "IdProjet : " . $this->getIdProjet() . "IdTypePrestation : " . $this->getIdTypePrestation() . "IdUtilisateur : " . $this->getIdUtilisateur() . "IdPointage : " . $this->getIdPointage() . "DatePointage : " . $this->getDatePointage() . "Mois : " . $this->getPeriode() . "\n";
	}
}
