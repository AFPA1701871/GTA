<?php

class Logs 
{

	/*****************Attributs***************** */

	private $_idLog;
	private $_idEntite;
	private $_actionLog;
	private $_idUtilisateur;
	private $_dateModifiee;
	private $_prisEnCompte;
	private $_dateLog;
	private $_userLog;
	private static $_attributes=["idLog","idEntite", "actionLog", "idUtilisateur", "dateModifiee", "prisEnCompte", "dateLog", "userLog"];
	/***************** Accesseurs ***************** */


	public function getIdLog()
	{
		return $this->_idLog;
	}

	public function setIdLog(?int $idLog)
	{
		$this->_idLog=$idLog;
	}

	public function getDateLog()
	{
		return $this->_dateLog;
	}

	public function setDateLog($dateLog)
	{
		$this->_dateLog = $dateLog;
	}

	public function getActionLog()
	{
		return $this->_actionLog;
	}

	public function setActionLog(string $actionLog)
	{
		$this->_actionLog=$actionLog;
	}

	public function getPrisEnCompte()
	{
		return $this->_prisEnCompte;
	}

	public function setPrisEnCompte(?int $prisEnCompte)
	{
		$this->_prisEnCompte=$prisEnCompte;
	}

	public function getIdUtilisateur()
	{
		return $this->_idUtilisateur;
	}

	public function setIdUtilisateur(int $idUtilisateur)
	{
		$this->_idUtilisateur=$idUtilisateur;
	}
	public function getDateModifiee()
	{
		return $this->_dateModifiee;
	}

	public function setDateModifiee($dateModifiee)
	{
		$this->_dateModifiee = $dateModifiee;
	}

	public function getUserLog()
	{
		return $this->_userLog;
	}

	public function setUserLog($userLog)
	{
		$this->_userLog = $userLog;
	}public function getIdEntite()
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
		return "IdLog : ".$this->getIdLog()."DateLog : ".$this->getDateLog()."ActionLog : ".$this->getActionLog()."PrisEnCompte : ".$this->getPrisEnCompte()."IdUtilisateur : ".$this->getIdUtilisateur()."\n";
	}

	
}