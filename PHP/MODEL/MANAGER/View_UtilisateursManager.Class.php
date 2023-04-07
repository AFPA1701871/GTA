<?php

class View_UtilisateursManager
{

	public static function getList(array $nomColonnes = null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$nomColonnes = ($nomColonnes == null) ? View_Utilisateurs::getAttributes() : $nomColonnes;
		return DAO::select($nomColonnes, "View_Utilisateurs",   $conditions,  $orderBy,  $limit,  $api,  $debug);
	}
	public static function getListActifPeriode($periode ,$idManager=null, $idRole=null)
	{
		$db = DbConnect::getDb();

		$req = 'SELECT u.idUtilisateur, u.nomUtilisateur, u.mailUtilisateur, u.matriculeUtilisateur, u.idUo, u.idRole, u.idManager,
    (substring(c.dateDebutContrat,1,7) <= "' . $periode . '" AND substring(c.dateFinContrat,1,7) >= "' . $periode . '" ) as actif
FROM gta_Utilisateurs u LEFT JOIN gta_Contrats as c ON c.idContrat in (
        SELECT idContrat FROM gta_Contrats WHERE gta_Contrats.idUtilisateur = u.idUtilisateur) WHERE u.idUtilisateur!=1 ';
		if($idManager!=null){
			$req.=' AND idManager='.$idManager;
		}
		if($idRole!=null){
			$req.=' AND idRole='.$idRole;
		}
		$req.=' having actif=1 order by nomUtilisateur';
		$q = $db->query($req);
		//echo $req;
		$liste = [];
		if (!$q) return false;
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { // on récupère les enregistrements de la BDD
			if ($donnees != false) {
				$liste[] = new Utilisateurs($donnees);
			}
		}
		return $liste;
	}
}
