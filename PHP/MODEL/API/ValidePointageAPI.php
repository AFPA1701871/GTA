<?php
//var_dump($_POST);
$idUtilisateur = $_POST['idUtilisateur'];
$periode = $_POST['periode'];
$colonne= ($_POST['statut']=="V")?"ValidePointage":"ReportePointage";
$listePointage = PointagesManager::getList(null,['idUtilisateur'=>$idUtilisateur,'datePointage'=>$periode.'%']);
foreach ($listePointage as $key => $pointage) {
    $method = 'set'.$colonne;
    $pointage->$method("1");
    //var_dump($pointage);
    PointagesManager::update($pointage);
}