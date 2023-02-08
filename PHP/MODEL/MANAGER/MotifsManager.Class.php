<?php

class MotifsManager 
{

	public static function add(Motifs $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Motifs $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Motifs $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Motifs::getAttributes(),"Motifs",["idMotif" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Motifs::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Motifs",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}