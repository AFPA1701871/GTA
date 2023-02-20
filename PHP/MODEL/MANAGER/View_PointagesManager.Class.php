<?php

class View_PointagesManager 
{

	public static function getList(array $nomColonnes=null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
 		$nomColonnes = ($nomColonnes==null)?View_Pointages::getAttributes():$nomColonnes;
		return DAO::select($nomColonnes,"View_Pointages",   $conditions ,  $orderBy,  $limit ,  $api,  $debug );	
	}
	public static function getSomme(int $idUtilisateur, string $periode)
	{
		$db = DbConnect::getDb();
		$q = $db->query('SELECT sum(nbHeuresPointage) as nbHeuresPointage, periode,idUo_Pointage, idMotif,numeroUo, libelleUo, codeMotif, libelleMotif, idProjet, codeProjet, libelleProjet, codePrestation,  idTypePrestation, numeroTypePrestation, libelleTypePrestation FROM gta_View_Pointages
			 WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" 
			 GROUP BY idUtilisateur, idMotif, codePrestation, idProjet, idUo_Pointage,  idTypePrestation');
		$liste = [];
		if (!$q) return false;
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { // on récupère les enregistrements de la BDD
			if ($donnees != false) {
				$liste[] = new View_Pointages($donnees);
			}
		}
		return $liste;
	}
}