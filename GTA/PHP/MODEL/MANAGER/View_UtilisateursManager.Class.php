<?php

class View_UtilisateursManager
{

	public static function add(View_Utilisateurs $obj)
	{
		return DAO::add($obj);
	}

	public static function update(View_Utilisateurs $obj)
	{
		return DAO::update($obj);
	}

	public static function delete(View_Utilisateurs $obj)
	{
		return DAO::delete($obj);
	}

	public static function findById($id)
	{
		return DAO::select(View_Utilisateurs::getAttributes(), "View_Utilisateurs", ["idUtilisateur" => $id])[0];
	}

	public static function getList(array $nomColonnes = null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$nomColonnes = ($nomColonnes == null) ? View_Utilisateurs::getAttributes() : $nomColonnes;
		return DAO::select($nomColonnes, "View_Utilisateurs",   $conditions,  $orderBy,  $limit,  $api,  $debug);
	}
}
