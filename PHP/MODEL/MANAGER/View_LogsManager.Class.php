<?php

class View_LogsManager 
{

	public static function add(View_Logs $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(View_Logs $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(View_Logs $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(View_Logs::getAttributes(),"Logs",["idLog" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Logs::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Logs",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}