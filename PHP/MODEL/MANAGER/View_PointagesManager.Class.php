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
		$q = $db->query('SELECT sum(nbHeuresPointage) as nbHeuresPointage, periode,idUo_Pointage, idMotif,numeroUo, libelleUo, codeMotif, libelleMotif, idProjet, codeProjet, libelleProjet, codePrestation,  idTypePrestation, numeroTypePrestation, libelleTypePrestation , validePointage, reportePointage FROM gta_View_Pointages
			 WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" 
			 GROUP BY idUtilisateur, idMotif, codePrestation, idProjet, idUo_Pointage,  idTypePrestation
			 ORDER BY idTypePrestation, codePrestation');
		$liste = [];
		if (!$q) return false;
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { // on récupère les enregistrements de la BDD
			if ($donnees != false) {
				$liste[] = new View_Pointages($donnees);
			}
		}
		return $liste;
	}

	/**
	 * Fonction permettant de mettre en avant les prestations ayant été modifiées depuis le report SIRH
	 *
	 * @param integer $idUtilisateur
	 * @param string $periode
	 * @param integer $idTypePrestation
	 * @param string $codePrestation
	 * @param integer|null $idProjet
	 * @param integer|null $idMotif
	 * @param integer|null $idUo_Pointage
	 * @return bool Retourne si oui ou non elle à été modifié
	 */
	public static function checkModif(int $idUtilisateur, string $periode, int $idTypePrestation, string $codePrestation, ?int $idProjet, ?int $idMotif, ?int $idUo_Pointage){
		// Connection à la base de données
		$db = DbConnect::getDb();
		// Début de création de la requête
		$stmt = 'SELECT sum(nbHeuresPointage) as heuresDif FROM gta_View_Pointages
		WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" AND idTypePrestation='.$idTypePrestation.' AND codePrestation="'.$codePrestation.'" ';
		
		// Conditionné sur le fait qu'on ne veut que les pointages pas reportés
		$stmt.= ' AND reportePointage = 0 ';

		// Si que les non-validés
		// $stmt.= ' AND validePointage = 0 ';
		// Si on veut au moins l'un des deux
		// $stmt.= ' AND (validePointage = 0 OR reportePointage = 0) ';

		// Gestion des champs pouvants être null
		$stmt.= ' AND '.($idProjet==null?'ISNULL(idProjet)':'idProjet="'.$idProjet.'" ');
		$stmt.= ' AND '.($idMotif==null?'ISNULL(idMotif)':'idMotif="'.$idMotif.'" ');
		$stmt.= ' AND '.($idUo_Pointage==null?'ISNULL(idUo_Pointage)':'idUo_Pointage="'.$idUo_Pointage.'" ');
		// Complétion de la requête
		$stmt.= ' GROUP BY idUtilisateur, idMotif, idPrestation, idProjet, idUo_Pointage,  idTypePrestation';
		$q=$db->query($stmt);

		$liste = [];
		if (!$q) return false;
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { // on récupère les enregistrements de la BDD
			if ($donnees != false) {
				$liste[] = $donnees["heuresDif"];
			}
		}
		// 
		return (count($liste)==1 && $liste[0]!=null);
	}
}