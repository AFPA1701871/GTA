<?php

class UosManager 
{

	public static function add(Uos $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Uos $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Uos $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Uos::getAttributes(),"Uos",["idUO" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Uos::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Uos",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}