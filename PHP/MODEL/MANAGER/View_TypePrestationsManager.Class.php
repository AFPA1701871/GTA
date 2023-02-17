<?php

class View_TypePrestationsManager 
{
	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Prestations::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_TypePrestations",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}