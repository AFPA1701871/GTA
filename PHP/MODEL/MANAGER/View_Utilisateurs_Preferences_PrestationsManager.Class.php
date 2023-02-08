<?php

class View_Utilisateurs_Preferences_PrestationsManager 
{

	public static function add(View_Utilisateurs_Preferences_Prestations $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(View_Utilisateurs_Preferences_Prestations $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(View_Utilisateurs_Preferences_Prestations $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(View_Utilisateurs_Preferences_Prestations::getAttributes(),"View_Utilisateurs_Preferences_Prestations",["idPreference" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Utilisateurs_Preferences_Prestations::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Utilisateurs_Preferences_Prestations",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}