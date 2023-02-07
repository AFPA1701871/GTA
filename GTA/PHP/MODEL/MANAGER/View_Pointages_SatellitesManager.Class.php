<?php

class View_Pointages_SatellitesManager 
{

	public static function add(View_Pointages_Satellites $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(View_Pointages_Satellites $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(View_Pointages_Satellites $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(View_Pointages_Satellites::getAttributes(),"View_Pointages_Satellites",["idPointage" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Pointages_Satellites::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Pointages_Satellites",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}