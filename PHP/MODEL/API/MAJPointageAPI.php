<?php
// Si le pointage n'existe pas encore
if (!isset($_POST['idPointage'])) {
    // Et que le pointage n'est pas vide
    if ($_POST['nbHeuresPointage'] != "") {
        // Ajout et retour de l'idPointage créé
        $elm = new Pointages($_POST);
        // Check si pointage déjà dans BDD (problème connexion lors ajout précédent)
        // on crée le tableau des condition pour rechercher l'id
        $condCont = $_POST;
        // on en supprime le nbre d'heures pointées
        unset($condCont['nbHeuresPointage']);
        // on met les champs vides à null pour traitement par DAO        
        foreach ($condCont as $key => $value) {
            if ($condCont[$key] == "") {
                $condCont[$key] = null;
            }
        }
        // Recherche si pointage existe déjà
        $idPointageCont = PointagesManager::getList(["idPointage", "nbHeuresPointage"], $condCont, null, null, true, false);

        // Si le pointage existait déjà
        if (count($idPointageCont) == 1) {
            // Si le nombre d'heures est différent
            if ($idPointageCont[0]["nbHeuresPointage"] != $_POST['nbHeuresPointage']) {
                // On met à jour l'objet pointage
                $elm->setIdPointage($idPointageCont[0]["idPointage"]);
                $elm->setNbHeuresPointage($idPointageCont[0]["nbHeuresPointage"]);
                // On passe les états Validé et Reporté à 0
                $elm->setValidePointage(0);
                $elm->setReportePointage(0);
                // On sauvegarde la modification
                PointagesManager::update($elm);
            }
            // et on renvoit l'idPointage 
            echo json_encode($idPointageCont[0]["idPointage"]);
        } else {
            // Sinon, c'est un nouveau pointage et on l'ajoute en mémoire
            $newId = PointagesManager::add($elm);
            echo json_encode($newId);
        }
    }
} else { // modification d'un pointage
    $pointage = PointagesManager::findById($_POST['idPointage']);
    $nouvNbHeurePoint = (float)$_POST['nbHeuresPointage'];
    // Si la nouvelle valeur du pointage est 0 et qu'il n'a pas encore été pris en compte pour le report SIRH
    // Check reportePointage pour gestion affichage dans synthèse
    // Peut pas indiquer qu'on a perdu des heures si pas de trace
    if ($nouvNbHeurePoint == 0 && $pointage->getReportePointage() == 0) {
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
