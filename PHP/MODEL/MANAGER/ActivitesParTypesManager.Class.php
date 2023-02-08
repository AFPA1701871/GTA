<?php

class ActivitesParTypesManager 
{

	public static function add(ActivitesParTypes $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(ActivitesParTypes $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(ActivitesParTypes $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(ActivitesParTypes::getAttributes(),"ActivitesParTypes",["idActivitesParTypes" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?ActivitesParTypes::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"ActivitesParTypes",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}