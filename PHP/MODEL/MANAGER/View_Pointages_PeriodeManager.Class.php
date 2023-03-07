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

	public static function Synthese($idUtilisateur, $periode, $mode, $pointDeVue = null)
	{
		// Controle d'intégrité des arguments
		if (($pointDeVue == null || $pointDeVue == "Utilisateur" || $pointDeVue == "Manager") && ($mode == "valide" || $mode == "reporte")) {
			// Connection à la base de données
			$db = DbConnect::getDb();
			// Si $pointDeVue est null, cas anciennement "JoursValides" et "JoursReportes"
			if ($pointDeVue == null) {
				// Select récupérant la somme des pointages de l'utilisateur sur la période correspondants au mode
				$stmt = 'SELECT SUM(cumulPointage) as nb FROM gta_View_Pointages_Periode WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" AND ' . $mode . 'Pointage= 1';
			} else {
				// Sinon, cas anciennement "NbValide" et "NbReporte"
				$cond = "";
				if ($pointDeVue == "Utilisateur") {
					$cond = "idUtilisateur=" . $idUtilisateur . " AND ";
				} else if ($mode == "valide") {
					$cond = "idManager=" . $idUtilisateur . " AND ";
				}

				$stmt = 'SELECT distinct idUtilisateur as nb FROM gta_View_Pointages_Periode WHERE ' . $cond . ' periode = "' . $periode . '" AND ' . $mode . 'Pointage= 1';
			}
			$q = $db->query($stmt);
			// Si aucun enregistrement de la base correspond aux critère, retourne faux
			if (!$q) {
				return false;
			}
			if ($pointDeVue == null) {
				// On retourne soit la somme des pointages
				return $q->fetch(PDO::FETCH_ASSOC)['nb'];
			} else {
				// Soit le nombre d'utilisateurs
				return count($q->fetchAll());
			}
		}
	}
}
