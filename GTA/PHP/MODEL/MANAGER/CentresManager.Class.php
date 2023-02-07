<?php

class CentresManager 
{

	public static function add(Centres $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Centres $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Centres $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Centres::getAttributes(),"Centres",["idCentre" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Centres::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Centres",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}