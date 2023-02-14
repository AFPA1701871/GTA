<?php

class View_Prestations_Pref_PointManager
{

    public static function add(View_Prestations_Pref_Point $obj)
    {
        return DAO::add($obj);
    }

    public static function update(View_Prestations_Pref_Point $obj)
    {
        return DAO::update($obj);
    }

    public static function delete(View_Prestations_Pref_Point $obj)
    {
        return DAO::delete($obj);
    }

    public static function findById($id)
    {
        return DAO::select(View_Prestations_Pref_Point::getAttributes(), "View_Prestations_Pref_Point", ["idPrestation" => $id])[0];
    }

    public static function getList(array $nomColonnes = null, array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
    {
        $nomColonnes = ($nomColonnes == null) ? View_Prestations_Pref_Point::getAttributes() : $nomColonnes;
        return DAO::select($nomColonnes, "View_Prestations_Pref_Point", $conditions, $orderBy, $limit, $api, $debug);}

    public static function getListePrestation($idUtilisateur, $mois, $idType)
    {
        $db = DbConnect::getDb();
        $q = $db->query('SELECT distinct idPrestation, codePrestation, libellePrestation, numeroTypePrestation, libelleTypePrestation, motifRequis, uoRequis, projetRequis,idMotif,codeMotif, idProjet,codeProjet,numeroUO, idTypePrestation, idUtilisateur FROM gta_View_Prestations_Pref_Point WHERE idUtilisateur='.$idUtilisateur.' AND idTypePrestation = '.$idType.' AND (mois = '.$mois.' || isnull(mois))');
        $liste=[];
        if (!$q)
        {
            return false;
        }
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        { // on récupère les enregistrements de la BDD
            if ($donnees != false)
        {
                $liste[] = new View_Prestations_Pref_Point($donnees);
            }
        }
        return $liste;
    }
}
