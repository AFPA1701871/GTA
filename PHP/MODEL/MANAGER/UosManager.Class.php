<?php

class UOsManager
{

	public static function add(UOs $obj)
	{
		return DAO::add($obj);
	}

	public static function update(UOs $obj)
	{
		return DAO::update($obj);
	}

	public static function delete(UOs $obj)
	{
		return DAO::delete($obj);
	}

	public static function findById($id)
	{
		return DAO::select(UOs::getAttributes(), "UOs", ["idUO" => $id])[0];
	}

	public static function getList(array $nomColonnes = null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$nomColonnes = ($nomColonnes == null) ? UOs::getAttributes() : $nomColonnes;
		return DAO::select($nomColonnes, "UOs",   $conditions,  $orderBy,  $limit,  $api,  $debug);
	}
}
