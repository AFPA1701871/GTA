<?php

class PreferencesManager 
{

	public static function add(Preferences $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Preferences $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Preferences $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Preferences::getAttributes(),"Preferences",["idPreference" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Preferences::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Preferences",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}