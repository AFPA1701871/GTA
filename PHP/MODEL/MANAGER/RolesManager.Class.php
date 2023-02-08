<?php

class RolesManager 
{

	public static function add(Roles $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Roles $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Roles $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Roles::getAttributes(),"Roles",["idRole" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Roles::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Roles",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}