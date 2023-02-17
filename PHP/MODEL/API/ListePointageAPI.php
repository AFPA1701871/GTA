<?php
// args = ("table=" + table + "&id=" + id + "&attribut=" + attribut + "&select=" + select);
//var_dump($_POST);
$id =  ($_POST['id'] == null) ? null : (int)$_POST['id'];
$condition = $_POST['condition']=='null' ?  null:json_decode($_POST['condition'],true);
if ($_POST['select']=="true") {
    echo creerSelect($id, $_POST['table'], json_decode($_POST['colonne']), $_POST['attribut'], $condition,implode(',', json_decode($_POST['colonne'])), null);
} else {
    $manag =  $_POST['table'] . 'Manager';
    $idName = "id" . substr($_POST['table'],0,-1);
    $condition[ $idName]= $_POST['id'];
    echo json_encode($manag::getList(json_decode($_POST['colonne']),$condition , null, null, true, false));
}
