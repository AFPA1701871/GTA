<?php

class View_MotifsManager 
{


	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Motifs::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Motifs",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	}
}