<?php

$annee = $_POST['AnneeJoursFeries'];
$paques = (new DateTime("$annee-03-21"))->add(new DateInterval("P" . easter_days($annee) . "D"));
$tab = array(
    ["Jour de l'an",$annee . "-01-01"],
    ["Lundi de Paques" , $paques->add(new DateInterval("P1D"))->format("Y-m-d")],
    ["Fete du travail", $annee ."-05-01"],
    ["Fete de la victoire 1945",$annee . "-05-08"],
    ["Fete nationale", $annee ."-07-14"],
    ["Assomption", $annee ."-08-15"],
    ["Jeudi de l'Ascension", $paques->add(new DateInterval("P38D"))->format("Y-m-d")],
    ["Lundi de Pentecote" , $paques->add(new DateInterval("P49D"))->format("Y-m-d")],
    ["Toussaint", $annee ."-11-01"],
    ["Fete de l'Armistice", $annee ."-11-11"],
    ["Noel", $annee ."-12-25"]
);

foreach ($tab as $value) {
    if (FermeturesManager::getList(null, ["dateFemeture" =>  $value[1]]) == null) {
        $ferie = new Fermetures(["dateFermeture" =>  $value[1]]);
        FermeturesManager::add($ferie);
    }
}