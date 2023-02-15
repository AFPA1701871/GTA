<?php

class UOs
{

	/*****************Attributs***************** */

	private $_idUO;
	private $_numeroUO;
	private $_libelleUO;
	private static $_attributes = ["idUO", "numeroUO", "libelleUO"];
	/***************** Accesseurs ***************** */


	public function getIdUO()
	{
		return $this->_idUO;
	}

	public function setIdUO(?int $idUO)
	{
		$this->_idUO = $idUO;
	}

	public function getNumeroUO()
	{
		return $this->_numeroUO;
	}

	public function setNumeroUO(string $numeroUO)
	{
		$this->_numeroUO = $numeroUO;
	}

	public function getLibelleUO()
	{
		return $this->_libelleUO;
	}

	public function setLibelleUO(?string $libelleUO)
	{
		$this->_libelleUO = $libelleUO;
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
		return "IdUO : " . $this->getIdUO() . "NumeroUO : " . $this->getNumeroUO() . "LibelleUO : " . $this->getLibelleUO() . "\n";
	}
}
