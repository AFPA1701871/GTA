<?php
// on cherche la présence d'une entrée dans la BDD d'une préférence coorespondante aux données passées
$elt=new Preferences($_POST);
$listPref=PreferencesManager::getList(["idPreference"], ["idPreference"=>$elt->getIdPreference()]);

$preference=(isset($listPref[0])?$listPref[0]:null);

if($preference==null){
    // Si la préférence n'éxiste pas, on la crée
    $newPref=PreferencesManager::add($elt);
    echo json_encode($newPref);
}else{
    // Si une entrée existe déjà, on la supprime
    PreferencesManager::delete($elt);
}