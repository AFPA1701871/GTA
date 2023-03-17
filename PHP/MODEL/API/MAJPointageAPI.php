<?php
// Si le pointage n'existe pas encore
if (!isset($_POST['idPointage'])) {
    // Et que le pointage n'est pas vide
    if ($_POST['nbHeuresPointage'] != "") {
        // Ajout et retour de l'idPointage créé
        $elm = new Pointages($_POST);
        $newId = PointagesManager::add($elm);
        // var_dump($elm);
        echo json_encode($newId);
    }
} else { // modification d'un pointage
    $pointage = PointagesManager::findById($_POST['idPointage']);
    $nouvNbHeurePoint=(float)$_POST['nbHeuresPointage'];
    // Si la nouvelle valeur du pointage est 0 et qu'il n'a pas encore été pris en compte pour le report SIRH
    // Check reportePointage pour gestion affichage dans synthèse
    // Peut pas indiquer qu'on a perdu des heures si pas de trace
    if ($nouvNbHeurePoint == 0 && $pointage->getReportePointage()==0) {
        // On le supprime
        PointagesManager::delete($pointage);
        echo "Delete";
    } else {

        $pointage->setNbHeuresPointage($nouvNbHeurePoint);
        PointagesManager::update($pointage);
        //var_dump($pointage);
        $periode = substr($pointage->getDatePointage(), 0, 7);

        //si le pointage modifié était déjà validé, on dévalide la période pour l'utilisateur
        if ($pointage->getValidePointage() != null)
            EnleveCocheUnit($pointage->getIdPointage(), "Valide");
        //EnleveCoche($pointage->getIdUtilisateur(), $periode,"Valide");

        // En cas de mise à jour, si le pointage modifié était déjà reporté, on enregistre l'action
        if ($pointage->getReportePointage() != null) {
            // On récupère le nom de la personne auquel le pointage a été modifié
            $user = UtilisateursManager::findById($pointage->getIdUtilisateur());

            // On ajout la modification dans les logs
            $log = new Logs(['dateModifiee' => $pointage->getDatePointage(), 'actionLog' => 'Le pointage de ' . $user->getNomUtilisateur() . ' a été modifié', 'idUtilisateur' => $pointage->getIdUtilisateur(), "userLog" => $_SESSION['utilisateur']->getNomUtilisateur()]);
            LogsManager::add($log);

            //on enlève la coche SIRH sur tout le pointage de la periode pour la personne
            EnleveCocheUnit($pointage->getIdPointage(), "Reporte");
            //EnleveCoche($pointage->getIdUtilisateur(), $periode,"Reporte");
        }
    }
}

//   function EnleveCoche($idUtilisateur, $periode,$type)
//    {
//     $pointages = View_PointagesManager::getList(null,["idUtilisateur"=>$idUtilisateur,"periode"=>$periode]);
//     foreach ($pointages as $pointageV) {
//         $pointage = PointagesManager::findById($pointageV->getIdPointage());
//         $method = "set".$type."Pointage";
//         //call_user_func(array($pointage, $method,"0"));
//         $pointage->$method(0);
//         //var_dump($pointage);
//         PointagesManager::update($pointage);
//     }
//    }

function EnleveCocheUnit($idPointage, $type)
{

    $pointage = PointagesManager::findById($idPointage);
    $method = "set" . $type . "Pointage";
    //call_user_func(array($pointage, $method,"0"));
    $pointage->$method(0);
    //var_dump($pointage);
    PointagesManager::update($pointage);
}
