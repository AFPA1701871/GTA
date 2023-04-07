<?php
//var_dump($_POST);
$table = $_POST["table"];
//var_dump($table);
$table = ($table=="Motifs" || $table=="Prestations"|| $table=="Utilisateurs")?"View_".$table:$table;
$nomColonnes = ($table=="View_Utilisateurs")?["idUtilisateur", "nomUtilisateur",  "matriculeUtilisateur",  "nomManager",  "actif", "numeroUo", "nomRole"]:$table::getAttributes();
$conditions = json_decode($_POST["conditions"], true);
$selection = json_decode($_POST["selection"], true);
if (count($selection) == 0 && count($conditions) == 0) {
    $conditions = null;
} elseif (count($selection) != 0 && count($conditions) != 0) {
    $conditions = array_merge($conditions, $selection);
}
elseif (count($selection) != 0)
    $conditions=$selection;
//var_dump($conditions);
//var_dump(json_decode($selection,true));
$orderBy = $_POST["orderBy"];
$limit = $_POST["limit"];
// par défaut, on trie par le 2ème attribue de la classe
$orderBy = ($orderBy == "null" || $orderBy == "") ? ($table=="Uos" ? " LENGTH(NumeroUo), NumeroUo " : $nomColonnes[1]) : $orderBy;
$limit = ($limit == "null") ? null : $limit;
$compte = DAO::count($nomColonnes, $table, $conditions,  $orderBy,  null,  true,  false);
$liste = DAO::select($nomColonnes, $table, $conditions,  $orderBy,  $limit,  true,  false);
echo json_encode(["compte"=>$compte,"liste"=>$liste]);
