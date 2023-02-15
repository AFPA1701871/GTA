<?php

class View_PointagesManager 
{

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Pointages::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Pointages",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}