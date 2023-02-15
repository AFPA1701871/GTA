<?php

class View_PointagesManager 
{

	public static function add(View_Pointages $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(View_Pointages $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(View_Pointages $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(View_Pointages::getAttributes(),"View_Pointages",["idPointage" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Pointages::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Pointages",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}