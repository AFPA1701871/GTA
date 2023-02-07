<?php

class View_MotifsManager 
{

	public static function add(View_Motifs $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(View_Motifs $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(View_Motifs $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(View_Motifs::getAttributes(),"View_Motifs",["idMotif" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Motifs::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Motifs",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}