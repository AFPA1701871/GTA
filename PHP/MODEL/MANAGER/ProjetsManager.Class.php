<?php

class ProjetsManager 
{

	public static function add(Projets $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Projets $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Projets $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Projets::getAttributes(),"Projets",["idProjet" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Projets::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Projets",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}