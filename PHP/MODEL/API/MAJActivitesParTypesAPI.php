<?php
$elm = new ActivitesParTypes($_POST);

switch ($_POST["mode"]) {
        // Action ajouter
    case "0":
        // Ajout
        $elm = ActivitesParTypesManager::add($elm);
        break;

        // Action supprimer
    case "1":
        // Recherche de l'idActivitesParTypes correspondant
        $apt = ActivitesParTypesManager::getList(["idActivitesParTypes"], ["idTypePrestation" => $elm->getIdTypePrestation(), "idActivite" => $elm->getIdActivite()]);
        $idActiviteParType = $apt[0]->getIdActivitesParTypes();

        // Ajout de l'id dans l'objet elm
        $elm->setIdActivitesParTypes($idActiviteParType);
        // Suppression
        $elm = ActivitesParTypesManager::delete($elm);
        break;
}
