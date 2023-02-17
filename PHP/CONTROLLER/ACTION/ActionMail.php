<?php

function envoiMailRelance($adresseMail)
{
	$sujet = "GTA - Relance pour la saisie du pointage";
	$from = "pointage@afpadunkerque.fr";

	// Corps du texte
	$message ='<!DOCTYPE html>
	<html lang="fr">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Relance pour le pointage GTA du mois en cours</title>
		</head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
			<table>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Bonjour,</td>
				</tr>
				<tr>
					<td>
						La saisie de votre pointage GTA est incomplète ou n\'a pas encore été réalisée pour le mois en cours. Nous vous
						invitons à le faire rapidement.
					</td>
				</tr>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Pour saisir votre pointage, <a href="index.php?page=Default">cliquez sur ce lien</a>.</td>
				</tr>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Cordialement</td>
				</tr>
				<tr>
					<td class="italic" style="font-style: italic;padding-top: 0.5rem;">Cet e-mail a été généré automatiquement, merci de ne pas y répondre.</td>
				</tr>
			</table>
		</body>
	</html>';

	// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
	$headers = 'From: ' . $from . PHP_EOL; 
	$headers .= 'MIME-Version: 1.0' . PHP_EOL;
	$headers .= "Content-Type: text/html; charset=UTF-8" . PHP_EOL;
	$headers .= "Content-Transfer-Encoding: base64;";

	// Envoi du mail
	return mail($adresseMail, $sujet, $message, $headers);
}

envoiMailRelance("GTA@example.gr");
