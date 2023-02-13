<?php
// Création d'un objet Pointages avec les élements du POST
$elm = new Pointages($_POST);

// Vérification si le pointage existe déjà
$listePointage = PointagesManager::getList(["idPointage"], ["idPointage" => $elm->getIdPointage()]);
$pointage = (isset($listePointage[0]) ? $listePointage[0] : null);

if ($pointage == null) {
    // Ajout et retour de l'idPointage créé
    $newId = PointagesManager::add($elm);
    echo json_encode($newId);
} else {
    // Update
    PointagesManager::update($elm);
}
