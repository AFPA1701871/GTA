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
	public static function SommePointage($idUtilisateur,$periode)
	{
		$db = DbConnect::getDb();
        $q = $db->query('SELECT sum(cumulPointage) as somme FROM gta_View_Pointages_Periode WHERE idUtilisateur=' . $idUtilisateur . '  AND periode = "' . $periode . '" ');
        $liste = [];
        if (!$q) {
            return false;
        }
        return $q->fetch(PDO::FETCH_ASSOC)['somme'];	
	}
	public static function NbValide($idUtilisateur,$periode,$pointDeVue)
	{
		//pointDeVue permet d'alterner entre idUtilisateur pour savoir si l'utilisateur est validé
		// ou Manager pour savoir combien de personnes le manager a validé
		$db = DbConnect::getDb();
        $q = $db->query('SELECT distinct idUtilisateur as nb FROM gta_View_Pointages_Periode WHERE id'.$pointDeVue.'=' . $idUtilisateur . '  AND periode = "' . $periode . '" AND validePointage= 1');
        $liste = [];
        if (!$q) {
            return false;
        }
        return count($q->fetchAll());	// nombre d'utilisateur different valide pour la periode
	}
	public static function NbReporte($idUtilisateur,$periode,$pointDeVue)
	{
		$db = DbConnect::getDb();
		$cond =  ($pointDeVue=="Utilisateur")?"idUtilisateur=" . $idUtilisateur ." AND ":""; 
        $q = $db->query('SELECT distinct idUtilisateur as nb FROM gta_View_Pointages_Periode WHERE '.$cond.'  periode = "' . $periode . '" AND reportePointage= 1');
        $liste = [];
        if (!$q) {
            return false;
        }
        return count($q->fetchAll());
	}
}
