<?php
//var_dump($_POST);
// Controle que les variables sont bien passées dans le post et que statut contienne bien "V" ou "R"
// $_POST['statut'] parfois à "" lors de validation par Manager, orientant ainsi vers la colonne "ReportePointage"
if (isset($_POST['statut']) && ($_POST['statut']=="V" || $_POST['statut']=="R") && isset($_POST['periode']) && isset($_POST['idUtilisateur'])) {
    $idUtilisateur = $_POST['idUtilisateur'];
    $periode = $_POST['periode'];
    $colonne = ($_POST['statut'] == "V") ? "ValidePointage" : "ReportePointage";

    $listePointage = PointagesManager::getList(null, ['idUtilisateur' => $idUtilisateur, 'datePointage' => $periode . '%']);
    foreach ($listePointage as $key => $pointage) {
        $method = 'set' . $colonne;
        $pointage->$method("1");
        // var_dump($pointage);  
        PointagesManager::update($pointage);
    }
    if ($_POST['statut'] == "V") {
        // Envois d'une réponse pour valider le retour à la page pécédente automatique
        echo "Back";
    }
    else{
        // Test si des entrées existent dans les logs indiquant un changement
        $testLogs=LogsManager::getList(null, ['idUtilisateur' => $idUtilisateur, 'dateModifiee' => $periode.'%', 'prisEnCompte'=>0]);
        // Si au moins une telle entrée existe
        if(count($testLogs)!=0){
            foreach($testLogs as $log){
                // On indique que le changement a été pris en compte
                $log->setPrisEnCompte(1);
                // Et on sauvegarde la modifications des logs
                LogsManager::update($log);
            }
        }

        // Retrait des éventuels pointages à 0 utiliser pour déterminer les différences depuis dernier report SIRH
        PointagesManager::cleanUp($idUtilisateur, $periode);

        // Message de retour entrainant le rechargement de la page
        echo "Reload";
    }
}
