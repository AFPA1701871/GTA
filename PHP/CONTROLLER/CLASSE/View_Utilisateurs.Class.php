<?php

class View_Utilisateurs 
{

	/*****************Attributs***************** */

	private $_idUtilisateur;
	private $_nomUtilisateur;
	private $_mailUtilisateur;
	private $_matriculeUtilisateur;
	private $_idUO;
	private $_idRole;
	private $_idManager;
	private $_nomManager;
	private $_mailManager;
	private $_matriculeManager;
	private $_actif;
	private $_numeroUO;
	private $_libelleUO;
	private $_nomRole;
	private static $_attributes=["idUtilisateur","nomUtilisateur","mailUtilisateur","matriculeUtilisateur","idUO","idRole","idManager","nomManager","mailManager","matriculeManager","actif","numeroUO","libelleUO","nomRole"];
	/***************** Accesseurs ***************** */


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

	public function setNomUtilisateur(string $nomUtilisateur)
	{
		$this->_nomUtilisateur=$nomUtilisateur;
	}

	public function getMailUtilisateur()
	{
		return $this->_mailUtilisateur;
	}

	public function setMailUtilisateur(string $mailUtilisateur)
	{
		$this->_mailUtilisateur=$mailUtilisateur;
	}

	public function getMatriculeUtilisateur()
	{
		return $this->_matriculeUtilisateur;
	}

	public function setMatriculeUtilisateur(string $matriculeUtilisateur)
	{
		$this->_matriculeUtilisateur=$matriculeUtilisateur;
	}

	public function getIdUO()
	{
		return $this->_idUO;
	}

	public function setIdUO(?int $idUO)
	{
		$this->_idUO=$idUO;
	}

	public function getIdRole()
	{
		return $this->_idRole;
	}

	public function setIdRole(int $idRole)
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

	public function getNomManager()
	{
		return $this->_nomManager;
	}

	public function setNomManager(?string $nomManager)
	{
		$this->_nomManager=$nomManager;
	}

	public function getMailManager()
	{
		return $this->_mailManager;
	}

	public function setMailManager(?string $mailManager)
	{
		$this->_mailManager=$mailManager;
	}

	public function getMatriculeManager()
	{
		return $this->_matriculeManager;
	}

	public function setMatriculeManager(?string $matriculeManager)
	{
		$this->_matriculeManager=$matriculeManager;
	}

	public function getActif()
	{
		return $this->_actif;
	}

	public function setActif(?int $actif)
	{
		$this->_actif=$actif;
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

	public function getNomRole()
	{
		return $this->_nomRole;
	}

	public function setNomRole(?string $nomRole)
	{
		$this->_nomRole=$nomRole;
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
		return "IdUtilisateur : ".$this->getIdUtilisateur()."NomUtilisateur : ".$this->getNomUtilisateur()."MailUtilisateur : ".$this->getMailUtilisateur()."MatriculeUtilisateur : ".$this->getMatriculeUtilisateur()."IdUO : ".$this->getIdUO()."IdRole : ".$this->getIdRole()."IdManager : ".$this->getIdManager()."NomManager : ".$this->getNomManager()."MailManager : ".$this->getMailManager()."MatriculeManager : ".$this->getMatriculeManager()."Actif : ".$this->getActif()."NumeroUO : ".$this->getNumeroUO()."LibelleUO : ".$this->getLibelleUO()."NomRole : ".$this->getNomRole()."\n";
	}
}