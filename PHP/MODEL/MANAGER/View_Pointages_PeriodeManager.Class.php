<?php

class View_Pointages_PeriodeManager 
{

	public static function add(View_Pointages_Periode $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(View_Pointages_Periode $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(View_Pointages_Periode $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(View_Pointages_Periode::getAttributes(),"View_Pointages_Periode",["periode" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Pointages_Periode::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Pointages_Periode",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}