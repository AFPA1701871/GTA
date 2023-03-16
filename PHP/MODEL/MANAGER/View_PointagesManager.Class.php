<?php

class View_PointagesManager
{

	public static function getList(array $nomColonnes = null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$nomColonnes = ($nomColonnes == null) ? View_Pointages::getAttributes() : $nomColonnes;
		return DAO::select($nomColonnes, "View_Pointages",   $conditions,  $orderBy,  $limit,  $api,  $debug);
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
	 * @param integer $idUtilisateur Utilisateur concerné
	 * @param string $periode Période concerné
	 * @param string $condition Sur quoi porte le contrôle ("V" => les pointages validés, "R" => les pointages reportés SIRH, "VR" => les deux)
	 * @param View_Pointages|null $pointage View_Pointage pour lequel on veut le détail, si présent
	 */
	public static function checkModif(int $idUtilisateur, string $periode, string $condition, ?View_Pointages $pointage = null)
	{
		// Connection à la base de données
		$db = DbConnect::getDb();
		// Début de création de la requête
		$stmt = 'SELECT sum(nbHeuresPointage) as heuresDif FROM gta_View_Pointages
		WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" ';

		switch ($condition) {
			case 'V':
				// Conditionné sur le fait qu'on ne veut que les pointages pas validés
				$stmt .= ' AND validePointage = 0 ';
				break;
			case 'R':
				// Conditionné sur le fait qu'on ne veut que les pointages pas reportés
				$stmt .= ' AND reportePointage = 0 ';
				break;
			case 'VR':
				// Si on veut au moins l'un des deux
				$stmt .= ' AND (validePointage = 0 OR reportePointage = 0) ';
				break;
		}

		if ($pointage!=null) {
			// Gestion de la demande du mode détailé
			$stmt .= ' AND idTypePrestation=' . $pointage->getIdTypePrestation() . ' AND codePrestation="' . $pointage->getCodePrestation() . '" ';
			// Gestion des champs pouvants être null
			$stmt .= ' AND idProjet' . ($pointage->getIdProjet() == null ? ' IS NULL' : '="' . $pointage->getIdProjet() . '" ');
			$stmt .= ' AND idMotif' . ($pointage->getIdMotif() == null ? ' IS NULL' : '="' . $pointage->getIdMotif() . '" ');
			$stmt .= ' AND idUo_Pointage' . ($pointage->getIdUo_Pointage() == null ? ' IS NULL' : '="' . $pointage->getIdUo_Pointage() . '" ');
			// Complétion de la requête
			$stmt .= ' GROUP BY idUtilisateur, idMotif, idPrestation, idProjet, idUo_Pointage,  idTypePrestation';
		}
		$q = $db->query($stmt);

		$liste = [];
		if (!$q) return false;
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { // on récupère les enregistrements de la BDD
			if ($donnees != false) {
				$liste[] = $donnees["heuresDif"];
			}
		}
		// 
		return (count($liste) == 1 && $liste[0] != null);
	}

	/**
	 * Fonction récupérant la liste de tous les salariés ayant complétement remplis leur feuille de pointage pour une période donnée
	 * Limité ou non en fonction de leur manager
	 *
	 * @param string $periode La période pour laquelle on veut que les salariés aient complétement saisie leur pointage
	 * @param integer|null $idManager L'ID du Manager, pour synthèse des managers, sinon vide pour synthèse des assistantes 
	 */
	public static function getListSaisiesCompl(string $periode, ?int $idManager=null){
		$db = DbConnect::getDb();
		$stmt = 'SELECT idUtilisateur, nomUtilisateur FROM gta_View_Pointages WHERE ';
		if($idManager!=null){
			$stmt.= ' idManager='.$idManager.' AND ';
		}
		// Si on veut que tous les pointages soient validés
		// $stmt .= ' validePointage=1 AND ';
		$stmt .=' periode = "'.$periode.'" GROUP BY idUtilisateur HAVING sum(nbHeuresPointage)='.NbJourParPeriode($periode).' ORDER BY nomUtilisateur;';
		$q = $db->query($stmt);
		if (!$q) return false;
		$liste=[];
		// return $q->fetchAll(PDO::FETCH_ASSOC);
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { // on récupère les enregistrements de la BDD
			if ($donnees != false) {
				$liste[$donnees["idUtilisateur"]] = $donnees["nomUtilisateur"];
			}
		}
		return $liste;
	}
}
