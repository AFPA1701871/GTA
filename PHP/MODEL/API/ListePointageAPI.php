<?php
// args = ("table=" + table + "&id=" + id + "&attribut=" + attribut + "&select=" + select);
$id =  ($_POST['id'] == null) ? null : (int)$_POST['id'];
if ($_POST['select']=="true") {
    echo creerSelect($id, $_POST['table'], json_decode($_POST['colonne']), $_POST['attribut'], null,implode(',', json_decode($_POST['colonne'])), null);
} else {
    $manag =  $_POST['table'] . 'Manager';
    $idName = "id" . substr($_POST['table'],0,-1);
    echo json_encode($manag::getList(json_decode($_POST['colonne']), [ $idName=> $_POST['id']], null, null, true, false));
}
