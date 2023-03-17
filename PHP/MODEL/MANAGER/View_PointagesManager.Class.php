<?php

class View_PointagesManager
{

	public static function getList(array $nomColonnes = null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$nomColonnes = ($nomColonnes == null) ? View_Pointages::getAttributes() : $nomColonnes;
		return DAO::select($nomColonnes, "View_Pointages",   $conditions,  $orderBy,  $limit,  $api,  $debug);
	}

	/**
	 * Donne la liste de toutes les prestations d'un utilisateur pour une période donnée avec, pour chacune, le nombre de jours pointés pour la période. ATTENTION: validePointage et reportePointage modifié => 0 si aucun valide/reporte, 1 si a été modifié, 2 si complet
	 *
	 * @param integer $idUtilisateur Utilisateur concerné
	 * @param string $periode Période sur laquelle porte la synthèse
	 */
	public static function getSomme(int $idUtilisateur, string $periode)
	{
		$db = DbConnect::getDb();
		// Utilisation de la formule AVG(DISTINCT X) pour résultat trinaire:
		// 	- Pointages tous à 0 (jamais reporté) => 0
		//	- Au moins un pointage de chaque état (modif après report) => 0.5
		//	- Pointages tous à 1 (entièrement reporté)=> 1
		// Multiplication par 2 pour avoir un entier pour passage en objet View_Pointages
		$q = $db->query('SELECT sum(nbHeuresPointage) as nbHeuresPointage, periode,idUo_Pointage, idMotif,numeroUo, libelleUo, codeMotif, libelleMotif, idProjet, codeProjet, libelleProjet, codePrestation,  idTypePrestation, numeroTypePrestation, libelleTypePrestation , AVG(DISTINCT validePointage)*2 as validePointage, AVG(DISTINCT reportePointage)*2 as reportePointage FROM gta_View_Pointages
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
