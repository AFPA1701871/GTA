<?php

class TypePrestationsManager 
{

	public static function add(TypePrestations $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(TypePrestations $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(TypePrestations $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(TypePrestations::getAttributes(),"TypePrestations",["idTypePrestation" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?TypePrestations::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"TypePrestations",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}