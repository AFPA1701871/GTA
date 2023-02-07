<?php

class ContratsManager 
{

	public static function add(Contrats $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Contrats $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Contrats $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Contrats::getAttributes(),"Contrats",["idContrat" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Contrats::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Contrats",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}