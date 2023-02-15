<?php

class View_UtilisateursManager
{

	public static function getList(array $nomColonnes = null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$nomColonnes = ($nomColonnes == null) ? View_Utilisateurs::getAttributes() : $nomColonnes;
		return DAO::select($nomColonnes, "View_Utilisateurs",   $conditions,  $orderBy,  $limit,  $api,  $debug);
	}
}
