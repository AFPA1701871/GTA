<?php

if ($_POST['idPointage'] == null) {
    // Ajout et retour de l'idPointage créé
    $elm = new Pointages($_POST);
    $newId = PointagesManager::add($elm);
    // var_dump($elm);
    echo json_encode($newId);
} else {
    $pointage = PointagesManager::findById($_POST['idPointage']);
    $pointage->setNbHeuresPointage((float)$_POST['nbHeuresPointage']);
    PointagesManager::update($pointage);

    // En cas de mise à jour, si le pointage modifié était déjà reporté, on enregistre l'action
    if ($pointage->getReportePointage() != null) {
        // On récupère le nom de la personne auquel le pointage a été modifié
        $user = UtilisateursManager::findById($pointage->getIdUtilisateur());

        // On ajout la modification dans les logs
        $log = new Logs(['dateModifiee' => $pointage->getDatePointage(), 'actionLog' => 'Le pointage de '.$user->getNomUtilisateur().' a été modifié', 'idUtilisateur' => $pointage->getIdUtilisateur(),"userLog"=>$_SESSION['utilisateur']->getNomUtilisateur()]);
        LogsManager::add($log);
        var_dump($log);
    }
}
