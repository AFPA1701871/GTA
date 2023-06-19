<?php

class Preferences
{

	/*****************Attributs***************** */

	private $_idPreference;
	private $_idEntite;
	private $_idMotif;
	private $_idPrestation;
	private $_idProjet;
	private $_idUo;
	private $_idUtilisateur;
	private $_idTypePrestation;
	private static $_attributes = ["idPreference","idEntite", "idMotif", "idPrestation", "idProjet", "idUo", "idUtilisateur", "idTypePrestation"];
	/***************** Accesseurs ***************** */


	public function getIdPreference()
	{
		return $this->_idPreference;
	}

	public function setIdPreference(?int $idPreference)
	{
		$this->_idPreference = $idPreference;
	}

	public function getIdPrestation()
	{
		return $this->_idPrestation;
	}

	public function setIdPrestation(?int $idPrestation)
	{
		$this->_idPrestation = $idPrestation;
	}

	public function getIdUtilisateur()
	{
		return $this->_idUtilisateur;
	}

	public function setIdUtilisateur(?int $idUtilisateur)
	{
		$this->_idUtilisateur = $idUtilisateur;
	}

	public function getIdMotif()
	{
		return $this->_idMotif;
	}

	public function setIdMotif($idMotif)
	{
		$this->_idMotif = $idMotif;
	}

	public function getIdProjet()
	{
		return $this->_idProjet;
	}

	public function setIdProjet($idProjet)
	{
		$this->_idProjet = $idProjet;
	}

	public function getIdUo()
	{
		return $this->_idUo;
	}

	public function setIdUo($idUo)
	{
		$this->_idUo = $idUo;
	}

	public function getIdTypePrestation()
	{
		return $this->_idTypePrestation;
	}

	public function setIdTypePrestation($idTypePrestation)
	{
		$this->_idTypePrestation = $idTypePrestation;
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
		return "IdPreference : " . $this->getIdPreference() . "IdPrestation : " . $this->getIdPrestation() . "IdUtilisateur : " . $this->getIdUtilisateur() . "\n";
	}
}
