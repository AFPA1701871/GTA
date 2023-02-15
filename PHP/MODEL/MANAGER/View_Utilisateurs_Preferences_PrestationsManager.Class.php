<?php

class View_Utilisateurs_Preferences_PrestationsManager 
{

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Utilisateurs_Preferences_Prestations::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Utilisateurs_Preferences_Prestations",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}