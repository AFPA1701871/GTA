<?php

class PrestationsManager 
{

	public static function add(Prestations $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Prestations $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Prestations $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Prestations::getAttributes(),"Prestations",["idPrestation" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Prestations::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Prestations",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}