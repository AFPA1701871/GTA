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
	 * @param bool|null $details Veut-on l'info pour une prestation donnée?
	 * @param integer|null $idTypePrestation 
	 * @param string|null $codePrestation
	 * @param integer|null $idProjet
	 * @param integer|null $idMotif
	 * @param integer|null $idUo_Pointage
	 * @return bool Retourne si oui ou non elle à été modifié
	 */
	public static function checkModif(int $idUtilisateur, string $periode, string $condition, ?bool $details = false, ?int $idTypePrestation = 0, ?string $codePrestation = "", ?int $idProjet = null, ?int $idMotif = null, ?int $idUo_Pointage = null)
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

		if ($details) {
			// Gestion de la demande du mode détailé
			$stmt .= ' AND idTypePrestation=' . $idTypePrestation . ' AND codePrestation="' . $codePrestation . '" ';
			// Gestion des champs pouvants être null
			$stmt .= ' AND idProjet' . ($idProjet == null ? ' IS NULL' : '="' . $idProjet . '" ');
			$stmt .= ' AND idMotif' . ($idMotif == null ? ' IS NULL' : '="' . $idMotif . '" ');
			$stmt .= ' AND idUo_Pointage' . ($idUo_Pointage == null ? ' IS NULL' : '="' . $idUo_Pointage . '" ');
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
}
