<?php
echo 'toto';
const FROM = "pointage@afpadunkerque.fr";
// Partie header du mail
const HEADER = 'From: ' . FROM . PHP_EOL . 'MIME-Version: 1.0' . PHP_EOL . 'Content-Type: text/html; charset=UTF-8' . PHP_EOL ;
// Partie correspondant au début du mail, commune à tous les mails

$sujet = "Mail de test depuis index" ;
// Corps du texte
$message = '<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Depuis index </title>
    </head>
    <body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
    <div style="padding-bottom: 1rem;">Bonjour,</div><ul>';
$message .= '<div style="padding-bottom: 1rem;">Depuis Index</div>
    </body>
</html>';


// Envoi du mail
mail("pointage@afpadunkerque.fr", $sujet, $message, HEADER);
mail("martine.poix@afpa.fr", $sujet, $message, HEADER);
mail("martine.poix@gmail.com", $sujet, $message, HEADER);