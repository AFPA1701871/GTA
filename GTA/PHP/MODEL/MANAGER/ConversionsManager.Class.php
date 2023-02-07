<?php

class ConversionsManager 
{

	public static function add(Conversions $obj)
	{
 		return DAO::add($obj);
	}

	public static function update(Conversions $obj)
	{
 		return DAO::update($obj);
	}

	public static function delete(Conversions $obj)
	{
 		return DAO::delete($obj);
	}

	public static function findById($id)
	{
 		return DAO::select(Conversions::getAttributes(),"Conversions",["idConversion" => $id])[0];
	}

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?Conversions::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"Conversions",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}