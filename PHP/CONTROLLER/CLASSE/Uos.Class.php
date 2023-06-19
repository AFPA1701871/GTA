<?php

class Uos
{

	/*****************Attributs***************** */

	private $_idUo;
	private $_idEntite;
	private $_numeroUo;
	private $_libelleUo;
	private static $_attributes = ["idUo","idEntite", "numeroUo", "libelleUo"];
	/***************** Accesseurs ***************** */


	public function getIdUo()
	{
		return $this->_idUo;
	}

	public function setIdUo(?int $idUo)
	{
		$this->_idUo = $idUo;
	}

	public function getNumeroUo()
	{
		return $this->_numeroUo;
	}

	public function setNumeroUo(string $numeroUo)
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
		return "IdUo : " . $this->getIdUo() . "NumeroUo : " . $this->getNumeroUo() . "LibelleUo : " . $this->getLibelleUo() . "\n";
	}
}
