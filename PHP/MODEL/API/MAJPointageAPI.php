<?php
if (!isset($_POST['idPointage']) ) {
    // Ajout et retour de l'idPointage créé
    $elm = new Pointages($_POST);
    $newId = PointagesManager::add($elm);
    // var_dump($elm);
    echo json_encode($newId);
} else { // modification d'un pointage
    $pointage = PointagesManager::findById($_POST['idPointage']);
    $pointage->setNbHeuresPointage((float)$_POST['nbHeuresPointage']);
    PointagesManager::update($pointage);
    //var_dump($pointage);
    $periode = substr($pointage->getDatePointage(),0,7);
    
    //si le pointage modifié était déjà validé, on dévalide la période pour l'utilisateur
    if ($pointage->getValidePointage() != null) 
        EnleveCoche($pointage->getIdUtilisateur(), $periode,"Valide");

    // En cas de mise à jour, si le pointage modifié était déjà reporté, on enregistre l'action
    if ($pointage->getReportePointage() != null) {
        // On récupère le nom de la personne auquel le pointage a été modifié
        $user = UtilisateursManager::findById($pointage->getIdUtilisateur());

        // On ajout la modification dans les logs
        $log = new Logs(['dateModifiee' => $pointage->getDatePointage(), 'actionLog' => 'Le pointage de '.$user->getNomUtilisateur().' a été modifié', 'idUtilisateur' => $pointage->getIdUtilisateur(),"userLog"=>$_SESSION['utilisateur']->getNomUtilisateur()]);
        LogsManager::add($log);

        //on enlève la coche SIRH sur tout le pointage de la periode pour la personne
        EnleveCoche($pointage->getIdUtilisateur(), $periode,"Reporte");
    }
}

  function EnleveCoche($idUtilisateur, $periode,$type)
   {
    $pointages = View_PointagesManager::getList(null,["idUtilisateur"=>$idUtilisateur,"periode"=>$periode]);
    foreach ($pointages as $pointageV) {
        $pointage = PointagesManager::findById($pointageV->getIdPointage());
        $method = "set".$type."Pointage";
        //call_user_func(array($pointage, $method,"0"));
        $pointage->$method(0);
        //var_dump($pointage);
        PointagesManager::update($pointage);
    }
   }