<?php

class View_Pointages_Periode 
{

	/*****************Attributs***************** */

	private $_periode;
	private $_cumulPointage;
	private $_idEntite;
	private $_idUtilisateur;
	private $_nomUtilisateur;
	private $_mailUtilisateur;
	private $_matriculeUtilisateur;
	private $_idUo_Utilisateur;
	private $_idRole;
	private $_idManager;
	private static $_attributes=["periode","cumulPointage","idEntite","idUtilisateur","nomUtilisateur","mailUtilisateur","matriculeUtilisateur","idUo_Utilisateur","idRole","idManager"];
	/***************** Accesseurs ***************** */


	public function getPeriode()
	{
		return $this->_periode;
	}

	public function setPeriode(?string $periode)
	{
		$this->_periode=$periode;
	}

	public function getCumulPointage()
	{
		return $this->_cumulPointage;
	}

	public function setCumulPointage(?float $cumulPointage)
	{
		$this->_cumulPointage=$cumulPointage;
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

	public function getIdUo_Utilisateur()
	{
		return $this->_idUo_Utilisateur;
	}

	public function setIdUo_Utilisateur(?int $idUo_Utilisateur)
	{
		$this->_idUo_Utilisateur=$idUo_Utilisateur;
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
		return "Periode : ".$this->getPeriode()."CumulPointage : ".$this->getCumulPointage()."IdUtilisateur : ".$this->getIdUtilisateur()."NomUtilisateur : ".$this->getNomUtilisateur()."MailUtilisateur : ".$this->getMailUtilisateur()."MatriculeUtilisateur : ".$this->getMatriculeUtilisateur()."IdUo_Utilisateur : ".$this->getIdUo_Utilisateur()."IdRole : ".$this->getIdRole()."IdManager : ".$this->getIdManager()."\n";
	}
}