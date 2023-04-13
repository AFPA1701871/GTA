<?php

// Déclaration des constantes qui seront utilisées à plusieurs reprises et à plusieurs endroits
const SUJET = ["Relance" => "Mail de relance concernant le GTA pour le mois de PERIODE", "Info" => "Mail d'information concernant le GTA pour le mois de PERIODE", "Controle" => "Mail de contrôle GTA pour le mois de PERIODE"];
const FROM = "pointage@afpadunkerque.fr";
// Personnes à contacter en fonction du rôle
const CONTACT = ["Assistantes" => '<a href="mailto:martine.poix@afpa.fr?subject=GTA">Martine</a>', "Autres" => '<a href="mailto:sylvie.hannequin@afpa.fr?subject=GTA">Sylvie</a> ou <a href="mailto:fanny.fardel@afpa.fr?subject=GTA">Fanny</a>'];
// Partie header du mail
const HEADER = 'From: ' . FROM . PHP_EOL . 'MIME-Version: 1.0' . PHP_EOL . 'Content-Type: text/html; charset=UTF-8' . PHP_EOL . 'Content-Transfer-Encoding: base64;';
// Partie correspondant au début du mail, commune à tous les mails
const DEBUTMAIL = '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>TITRE</title></head><body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;"><div style="padding-bottom: 1rem;">Bonjour AGENT,</div>';
// Tableau contenant le message à afficher dans le mail en fonction de l'état du GTA d'un agent
const RAPPELALORDRE = ["Vide" => '<div style="padding-bottom: 1rem;">Vous ne semblez pas encore avoir commencé votre pointage GTA pour le mois de PERIODE.</div>', "Incomplet" => '<div style="padding-bottom: 1rem;">Vous ne semblez pas encore avoir fini de remplir votre pointage GTA pour le mois de PERIODE.</div>', "Complet" => ""];
// Partie correspondant à la fin du mail, commune à tous les mails
const FINCORPMAIL = '<div style="padding-bottom: 1rem;">Pour accéder à GTA, <a href="gta.afpadunkerque.fr/">cliquez sur ce lien</a>.</div><div style="padding-bottom: 1rem;">Cordialement</div><div style="font-style: italic">Contactez CONTACTER en cas de problème.</div></body></html>';

$mailControle = "";
PrepaMail();

/**
 * Envois d'un mail de relance à un agent si présence d'un défaut sur son GTA (personnel pour tous, collaborateur et validation pour managers et report SIRH pour les assistantes)
 *
 * @param [type] $agent Objet contenant les informations sur le destinataire du mail
 * @param string $periode Période ("AAAA-MM") concernée par ce mail
 * @param string $objectif Objectif du mail ("Relance" ou "Info")
 * @return void
 */
function EnvoiMail($agent, $periode, $objectif = "Relance")
{
	global $mailControle;
	$etat = $agent->getEtatPointage();
	$listeAValider = $agent->getListeAValider();
	$listeARelancer = $agent->getListeARelancer();
	$listeAReporter = $agent->getListeAReporter();

	// Détermine si un mail doit, ou non, être envoyé à l'agent en question
	if ($etat != "Complet" || $listeARelancer != null || $listeAValider != null || $listeAReporter != null) {
		$sujet = str_replace("PERIODE", tabMoisAnnee()[$periode], SUJET[$objectif]);

		// Corps du texte
		$rplcDebMail = ["TITRE" => $sujet, "PERIODE" => tabMoisAnnee()[$periode], "AGENT" => $agent->getNomUtilisateur()];
		$message = strtr(DEBUTMAIL, $rplcDebMail);

		// Défaut pour son propre pointage
		$message .= str_replace("PERIODE", tabMoisAnnee()[$periode], RAPPELALORDRE[$etat]);

		// A Valider
		// Si le manager n'a pas encore validé les pointages de certains collaborateurs

		if ($listeAValider != null) {
			// on trie pour avoir les agents dans l'ordre alphabétique
			asort($listeAValider);
			// Message d'introduction de la liste des pointages non-validé, pour les managers
			$message .= '<div>' . (($etat != "Complet") ? 'De plus, v' : 'V') . 'ous n\'avez pas encore validé les pointages GTA, pour ' . (($etat != "Complet") ? 'cette même période' : 'le mois de ' . tabMoisAnnee()[$periode]) . ', des collaborateurs suivants:</div><ul>';
			foreach ($listeAValider as  $CollabNonValid) {
				// Affichage des noms sous forme d'une liste non-ordonnée
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
			// Partie Assistantes
			$long = count($listeAReporter);
			$keys = array_keys($listeAReporter); // etat + nom des agents sous ce manager avec defaut
			$message .= '<div>' . ($etat != "Complet" ? 'De plus, l' : 'L') . 'e report du pointage GTA pour ' . ($etat != "Complet" ? 'cette même période' : 'le mois de ' . tabMoisAnnee()[$periode]) . ' n\'a pas encore été réalisée pour les personnes suivantes.</div>
			<ul style="padding-bottom: 1rem;">';
			do {
				$manager = $listeAReporter[$keys[$i]]->getNomManager();
				$message .= '<li>Pour ' . $manager . '</li><ul>';
				do {
					$message .= '<li>' . $listeAReporter[$keys[$i]]->getNomUtilisateur() . '</li>';
					$i++;
				} while ($i < $long && $listeAReporter[$keys[$i]]->getNomManager() == $manager);
				$message .= '</ul>';
			} while ($i < $long);
			$message .= '</ul><div style="padding-bottom: 1rem;">Nous vous invitons à traiter ces défauts dans les meilleurs délais.</div>';
		}

		// Ajoute la fin du mail en indiquant un contact différent selon le rôle
		// Martine Poix pour les assistantes, les assistantes pour les autres
		$role = ($agent->getIdRole() == 3) ? "Assistantes" : "Autres";
		$message .= str_replace("CONTACTER", CONTACT[$role], FINCORPMAIL);

		//Ajout d'une copie du mail d'information dans le mail de controle
		$mailControle .= "<li style='margin-bottom:1rem;'>" . $message . "</li>";
		// Envoi du mail
		//return mail($agent->getMailUtilisateur(), $sujet, $message, HEADER);
	}
}

/**
 * Envois d'un mail de contrôle nous permettant de suivre l'état des pointages
 *
 * @param string $periode Période ("AAAA-MM") concernée par ce mail
 * @return void
 */
function EnvoiMailControle($periode)
{
	global $mailControle;
	$sujet = str_replace("PERIODE", tabMoisAnnee()[$periode], SUJET["Controle"]);
	// Corps du texte
	$rplcDebMail = ["TITRE" => $sujet, "PERIODE" => tabMoisAnnee()[$periode], " AGENT" => ""];
	$message = strtr(DEBUTMAIL, $rplcDebMail);
	$message .= '<div style="padding-bottom: 1rem;">Voici où en sont les pointages à ce jour:</div><ul style="">';
	$message .= $mailControle . '
		</ul></body>
	</html>';

	// Envoi du mail
	echo $message;
	//return mail("martine.poix@afpa.fr, florent.delaliaux@gmail.com", $sujet, $message, HEADER);
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

	if ($jourMois > Parametres::getJourRelanceDebut() || $jourMois < Parametres::getJourRelanceFin() || $jourMois == Parametres::getJourInformation()) {
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

			if ($jourMois == Parametres::getJourInformation()) {
				EnvoiMail($agent, $periode, "Info");
			} else {
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
}
