<?php

// Déclaration des constantes qui seront utilisées à plusieurs reprises et à plusieurs endroits
const SUJET = "GTA - Relance pour le mois de ";
const FROM = "pointage@afpadunkerque.fr";
const FINCORPMAIL = '<div style="padding-bottom: 1rem;">Pour accéder à GTA, <a href="gta.afpadunkerque.fr/">cliquez sur ce lien</a>.</div><div style="padding-bottom: 1rem;">Cordialement</div><div style="font-style: italic">Contactez <a href="mailto:sylvie.hannequin@afpa.fr?subject=GTA">Sylvie</a> ou <a href="mailto:fanny.fardel@afpa.fr?subject=GTA">Fanny</a> en cas de problème.</div></body></html>';
const HEADER = 'From: ' . FROM . PHP_EOL . 'MIME-Version: 1.0' . PHP_EOL . 'Content-Type: text/html; charset=UTF-8' . PHP_EOL . 'Content-Transfer-Encoding: base64;';
const DEBUTMAIL = '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';

$mailControle = "";
PrepaMail();

/**
 * Envois d'un mail de relance à un Manager n'ayant pas commencé/finit son pointage pour une période donnée,
 * dont au moins l'un des collaborateur et lui-même en défaut et/ou n'ayant pas validé tous les pointages de
 * ses collaborateurs
 *
 * @param Utilisateurs $manager Manager concerné par ce mail
 * @param string $periode Période ("AAAA-MM") concernée par ce mail
 * @param string $etat ("Vide", "Incomplet", "Complet") indiquant quel est l'état du pointage du manager
 * @param array $listeARelancer Tableau à 2 dimensions [X][Y] contenant les noms des collaborateurs [Y] n'ayant pas commencé [X=0] ou pas terminé [X=1] leur pointage pour cette période
 * @param array $listeValidationDefauts Tableau contenant le nom des collaborateurs dont les pointages attendes la validation du manager
 * @return void
 */
function envoiMail($agent, $periode)
{
	global $mailControle;
	$etat = $agent->getEtatPointage();
	$listeAValider = $agent->getListeAValider();
	$listeARelancer = $agent->getListeARelancer();
	$listeAReporter = $agent->getListeAReporter();

	if ($etat != "Complet" || $listeARelancer != null || $listeAValider != null || $listeAReporter != null) {
		$sujet = SUJET . tabMoisAnnee()[$periode];

		// Corps du texte
		$message = DEBUTMAIL . '<title>Relance pour le pointage GTA du mois de ' . tabMoisAnnee()[$periode] . '</title></head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
			<div style="padding-bottom: 1rem;">Bonjour ' . $agent->getNomUtilisateur() . ',</div>';

		// Défaut pour son propre pointage
		if ($etat != "Complet") {
			$message .= '<div style="padding-bottom: 1rem;">Vous ne semblez pas encore avoir';
			switch ($etat) {
				case 'Vide':
					$message .= ' commencé ';
					break;
				case 'Incomplet':
					$message .= ' finit de remplir ';
					break;
				default:
					break;
			}
			$message .= 'votre pointage GTA pour le mois de ' . tabMoisAnnee()[$periode] . '.</div>';
		}

		// A Valider
		// Si le manager n'a pas encore validé les pointages de certains collaborateurs

		if ($listeAValider != null) {
			// on trie pour avoir les agents dans l'ordre alphabétique
			asort($listeAValider);
			$message .= '<div>' . (($etat != "Complet") ? 'De plus, v' : 'V') . 'ous n\'avez pas encore validé les pointages GTA, pour ' . (($etat != "Complet") ? 'cette même période' : 'le mois de ' . tabMoisAnnee()[$periode]) . ', des collaborateurs suivants:</div><ul>';
			foreach ($listeAValider as  $CollabNonValid) {
				$message .= '<li>' . $CollabNonValid->getNomUtilisateur() . '</li>';
			}
			$message .= '</ul>';
		}

		// A Relancer

		// Si ses collaborateurs sont en défaut
		if ($listeARelancer != null) {
			$long = count($listeARelancer); //nb de defaut
			ksort($listeARelancer);
			$keys = array_keys($listeARelancer); // etat + nom des agents sous ce manager avec defaut
			$message .= '<div>Nous vous informons que ces collaborateurs sont en défaut:</div><ul>';
			$i = 0;
			// d'abords les pointages  incomplet puis vide 
			if (substr($keys[0], 0, 4) == "Inco") {
				$message .= '<li>N\'ont pas encore terminé à remplir leur pointage GTA:</li><ul>';

				while ($i < $long && substr($keys[$i], 0, 4) != "Vide") {
					//on exclu le nom du manager de la liste (déjà signalé avant)
					if ($listeARelancer[$keys[$i]]->getNomUtilisateur() != $agent->getNomUtilisateur()) {
						$message .= '<li>' . $listeARelancer[$keys[$i]]->getNomUtilisateur() . '</li>';
					}
					$i++;
				}
				$message .= '</ul>';
			}
			// Des collaborateur n'ont pas commencé leur pointage
			if ($i < $long) {
				$message .= '<li>N\'ont pas encore commencé de remplir leur pointage GTA:</li><ul>';
				while ($i < $long) {
					if ($listeARelancer[$keys[$i]]->getNomUtilisateur() != $agent->getNomUtilisateur()) {
						$message .= '<li>' . $listeARelancer[$keys[$i]]->getNomUtilisateur() . '</li>';
					}
					$i++;
				}
				$message .= '</ul>';
			}
			$message .= '</ul>';
			$message .= '<div style="padding-bottom: 1rem;">Nous vous invitons à traiter ces défauts dans les meilleurs délais.</div>';
		}

		// A Reporter

		$i = 0;

		if ($listeAReporter != null) {
			$long = count($listeAReporter);
			$keys = array_keys($listeAReporter); // etat + nom des agents sous ce manager avec defaut
			$message .= '<div>' . ($etat != "Complet" ? 'De plus, l' : 'L') . 'e report du pointage GTA pour ' . ($etat != "Complet" ? 'cette même période' : 'le mois de ' . tabMoisAnnee()[$periode]) . ' n\'a pas encore été réalisée pour les personnes suivantes.</div>
			<ul>';
			do {
				$manager = $listeAReporter[$keys[$i]]->getNomManager();
				$message .= '<li>Pour ' . $manager . '</li><ul>';
				do {
					$message .= '<li>' . $listeAReporter[$keys[$i]]->getNomUtilisateur() . '</li>';
					$i++;
				} while ($i<$long && $listeAReporter[$keys[$i]]->getNomManager() == $manager);
				$message .= '</ul>';
			} while ($i < $long);
			$message .= '<div style="padding-bottom: 1rem;">Nous vous invitons à traiter ces défauts dans les meilleurs délais.</div>';
		}
		$message .= FINCORPMAIL;



		// Envoi du mail
		//return $message;
		//mail("martine.poix@afpa.fr, florent.delaliaux@gmail.com", $sujet, $message, Headers);
		echo  $message;
		$mailControle .= $message;
		//return mail($manager->getMailUtilisateur(), $sujet, $message, Headers);
	}
}


/**
 * Envois d'un mail de contrôle nous permettant de suivre l'état des pointages
 *
 * @param string $periode Période ("AAAA-MM") concernée par ce mail
 * @return void
 */
function envoiMailControle($periode)
{
	global $mailControle;
	$sujet = "Mail de contrôle GTA pour le mois de " . tabMoisAnnee()[$periode];
	// Corps du texte
	$message = '<!DOCTYPE html>
	<html lang="fr">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Mail de contrôle GTA pour le mois de ' . tabMoisAnnee()[$periode] . '</title>
		</head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
		<div style="padding-bottom: 1rem;">Bonjour,</div><ul>';
	$message .= '<div style="padding-bottom: 1rem;">Voici où en sont les pointages à ce jour:</div>';
	$message .= $mailControle . '
		</body>
	</html>';
	// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
	$headers = 'From: ' . FROM . PHP_EOL;
	$headers .= 'MIME-Version: 1.0' . PHP_EOL;
	$headers .= "Content-Type: text/html; charset=UTF-8" . PHP_EOL;
	$headers .= "Content-Transfer-Encoding: base64;";

	// Envoi du mail
	echo $message;
	//return mail("martine.poix@afpa.fr, florent.delaliaux@gmail.com", $sujet, $message, $headers);
}

/**
 * Gère l'envois des mails de rappels aux utilisateurs
 *
 * @return void
 */
function PrepaMail()
{
	$dateJour = new DateTime();
	$jourMois = $dateJour->format("d");
	if ($jourMois > Parametres::getJourRelanceDebut() || $jourMois < Parametres::getJourRelanceFin()) {
		if ($jourMois <= Parametres::getJourRelanceDebut())
			date_sub($dateJour, DateInterval::createFromDateString('1 month'));
		$periode = $dateJour->format("Y-m");
		/*  Pointage  */
		// Récupération de la liste des agents actifs durant la période
		$agents = View_UtilisateursManager::getListActifPeriodeMail($periode);
		// Récupération de la liste des assistantes actives durant la période
		$assistantes = View_UtilisateursManager::getListActifPeriode($periode, null, 3);

		//Pour chaque agent
		foreach ($agents as $key => $agent) {
			$idAgent = $agent->getIdUtilisateur();
			// Récupération du pointage pour la période
			$pointage = View_Pointages_PeriodeManager::NombrePointages($idAgent, $periode, null, "Utilisateur", "Jours", "Reparti");
			// mis à jour des états et des listes
			$agent->setEtatPointage($pointage, $periode);
			$agent->setValidePointage($pointage, $periode);
			$agent->setReportePointage($pointage, $periode);
			if ($agent->getEtatPointage() != "Complet")
				$agents[$agent->getIdManager()]->setListeArelancer($agent->getEtatPointage() . $agent->getNomUtilisateur(), $agent);
			else {
				if ($agent->getValidePointage() != "Complet") $agents[$agent->getIdManager()]->setListeAValider('valide' . $agent->getNomUtilisateur(), $agent);
				if ($agent->getReportePointage() != "Complet")
					foreach ($assistantes as $value) {
						$agents[$value->getIdUtilisateur()]->setListeAReporter('reporte' . $agent->getNomUtilisateur(), $agent);
					}
			}
			// envoi des mails
			EnvoiMail($agent, $periode);
		}
	}
	EnvoiMailControle($periode);
}
