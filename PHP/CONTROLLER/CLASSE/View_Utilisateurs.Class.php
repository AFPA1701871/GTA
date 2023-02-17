<?php

class View_Utilisateurs
{

	/*****************Attributs***************** */

	private $_idUtilisateur;
	private $_nomUtilisateur;
	private $_mailUtilisateur;
	private $_matriculeUtilisateur;
	private $_idUo;
	private $_idRole;
	private $_idManager;
	private $_nomManager;
	private $_mailManager;
	private $_matriculeManager;
	private $_actif;
	private $_numeroUo;
	private $_libelleUo;
	private $_nomRole;
	private $_idCentre;
	private $_nomCentre;
	private static $_attributes = ["idUtilisateur", "nomUtilisateur", "mailUtilisateur", "matriculeUtilisateur", "idUo", "idRole", "idManager", "nomManager", "mailManager", "matriculeManager", "actif", "numeroUo", "libelleUo", "nomRole", "idCentre", "nomCentre"];
	/***************** Accesseurs ***************** */


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

	public function setNomUtilisateur(string $nomUtilisateur)
	{
		$this->_nomUtilisateur = $nomUtilisateur;
	}

	public function getMailUtilisateur()
	{
		return $this->_mailUtilisateur;
	}

	public function setMailUtilisateur(string $mailUtilisateur)
	{
		$this->_mailUtilisateur = $mailUtilisateur;
	}

	public function getMatriculeUtilisateur()
	{
		return $this->_matriculeUtilisateur;
	}

	public function setMatriculeUtilisateur(string $matriculeUtilisateur)
	{
		$this->_matriculeUtilisateur = $matriculeUtilisateur;
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

	public function setIdRole(int $idRole)
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

	public function getNomManager()
	{
		return $this->_nomManager;
	}

	public function setNomManager(?string $nomManager)
	{
		$this->_nomManager = $nomManager;
	}

	public function getMailManager()
	{
		return $this->_mailManager;
	}

	public function setMailManager(?string $mailManager)
	{
		$this->_mailManager = $mailManager;
	}

	public function getMatriculeManager()
	{
		return $this->_matriculeManager;
	}

	public function setMatriculeManager(?string $matriculeManager)
	{
		$this->_matriculeManager = $matriculeManager;
	}

	public function getActif()
	{
		return $this->_actif;
	}

	public function setActif(?int $actif)
	{
		$this->_actif = $actif;
	}

	public function getNumeroUo()
	{
		return $this->_numeroUo;
	}

	public function setNumeroUo(?int $numeroUo)
	{
		$this->_numeroUo = $numeroUo;
	}

	public function getLibelleUo()
	{
		return $this->_libelleUo;
	}

	public function setLibelleUo(?string $libelleUo)
	{
		$this->_libelleUo = $libelleUo;
	}

	public function getNomRole()
	{
		return $this->_nomRole;
	}

	public function setNomRole(?string $nomRole)
	{
		$this->_nomRole = $nomRole;
	}
	public function getIdCentre()
	{
		return $this->_idCentre;
	}

	public function setIdCentre($idCentre)
	{
		$this->_idCentre = $idCentre;
	}

	public function getNomCentre()
	{
		return $this->_nomCentre;
	}

	public function setNomCentre($nomCentre)
	{
		$this->_nomCentre = $nomCentre;
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
		return "IdUtilisateur : " . $this->getIdUtilisateur() . "NomUtilisateur : " . $this->getNomUtilisateur() . "MailUtilisateur : " . $this->getMailUtilisateur() . "MatriculeUtilisateur : " . $this->getMatriculeUtilisateur() . "IdUo : " . $this->getIdUo() . "IdRole : " . $this->getIdRole() . "IdManager : " . $this->getIdManager() . "NomManager : " . $this->getNomManager() . "MailManager : " . $this->getMailManager() . "MatriculeManager : " . $this->getMatriculeManager() . "Actif : " . $this->getActif() . "NumeroUo : " . $this->getNumeroUo() . "LibelleUo : " . $this->getLibelleUo() . "NomRole : " . $this->getNomRole() . "\n";
	}
}
