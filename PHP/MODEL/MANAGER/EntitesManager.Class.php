<?php

class EntitesManager 
{

	public static function add(Entites $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Entites $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Entites $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Entites::getAttributes(),"Entites",["idEntite" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Entites::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Entites",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}