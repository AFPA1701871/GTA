<?php

class View_Pointages_PeriodeManager
{

	public static function add(View_Pointages_Periode $obj)
	{
		return DAO::add($obj);
	}

	public static function update(View_Pointages_Periode $obj)
	{
		return DAO::update($obj);
	}

	public static function delete(View_Pointages_Periode $obj)
	{
		return DAO::delete($obj);
	}

	public static function findById($id)
	{
		return DAO::select(View_Pointages_Periode::getAttributes(), "View_Pointages_Periode", ["periode" => $id])[0];
	}

	public static function getList(array $nomColonnes = null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$nomColonnes = ($nomColonnes == null) ? View_Pointages_Periode::getAttributes() : $nomColonnes;
		return DAO::select($nomColonnes, "View_Pointages_Periode",   $conditions,  $orderBy,  $limit,  $api,  $debug);
	}
	public static function SommePointage($idUtilisateur, $periode)
	{
		$db = DbConnect::getDb();
		$q = $db->query('SELECT sum(cumulPointage) as somme FROM gta_View_Pointages_Periode WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" ');
		if (!$q) {
			return false;
		}
		return $q->fetch(PDO::FETCH_ASSOC)['somme'];
	}

	// public static function NbValide($idUtilisateur, $periode, $pointDeVue)
	// {
	// 	//pointDeVue permet d'alterner entre idUtilisateur pour savoir si l'utilisateur est validé
	// 	// ou Manager pour savoir combien de personnes le manager a validé
	// 	$db = DbConnect::getDb();
	// 	$q = $db->query('SELECT distinct idUtilisateur as nb FROM gta_View_Pointages_Periode WHERE id' . $pointDeVue . '=' . $idUtilisateur . '  AND periode = "' . $periode . '" AND validePointage= 1');
	// 	if (!$q) {
	// 		return false;
	// 	}
	// 	return count($q->fetchAll());	// nombre d'utilisateur different valide pour la periode
	// }
	// public static function NbReporte($idUtilisateur, $periode, $pointDeVue)
	// {
	// 	$db = DbConnect::getDb();
	// 	$cond =  ($pointDeVue == "Utilisateur") ? "idUtilisateur=" . $idUtilisateur . " AND " : "";
	// 	$q = $db->query('SELECT Distinct idUtilisateur as nb FROM gta_View_Pointages_Periode WHERE ' . $cond . '   periode = "' . $periode . '" AND reportePointage= 1');
	// 	if (!$q) {
	// 		return false;
	// 	}
	// 	return count($q->fetchAll());
	// }
	// public static function JoursValides($idUtilisateur, $periode)
	// {
	// 	//pointDeVue permet d'alterner entre idUtilisateur pour savoir si l'utilisateur est validé
	// 	// ou Manager pour savoir combien de personnes le manager a validé
	// 	$db = DbConnect::getDb();
	// 	$q = $db->query('SELECT SUM(cumulPointage) as nb FROM gta_View_Pointages_Periode WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" AND validePointage= 1');
	// 	if (!$q) {
	// 		return false;
	// 	}
	// 	return $q->fetch(PDO::FETCH_ASSOC)['nb'];    // nombre d'utilisateur different valide pour la periode
	// }

	// public static function JoursReportes($idUtilisateur, $periode)
	// {
	// 	//pointDeVue permet d'alterner entre idUtilisateur pour savoir si l'utilisateur est validé
	// 	// ou Manager pour savoir combien de personnes le manager a validé
	// 	$db = DbConnect::getDb();
	// 	$q = $db->query('SELECT SUM(cumulPointage) as nb FROM gta_View_Pointages_Periode WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" AND reportePointage= 1');
	// 	if (!$q) {
	// 		return false;
	// 	}
	// 	return $q->fetch(PDO::FETCH_ASSOC)['nb'];    // nombre d'utilisateur different valide pour la periode
	// }

	// Remplacement dans TbManager Lignes 36 et 39
	// ActionMail Lignes 233 et 257
	// Outils Lignes 247 et 257

	// public static function Synthese($idUtilisateur, $periode, $mode = null, $pointDeVue = null)
	// {
	// 	// Controle d'intégrité des arguments
	// 	if (($pointDeVue == null || $pointDeVue == "Utilisateur" || $pointDeVue == "Manager") && ($mode == null || $mode == "valide" || $mode == "reporte")) {
	// 		// Connection à la base de données
	// 		$db = DbConnect::getDb();
	// 		if ($mode == null) {
	// 			$joursOuvres = NbJourParPeriode($periode);
	// 			$stmt = 'SELECT SUM(cumulPointage) as nb FROM gta_View_Pointages_Periode WHERE idManager=' . $idUtilisateur . '  AND periode = "' . $periode . '" GROUP BY idUtilisateur HAVING nb=' . $joursOuvres;
	// 		}
	// 		// Si $pointDeVue est null, cas anciennement "JoursValides" et "JoursReportes"
	// 		else if ($pointDeVue == null) {
	// 			// Select récupérant la somme des pointages de l'utilisateur sur la période correspondants au mode
	// 			$stmt = 'SELECT SUM(cumulPointage) as nb FROM gta_View_Pointages_Periode WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" AND ' . $mode . 'Pointage= 1';
	// 		} else {
	// 			// Sinon, cas anciennement "NbValide" et "NbReporte"
	// 			$cond = "";
	// 			if ($pointDeVue == "Utilisateur") {
	// 				$cond = "idUtilisateur=" . $idUtilisateur . " AND ";
	// 			} else if ($mode == "valide") {
	// 				$cond = "idManager=" . $idUtilisateur . " AND ";
	// 			}

	// 			$stmt = 'SELECT distinct idUtilisateur as nb FROM gta_View_Pointages_Periode WHERE ' . $cond . ' periode = "' . $periode . '" AND ' . $mode . 'Pointage= 1';
	// 		}
	// 		$q = $db->query($stmt);
	// 		// Si aucun enregistrement de la base correspond aux critère, retourne faux
	// 		if (!$q) {
	// 			return false;
	// 		}
	// 		if ($pointDeVue == null && $mode != null) {
	// 			// On retourne soit la somme des pointages
	// 			return $q->fetch(PDO::FETCH_ASSOC)['nb'];
	// 		} else {
	// 			// Soit le nombre d'utilisateurs
	// 			return count($q->fetchAll());
	// 		}
	// 	}
	// }

	// public static function SyntheseClean($idUtilisateur, $periode, $mode = null, $pointDeVue = null, bool $assistante = false)
	// {
	// 	if (($pointDeVue == null || $pointDeVue == "Utilisateur" || $pointDeVue == "Manager") && ($mode == null || $mode == "valide" || $mode == "reporte")) {
	// 		// Connection à la base de données
	// 		$db = DbConnect::getDb();
	// 		$condID = "";
	// 		$condP = "";
	// 		$gBH = "";
	// 		if (!($mode == "reporte" && $pointDeVue == "Manager") || $assistante) {
	// 			$condID = ' id' . ($pointDeVue != null ? $pointDeVue : 'Utilisateur') . '=' . $idUtilisateur . ' AND ';
	// 		}
	// 		if ($mode != null) {
	// 			$condP = ' ' . $mode . 'Pointage=1 AND ';
	// 		}
	// 		if ($pointDeVue == "Manager") {
	// 			$gBH = ' GROUP BY idUtilisateur HAVING nb=' . NbJourParPeriode($periode);
	// 		}
	// 		$stmt = 'SELECT SUM(cumulPointage) as nb FROM gta_View_Pointages_Periode WHERE ' . $condID . $condP . ' periode="' . $periode . '" ' . $gBH;
	// 		//return $stmt;
	// 		$q = $db->query($stmt);
	// 		// Si problème avec la requête, retourne faux
	// 		if (!$q) {
	// 			return false;
	// 		}
	// 		if ($pointDeVue == null && $mode != null) {
	// 			// On retourne soit la somme des pointages
	// 			return $q->fetch(PDO::FETCH_ASSOC)['nb'];
	// 		} else {
	// 			// Soit le nombre d'utilisateurs
	// 			return count($q->fetchAll());
	// 		}
	// 	}
	// }

	/**
	 * Fonction permettant de récupérer soit le nombre de jours Validés/Reportés, soit le nombre de salarié ayant la période complétement Saisie/Validé/Reporté
	 *
	 * @param int $idUtilisateur L'ID de l'utilisateur sur lequel porte la recherche (normal ou manager en fct du $pointDeVue)
	 * @param string $periode Période sur laquelle porte la recherche (de la forme YYYY-MM)
	 * @param string $mode Détermine si l'on recherche sur Saisie (null), Validé (valide) ou Reporté (reporte)
	 * @param string $pointDeVue "Manager" ou "Utilisateur", détermine sur quel id la condition sera appliqué
	 * @param boolean $gbH Détermine si l'on veut un nombre de jours (false) ou un nombre d'utilisateurs (true)
	 */
	public static function SyntheseV3($idUtilisateur, $periode, $mode, $pointDeVue, bool $gbH = true)
	{
		// Connection à la base de données
		$db = DbConnect::getDb();
		// Condition sur l'idUtilisateur ou l'idManager, 
		// Absent dans l'appel pour les reportés depuis Outils, fonction periodeEnCours()
		$condID = ($idUtilisateur != null)?' id' . $pointDeVue . '=' . $idUtilisateur . ' AND ':"";
		// Condition sur validePointage ou reportePointage,
		// Absent lors de l'appel pour obtenir le nombre de salariés ayant complétement saisie leur pointage dans TbAssistantes
		$condP = ($mode != null)?' ' . $mode . 'Pointage=1 AND ':"";
		// Utilise-t-on un GROUP BY et faut-il que le cumul des pointages répondant aux autres critères soit égal au nombre de jours ouvrés du mois?
		// Partous sauf dans le TbManagers
		$condGBH = ($gbH)?' GROUP BY idUtilisateur HAVING nb=' . NbJourParPeriode($periode):"";
		// Assemblage de la requête
		$stmt = 'SELECT SUM(cumulPointage) as nb FROM gta_View_Pointages_Periode WHERE ' . $condID . $condP . ' periode="' . $periode . '" ' . $condGBH;
		$q = $db->query($stmt);
		// Si on rencontre un problème avec la requête, on retourne faux
		if (!$q) {
			return false;
		}
		// Sinon
		if (!$gbH) {
			// On retourne soit la somme des pointages => TbManagers
			return $q->fetch(PDO::FETCH_ASSOC)['nb'];
		} else {
			// Soit le nombre d'utilisateurs répondants aux critères => TbAssistantes, Outils, ActionMail
			return count($q->fetchAll());
		}
	}
}
