<?php

class AssociationsManager 
{

	public static function add(Associations $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Associations $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Associations $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Associations::getAttributes(),"Associations",["idAssociation" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Associations::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Associations",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}