<?php

class View_Utilisateurs_Preferences_Prestations
{

	/*****************Attributs***************** */

	private $_idPreference;
	private $_idUtilisateur;
	private $_nomUtilisateur;
	private $_mailUtilisateur;
	private $_matriculeUtilisateur;
	private $_passwordUtilisateur;
	private $_idUo;
	private $_idRole;
	private $_idManager;
	private $_idPrestation;
	private $_codePrestation;
	private $_libellePrestation;
	private $_idActivite;
	private static $_attributes = ["idPreference", "idUtilisateur", "nomUtilisateur", "mailUtilisateur", "matriculeUtilisateur", "passwordUtilisateur", "idUo", "idRole", "idManager", "idPrestation", "codePrestation", "libellePrestation", "idActivite"];
	/***************** Accesseurs ***************** */


	public function getIdPreference()
	{
		return $this->_idPreference;
	}

	public function setIdPreference(?int $idPreference)
	{
		$this->_idPreference = $idPreference;
	}

	public function getIdUtilisateur()
	{
		return $this->_idUtilisateur;
	}

	public function setIdUtilisateur(?int $idUtilisateur)
	{
		$this->_idUtilisateur = $idUtilisateur;
	}

	public function getNomUtilisateur()
	{
		return $this->_nomUtilisateur;
	}

	public function setNomUtilisateur(?string $nomUtilisateur)
	{
		$this->_nomUtilisateur = $nomUtilisateur;
	}

	public function getMailUtilisateur()
	{
		return $this->_mailUtilisateur;
	}

	public function setMailUtilisateur(?string $mailUtilisateur)
	{
		$this->_mailUtilisateur = $mailUtilisateur;
	}

	public function getMatriculeUtilisateur()
	{
		return $this->_matriculeUtilisateur;
	}

	public function setMatriculeUtilisateur(?string $matriculeUtilisateur)
	{
		$this->_matriculeUtilisateur = $matriculeUtilisateur;
	}

	public function getPasswordUtilisateur()
	{
		return $this->_passwordUtilisateur;
	}

	public function setPasswordUtilisateur(?string $passwordUtilisateur)
	{
		$this->_passwordUtilisateur = $passwordUtilisateur;
	}

	public function getIdUo()
	{
		return $this->_idUo;
	}

	public function setIdUo(?int $idUo)
	{
		$this->_idUo = $idUo;
	}

	public function getIdRole()
	{
		return $this->_idRole;
	}

	public function setIdRole(?int $idRole)
	{
		$this->_idRole = $idRole;
	}

	public function getIdManager()
	{
		return $this->_idManager;
	}

	public function setIdManager(?int $idManager)
	{
		$this->_idManager = $idManager;
	}

	public function getIdPrestation()
	{
		return $this->_idPrestation;
	}

	public function setIdPrestation(?int $idPrestation)
	{
		$this->_idPrestation = $idPrestation;
	}

	public function getCodePrestation()
	{
		return $this->_codePrestation;
	}

	public function setCodePrestation(?string $codePrestation)
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

	public function getIdActivite()
	{
		return $this->_idActivite;
	}

	public function setIdActivite(?int $idActivite)
	{
		$this->_idActivite = $idActivite;
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
		return "IdPreference : " . $this->getIdPreference() . "IdUtilisateur : " . $this->getIdUtilisateur() . "NomUtilisateur : " . $this->getNomUtilisateur() . "MailUtilisateur : " . $this->getMailUtilisateur() . "MatriculeUtilisateur : " . $this->getMatriculeUtilisateur() . "PasswordUtilisateur : " . $this->getPasswordUtilisateur() . "IdUo : " . $this->getIdUo() . "IdRole : " . $this->getIdRole() . "IdManager : " . $this->getIdManager() . "IdPrestation : " . $this->getIdPrestation() . "CodePrestation : " . $this->getCodePrestation() . "LibellePrestation : " . $this->getLibellePrestation() . "IdActivite : " . $this->getIdActivite() . "\n";
	}
}
