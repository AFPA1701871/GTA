<?php
EnvoiMail();
/**
 * Permet d'envoyer un mail de relance pour la saisie du pointage
 *
 * @param string $adresseMail Adresse mail du destinataire
 * @return void
 */
function envoiMailRelancePointage($adresseMail, $periode, $etat)
{
	$sujet = "Test Schedule ";
	//$sujet = "GTA - Relance pour la saisie de votre pointage pour ".tabMoisAnnee()[$periode];
	$from = "pointage@afpadunkerque.fr";
// <title>Relance pour le pointage GTA du mois de ' .tabMoisAnnee()[$periode]. '</title>
	// Corps du texte
	$message = '<!DOCTYPE html>
	<html lang="fr">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Information pour le pointage GTA du mois de ' .tabMoisAnnee()[$periode]. '</title>
			
		</head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
			<table>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Bonjour,</td>
				</tr>
				<tr>
					<td>
						Pour effectuer la saisie de votre pointage GTA pour le mois de ' .tabMoisAnnee()[$periode];
	// if ($etat != null)
	// 	$message .= ' n\'est pas terminée. ';
	// else $message .= ' n\'a pas encore été réalisée. ';

	$message .= '. Nous vous invitons à aller sur la nouvelle application .
					</td>
				</tr>
				<tr>	<td class="pad-bttm" style="padding-bottom: 1rem;">Pour saisir votre pointage, <a href="gta.afpadunkerque.fr/">cliquez sur ce lien</a>.</td>';
				$message .= '</tr>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Cordialement</td>
				</tr>
				<tr>
					<td class="italic" style="font-style: italic;padding-top: 0.5rem;">Contactez directement Sylvie ou Fanny en cas de problème.</td>
				</tr>
			</table>
		</body>
	</html>';

	// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
	$headers = 'From: ' . $from . PHP_EOL;
	$headers .= 'MIME-Version: 1.0' . PHP_EOL;
	$headers .= "Content-Type: text/html; charset=UTF-8" . PHP_EOL;
	//$headers .= "Content-Transfer-Encoding: base64;";

	// Envoi du mail
	//echo $adresseMail."<br>\n";
	if ($adresseMail=="martine.poix@afpa.fr")
		return mail($adresseMail ,  $sujet, $message, $headers);
}


/**
 * Permet d'envoyer un mail de relance pour la validation du pointage
 *
 * @param string $adresseMail Adresse mail du destinataire
 * @return void
 */
function envoiMailRelanceValidation($adresseMail, $periode, $liste)
{
	$sujet = "GTA - Relance pour la validation du pointage de vos collaborateurs";
	$from = "pointage@afpadunkerque.fr";

	// Corps du texte
	$message = '<!DOCTYPE html>
	<html lang="fr">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Relance pour la validation du pointage de vos collaborateurs du mois de ' . $periode . '</title>
		</head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
			<table>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Bonjour,</td>
				</tr>
				<tr>
					<td>
						La validation du pointage GTA de vos collaborateurs pour le mois de ' . $periode . ' n\'a pas encore été réalisée pour les personnes suivantes.
						</td>';
	foreach ($liste as  $value) {
		$message .= '<td>' . $value . '</td>';
	}
	$message .= '
						<td>Nous vous invitons à le faire dans les meilleurs délais.
					</td>
				</tr>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Pour valider les pointages, <a href="gta.afpadunkerque.fr/">cliquez sur ce lien</a>.</td>
				</tr>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Cordialement</td>
				</tr>
				<tr>
					<td class="italic" style="font-style: italic;padding-top: 0.5rem;">Contactez Sylvie ou Fanny en cas de problème.</td>
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


/**
 * Permet d'envoyer un mail de relance pour la validation du pointage
 *
 * @param string $adresseMail Adresse mail du destinataire
 * @return void
 */
function envoiMailRelanceReport($adresseMail, $periode, $liste)
{
	$sujet = "GTA - Relance pour le report du pointage dans le système RH";
	$from = "pointage@afpadunkerque.fr";

	// Corps du texte
	$message = '<!DOCTYPE html>
	<html lang="fr">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Relance pour la validation du pointage dans le système RH du mois de ' . $periode . '</title>
		</head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
			<table>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Bonjour,</td>
				</tr>
				<tr>
					<td>
						Le report du pointage GTA pour le mois de ' . $periode . ' n\'a pas encore été réalisée pour les personnes suivantes.
						</td>';
	foreach ($liste as  $value) {
		$message .= '<td>' . $value . '</td>';
	}
	$message .= '
						<td>Nous vous invitons à le faire.
					</td>
				</tr>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Pour valider les pointages, <a href="gta.afpadunkerque.fr/">cliquez sur ce lien</a>.</td>
				</tr>
				<tr>
					<td class="pad-bttm" style="padding-bottom: 1rem;">Cordialement</td>
				</tr>
				<tr>
					<td class="italic" style="font-style: italic;padding-top: 0.5rem;">Contactez Martine en cas de problème, LOL</td>
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


/**
 * Vérifie si le pointage d'un agent n'est pas rempli et le cas échéant envoie un mail de relance à l'agent
 *
 * @return void
 */
function EnvoiMail()
{
	mail("martine.poix@afpa.fr" ,  "test avant autre chose", "test debut EnvoiMail", 'From: pointage@afpadunkerque.fr'. PHP_EOL.'MIME-Version: 1.0' . PHP_EOL."Content-Type: text/html; charset=UTF-8" . PHP_EOL);
	$dateJour = new DateTime();
	$jourMois = $dateJour->format("d");
	if ($jourMois > 25 || $jourMois < 10) {
		if ($jourMois <= 25)
		date_sub($dateJour, DateInterval::createFromDateString('1 month'));
		$periode = $dateJour->format("Y-m");
		//var_dump($periode);
		/*  Pointage  */
		// Récupération de la liste des agents actifs
		$agents = View_UtilisateursManager::getList(['idUtilisateur', 'nomUtilisateur', 'mailUtilisateur'], ["actif" => 1]);
		// Pour chaque agent
		foreach ($agents as $key => $agent) {
			$idAgent = $agent->getIdUtilisateur();

			// Récupération du pointage pour la période
			$pointage = View_Pointages_PeriodeManager::NombrePointages($idAgent, $periode, null, "Utilisateur", "Jours");

			// Si pointage vide ou si pointage incomplet
			if ($pointage == null || $pointage < NbJourParPeriode($periode)) {

				// Envoi de mail
				envoiMailRelancePointage($agent->getMailUtilisateur(), $periode, null);
			}
		}

		/*  Validation  */
		// Récupération de la liste des manager
		// $managers = View_UtilisateursManager::getList(['idUtilisateur', 'nomUtilisateur', 'mailUtilisateur'], ["idRole" => 2]);
		// foreach ($managers as $manager) {

		// 	$listeAgentsConcernes = [];
		// 	// Récupération de la liste des agents actifs de ce manager
		// 	$agents = View_UtilisateursManager::getList(['idUtilisateur', 'nomUtilisateur', 'mailUtilisateur'], ["actif" => 1, "idManager" => $manager->getIdUtilisateur()]);
		// 	// Pour chaque agent
		// 	foreach ($agents as $agent) {
		// 		$idAgent = $agent->getIdUtilisateur();

		// 		// Récupération du pointage validé pour la période
		// 		$pointage = View_Pointages_PeriodeManager::NombrePointages($idAgent, $periode, null, "Utilisateur", "Jours");
		// 		$valide = View_Pointages_PeriodeManager::NombrePointages($idAgent, $periode, "valide", "Utilisateur");
		// 		// Ancienne version
		// 		// $valide = View_Pointages_PeriodeManager::NbValide($idAgent, $periode, "Utilisateur");

		// 		// Si pointage vide ou si pointage incomplet
		// 		if ($pointage == NbJourParPeriode($periode) && $valide != $pointage) {
		// 			$listeAgentsConcernes[] = $agent->getNomUtilisateur();
		// 		}
		// 	}
		// 	// Envoi de mail
		// 	envoiMailRelanceValidation($manager->getMailUtilisateur(), $periode, $listeAgentsConcernes);
		// }

		// /*  Report  */
		// $assistantes = View_UtilisateursManager::getList(['idUtilisateur', 'nomUtilisateur', 'mailUtilisateur'], ["idRole" => 3]);
		// $listeAgentsConcernes = [];
		// // Récupération de la liste des agents actifs de ce manager
		// $agents = View_UtilisateursManager::getList(['idUtilisateur', 'nomUtilisateur', 'mailUtilisateur'], ["actif" => 1, "idManager" => $manager->getIdUtilisateur()]);
		// // Pour chaque agent
		// foreach ($agents as $agent) {
		// 	$idAgent = $agent->getIdUtilisateur();

		// 	// Récupération du pointage validé pour la période
		// 	$pointage = View_Pointages_PeriodeManager::NombrePointages($idAgent, $periode, null, "Utilisateur", "Jours");
		// 	$report = View_Pointages_PeriodeManager::NombrePointages($idAgent, $periode, "reporte", "Utilisateur");
		// 	// Ancienne version
		// 	// $report = View_Pointages_PeriodeManager::NbReporte($idAgent, $periode, "Utilisateur");

		// 	// Si pointage vide ou si pointage incomplet
		// 	if ($pointage == NbJourParPeriode($periode) && $report != $pointage) {
		// 		$listeAgentsConcernes[] = $agent->getNomUtilisateur();
		// 	}
		// }
		// foreach ($assistantes as $assistante) {
		// 	// Envoi de mail
		// 	envoiMailRelanceReport($assistante->getMailUtilisateur(), $periode, $listeAgentsConcernes);
		// }
	}
}