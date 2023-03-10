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

	// Remplacement dans TbManager Lignes 36 et 39
	// ActionMail Lignes 233 et 257
	// Outils Lignes 247 et 257

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
