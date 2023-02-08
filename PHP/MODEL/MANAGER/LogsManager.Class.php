<?php

class LogsManager 
{

	public static function add(Logs $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Logs $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Logs $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Logs::getAttributes(),"Logs",["idLog" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Logs::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Logs",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}