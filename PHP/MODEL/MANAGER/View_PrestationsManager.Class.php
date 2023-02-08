<?php

class View_PrestationsManager 
{

	public static function add(View_Prestations $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(View_Prestations $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(View_Prestations $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(View_Prestations::getAttributes(),"View_Prestations",["idPrestation" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Prestations::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Prestations",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}