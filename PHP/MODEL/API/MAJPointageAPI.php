<?php
// Création d'un objet Pointages avec les élements du POST
$elm = new Pointages($_POST);

// Vérification si le pointage existe déjà
$listePointage = PointagesManager::getList(["idPointage"], ["idPointage" => $elm->getIdPointage()]);
$pointage = (isset($listePointage[0]) ? $listePointage[0] : null);

if ($pointage == null) {
    // Ajout et retour de l'idPointage créé
    $newId = PointagesManager::add($elm);
    var_dump($elm);
    echo json_encode($newId);
} else {
    // En cas de mise à jour, si le pointage modifié était déjà validé, on enregistre l'action
    // On récupère l'état de validation du pointage - la requête précédente semble vide...
    $pointages = PointagesManager::getList(["validePointage", "datePointage"], ["idPointage" => $elm->getIdPointage()]);

    // On vérifie si c'est validé
    if ($pointages[0]->getValidePointage() != null) {
        // On récupère le nom de la personne auquel le pointage a été modifié
        $user = UtilisateursManager::findById($elm->getIdUtilisateur());

        // On ajout la modification dans les logs
        $update = new Logs(['dateLog' => $pointages[0]->getDatePointage(), 'actionLog' => 'Le pointage de '.$user->getNomUtilisateur().' a été modifié', 'idUtilisateur' => $elm->getIdUtilisateur()]);
        LogsManager::add($update);
    }

    // Update
    PointagesManager::update($elm);
}
