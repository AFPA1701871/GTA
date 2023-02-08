<?php

class ActivitesManager 
{

	public static function add(Activites $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Activites $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Activites $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Activites::getAttributes(),"Activites",["idActivite" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Activites::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Activites",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}