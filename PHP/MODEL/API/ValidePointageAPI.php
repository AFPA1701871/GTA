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
        // Pas mis en mode "ReportSIRH" pour permettre aux assistantes de changer d'utilisateur par select
        echo "Back";
    }
    else{
        echo "Reload";
    }
}
