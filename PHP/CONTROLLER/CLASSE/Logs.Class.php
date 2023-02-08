<?php

class Logs 
{

	/*****************Attributs***************** */

	private $_idLog;
	private $_dateLog;
	private $_actionLog;
	private $_prisEnCompte;
	private $_idUtilisateur;
	private static $_attributes=["idLog","dateLog","actionLog","prisEnCompte","idUtilisateur"];
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
		return is_null($this->_dateLog)?null:$this->_dateLog->format('Y-n-j H:i:s');
	}

	public function setDateLog(string $dateLog)
	{
		$this->_dateLog=DateTime::createFromFormat("Y-n-j H:i:s",$dateLog);
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