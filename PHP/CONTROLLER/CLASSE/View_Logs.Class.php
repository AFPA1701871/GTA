<?php

class View_Logs 
{

	/*****************Attributs***************** */

	private $_idUtilisateur;
	private $_idEntite;
	private $_nomUtilisateur;
	private $_prisEnCompte;
	private $_periode;
	private static $_attributes=[ "idUtilisateur","idEntite", "nomUtilisateur", "prisEnCompte",  "periode"];
	/***************** Accesseurs ***************** */


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
	
	
	public function getNomUtilisateur()
	{
		return $this->_nomUtilisateur;
	}

	public function setNomUtilisateur($nomUtilisateur)
	{
		$this->_nomUtilisateur = $nomUtilisateur;
	}

	public function getPeriode()
	{
		return $this->_periode;
	}

	public function setPeriode($periode)
	{
		$this->_periode = $periode;
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
}