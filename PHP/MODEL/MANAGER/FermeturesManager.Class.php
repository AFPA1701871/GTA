<?php

class FermeturesManager 
{

	public static function add(Fermetures $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Fermetures $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Fermetures $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Fermetures::getAttributes(),"Fermetures",["idFermeture" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Fermetures::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Fermetures",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );
	}

	public static function getDates(string $periode)
	{
		// Nettoyage de la période
		$periodeClean = htmlentities($periode);

		$dates = DAO::select(["dateFermeture"], "Fermetures", ["dateFermeture" => $periodeClean . "%"], "dateFermeture ASC");
		$listeDates = [];

		// Création d'un tableau plat si on a des résultats
		if ($dates != null) {
			foreach ($dates as $date) {
				$d = strtotime($date->getDateFermeture());
				$listeDates[] = date("Y-m-d", $d);
			}
		}
		return $listeDates;
	}
}