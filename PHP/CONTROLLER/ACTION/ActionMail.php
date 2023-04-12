<?php

// Déclaration des constantes qui seront utilisées à plusieurs reprises et à plusieurs endroits
const SUJET = "GTA - Relance pour le mois de ";
const FROM = "pointage@afpadunkerque.fr";
const FINCORPMAIL = '<div style="padding-bottom: 1rem;">Pour accéder à GTA, <a href="gta.afpadunkerque.fr/">cliquez sur ce lien</a>.</div><div style="padding-bottom: 1rem;">Cordialement</div><div style="font-style: italic">Contactez <a href="mailto:sylvie.hannequin@afpa.fr?subject=GTA">Sylvie</a> ou <a href="mailto:fanny.fardel@afpa.fr?subject=GTA">Fanny</a> en cas de problème.</div>';
const HEADER='From: ' . FROM . PHP_EOL.'MIME-Version: 1.0' . PHP_EOL.'Content-Type: text/html; charset=UTF-8' . PHP_EOL.'Content-Transfer-Encoding: base64;';
const DEBUTMAIL = '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
$mailControle = "";
EnvoiMail();

/**
 * Envois d'un mail de relance à un agent n'ayant pas commencé/finit son pointage pour une période donnée
 *
 * @param Utilisateurs $agent Utilisateur concerné par ce mail
 * @param string $periode Période ("AAAA-MM") pour laquelle le pointage de l'utilisateur est en défaut
 * @param string $etat ("Vide" ou "Incomplet") indiquant quel est le problème avec le pointage de l'utilisateur
 * @return void
 */
function envoiMailPointageAgent($agent, $periode, $etat)
{
	global $mailControle;
	$sujet = SUJET . tabMoisAnnee()[$periode];
	//$sujet = "GTA - Relance pour la saisie de votre pointage pour " . tabMoisAnnee()[$periode];
	// Corps du texte
	$message = DEBUTMAIL.'<title>Relance pour le pointage GTA du mois de ' . tabMoisAnnee()[$periode] . '</title></head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
			<div style="padding-bottom: 1rem;">Bonjour ' . $agent->getNomUtilisateur() . ',</div>
			<div style="padding-bottom: 1rem;">La saisie de votre pointage GTA pour le mois de ' . tabMoisAnnee()[$periode];
	switch ($etat) {
		case 'Vide':
			$message .= ' n\'est pas terminée.';
			break;
		case 'Incomplet':
			$message .= ' n\'a pas encore été réalisée.';
			break;
		default:
			break;
	}

	$message .= ' Nous vous invitons à le faire.</div>';
	$message .= FINCORPMAIL;
	$message .= '</body>
	</html>';

	// Envoi du mail
	//echo $agent->getMailUtilisateur() . "<br>\n";
	//mail("martine.poix@afpa.fr, florent.delaliaux@gmail.com", $sujet, $message, HEADER);
	//echo  $message;
	$mailControle .= $message;
	// return mail($agent->getMailUtilisateur(),  $sujet, $message, HEADER);
}

/**
 * Envois d'un mail de relance à un Manager n'ayant pas commencé/finit son pointage pour une période donnée,
 * dont au moins l'un des collaborateur et lui-même en défaut et/ou n'ayant pas validé tous les pointages de
 * ses collaborateurs
 *
 * @param Utilisateurs $manager Manager concerné par ce mail
 * @param string $periode Période ("AAAA-MM") concernée par ce mail
 * @param string $etat ("Vide", "Incomplet", "Complet") indiquant quel est l'état du pointage du manager
 * @param array $listePointagesDefauts Tableau à 2 dimensions [X][Y] contenant les noms des collaborateurs [Y] n'ayant pas commencé [X=0] ou pas terminé [X=1] leur pointage pour cette période
 * @param array $listeValidationDefauts Tableau contenant le nom des collaborateurs dont les pointages attendes la validation du manager
 * @return void
 */
function envoiMailManager($manager, $periode, $etat, $listePointagesDefauts = null, $listeValidationDefauts = null)
{
	global $mailControle;
	//On trie sur l'état du pointage
	arsort($listePointagesDefauts);
	/////////////////////////////////
	//Simplification des condition
	/////////////////////////////////
	// Tous ses collaborateurs ne sont pas validé
	$testValidation = $listeValidationDefauts != null && count($listeValidationDefauts) != 0;

	$nom = $manager->getNomUtilisateur();

	$sujet = SUJET . tabMoisAnnee()[$periode];

	// Corps du texte
	$message = DEBUTMAIL.'
			<title>Relance pour le traitement des pointages vous concernant pour le mois de ' . tabMoisAnnee()[$periode] . '</title>
		</head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
			<div style="padding-bottom: 1rem;">Bonjour ' . $manager->getNomUtilisateur() . ',</div>';

	// Si le manager est lui-même en défaut pour son propre pointage
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

	// Si le manager n'a pas encore validé les pointages de certains collaborateurs
	if ($testValidation) {
		$message .= '<div>' . (($etat != "Complet") ? 'De plus, v' : 'V') . 'ous n\'avez pas encore validé les pointages GTA, pour ' . (($etat != "Complet") ? 'cette même période' : 'le mois de ' . tabMoisAnnee()[$periode]) . ', des collaborateurs suivants:</div><ul>';
		foreach ($listeValidationDefauts as  $CollabNonValid) {
			$message .= '<li>' . $CollabNonValid . '</li>';
		}
		$message .= '</ul>';
	}

	$long = count($listePointagesDefauts); //nb de defaut
	$keys = array_keys($listePointagesDefauts); // nom des agents sous ce manager avec defaut
	// Si ses collaborateurs sont en défaut
	if ($long > 0) {
		$message .= '<div>Nous vous informons ' . (($etat != null || $listeValidationDefauts != null) ? 'aussi ' : '') . 'que ces collaborateurs sont en défaut:</div><ul>';
		// Des collaborateur n'ont même pas commencé leur pointage
		$i = 0;
		// d'abors les pointages vide puis incomplet
		if ($listePointagesDefauts[$keys[0]] == "Vide") {
			$message .= '<li>N\'ont pas encore commencé à remplir leur pointage GTA:</li><ul>';

			while ($i < $long && $listePointagesDefauts[$keys[$i]] == "Vide") {
				if ($keys[$i] != $nom) {
					$message .= '<li>' . $keys[$i] . '</li>';
				}
				$i++;
			}
			$message .= '</ul>';
		}
		// Des collaborateur n'ont pas fini leur pointage
		if ($i < $long && $listePointagesDefauts[$keys[$i]] == "Incomplet") {
			$message .= '<li>N\'ont pas encore terminé de remplir leur pointage GTA:</li><ul>';
			while ($i < $long) {
				if ($keys[$i] != $nom) {
					$message .= '<li>' . $keys[$i] . '</li>';
				}
				$i++;
			}
			$message .= '</ul>';
		}
		$message .= '</ul>';
	}
	$message .= '<div style="padding-bottom: 1rem;">Nous vous invitons à traiter ces défauts dans les meilleurs délais.</div>';
	$message .= FINCORPMAIL;
	$message .= '
		</body>
	</html>';

	// Envoi du mail
	//return $message;
	//mail("martine.poix@afpa.fr, florent.delaliaux@gmail.com", $sujet, $message, HEADER);
	echo  $message;
	$mailControle .= $message;
	//return mail($manager->getMailUtilisateur(), $sujet, $message, HEADER);
}

/**
 * Envois d'un mail de relance à une assistante n'ayant pas commencé/finit son pointage pour une période donnée,
 * et/ou lui indiquant la liste des pointages restant à reportés sur SIRH, organisé par managers par soucis de 
 * clareté
 *
 * @param Utilisateurs $assistante Assistante concernée par ce mail
 * @param string $periode Période ("AAAA-MM") concernée par ce mail
 * @param string $etat Etat du pointage de l'assistante
 * @param array $listeReportsAFaire Tableau à 2 dimensions [X][Y] contenant le nom des utilisateurs [Y] dont le pointage reste à reporter sur SIRH organisés par l'identifiant de leur manager [X]
 * @param array $listeManagers Tableau permettant d'associer l'identifiant des managers actif (en index) avec leur nom (en valeur)
 * @return void
 */
function envoiMailAssistantes($assistante, $periode, $etat, $listeReportsAFaire, $listeManagers)
{
	global $mailControle;
	$sujet = SUJET . tabMoisAnnee()[$periode];
	//$sujet = "GTA - Relance pour le report du pointage dans le système RH";

	// Corps du texte
	$message = DEBUTMAIL.'
			<title>Relance pour la validation du pointage dans le système RH du mois de ' . tabMoisAnnee()[$periode] . '</title>
		</head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
			<div style="padding-bottom: 1rem;">Bonjour ' . $assistante->getNomUtilisateur() . ',</div>';
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
	$message .= '<div>' . ($etat != "Complet" ? 'De plus, l' : 'L') . 'e report du pointage GTA pour ' . ($etat != "Complet" ? 'cette même période' : 'le mois de ' . tabMoisAnnee()[$periode]) . ' n\'a pas encore été réalisée pour les personnes suivantes.</div>
			<ul>';
	foreach ($listeReportsAFaire as $idManager => $listeReportAttente) {
		$message .= '<li>Pour ' . $listeManagers[$idManager] . '</li><ul>';
		foreach ($listeReportAttente as $collaborateur) {
			$message .= '<li>' . $collaborateur . '</li>';
		}
		$message .= '</ul>';
	}

	$message .= '</ul><div>Nous vous invitons à le faire.</div>
				<div style="padding-bottom: 1rem;">Pour accéder à GTA, <a href="gta.afpadunkerque.fr/">cliquez sur ce lien</a>.</div>
				<div style="padding-bottom: 1rem;">Cordialement</div>
				<div style="font-style: italic;">Contactez <a href="mailto:martine.poix@afpa.fr?subject=GTA">Martine</a> en cas de problème.</div>
		</body>
	</html>';

	// Envoi du mail
	//mail("martine.poix@afpa.fr, florent.delaliaux@gmail.com", $sujet, $message, HEADER);
	echo $message;
	$mailControle .= $message;
	//return mail($assistante->getMailUtilisateur(), $sujet, $message, HEADER);
}

/**
 * Envois d'un mail de contrôle nous permettant de suivre l'état des pointages
 *
 * @param string $periode Période ("AAAA-MM") concernée par ce mail
 * @param array $listePointageAgents Tableau à 3 dimensions [X][Y][Z] tel que X est l'ID d'un manager, Y vaut 0 (pour la liste des pointages vides) ou 1 (pour la liste des pointages incomplets) et Z est la liste des noms des utilisateurs correspondants (i.e.: [5][1][0] est le premier utilisateur parmis ceux ayant commencé, mais pas terminé, leurs pointages et supervisé par le manager dont l'ID est 5)
 * @param array $listeValidationAFaire Tableau à 2 dimensions [X][Y] dans lequel X correspond à l'ID d'un manager et Y à la liste des collaborateurs de ce manager qu'il n'a pas encore validé
 * @param array $listeReportAFaire Tableau à 2 dimensions [X][Y] dans lequel X correspond à l'ID d'un manager et Y à la liste des collaborateurs de ce manager qui n'ont pas encore été reportés sur SIRH
 * @param array $listeManagers Tableau permettant d'associer l'identifiant des managers actif (en index) avec leur nom (en valeur)
 * @return void
 */
function envoiMailControle($periode)
{
	global $mailControle;
	$sujet = "Mail de contrôle GTA pour le mois de " . tabMoisAnnee()[$periode];
	// Corps du texte
	$message = DEBUTMAIL.'
			<title>Mail de contrôle GTA pour le mois de ' . tabMoisAnnee()[$periode] . '</title>
		</head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
		<div style="padding-bottom: 1rem;">Bonjour,</div>';
	$message .= '<div style="padding-bottom: 1rem;">Voici où en sont les pointages à ce jour:</div>';
	$message .= $mailControle . '
		</body>
	</html>';

	// Envoi du mail
	echo $message;
	//return mail("martine.poix@afpa.fr, florent.delaliaux@gmail.com", $sujet, $message, HEADER);
}

/**
 * Envoi de mail à tous les agents actifs dans le mois en date du 20 pour leur rappeler de commencer leur pointage
 *
 * @param string $periode Mois en cours (AAAA-MM)
 * @param Utilisateurs $agent Agent
 * @return void
 */
function envoiMailMiMois($periode, $agent){
	$sujet = "Mail de rappel GTA pour le mois de " . tabMoisAnnee()[$periode];
	// Corps du texte
	$message = DEBUTMAIL.'
			<title>Mail de rappel GTA pour le mois de ' . tabMoisAnnee()[$periode] . '</title>
		</head>
		<body style="font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;">
		<div style="padding-bottom: 1rem;">Bonjour '.$agent->getNomUtilisateur().',</div>';
	$message .= '<div style="padding-bottom: 1rem;">Nous arrivons en fin de mois, pensez à votre pointage.</div>';
	$message .= FINCORPMAIL;
	$message .= '	
		</body>
	</html>';

	// Envoi du mail
	return mail($agent->getMailUtilisateur(), $sujet, $message, HEADER);
}

/**
 * Gère l'envois des mails de rappels aux utilisateurs
 *
 * @return void
 */
function EnvoiMail()
{
	$dateJour = new DateTime();
	$jourMois = $dateJour->format("d");
	if ($jourMois > Parametres::getJourRelanceDebut() || $jourMois < Parametres::getJourRelanceFin() ) {

		// Repère durée de travail
		$tempsDebut=microtime(true);
		
		
		if ($jourMois <= Parametres::getJourRelanceDebut())
			date_sub($dateJour, DateInterval::createFromDateString('1 month'));
		$periode = $dateJour->format("Y-m");
		/*  Pointage  */
		// Récupération de la liste des agents actifs durant la période
		$agents = View_UtilisateursManager::getListActifPeriode($periode);
		// Récupération de la liste des managers actifs durant la période
		$managers = View_UtilisateursManager::getListActifPeriode($periode, null, 2);
		// Récupération de la liste des assistantes actives durant la période
		$assistantes = View_UtilisateursManager::getListActifPeriode($periode, null, 3);

		// Récupération de la liste des ID des utilisateurs actif en date du jour
		$contractsActif=View_UtilisateursManager::getList(["idUtilisateur"], ["Actif" => 1], null, null, true, false);

		$listeManagers = []; //Mémorisation association idManager<=>Nom pour réutilisation pour les assistantes
		//Pour chaque agent
		foreach ($agents as $key => $agent) {
			$idAgent = $agent->getIdUtilisateur();

			if ($agent->getIdRole() == 2) {
				$listeManagers[$idAgent] = $agent->getNomUtilisateur(); //Mémorisation association idManager<=>Nom pour réutilisation pour les assistantes
			}
			// Récupération du pointage pour la période
			$pointage = View_Pointages_PeriodeManager::NombrePointages($idAgent, $periode, null, "Utilisateur", "Jours");

			/////////////////////////////////////////////
			// Si pointage vide ou si pointage incomplet
			/////////////////////////////////////////////
			if ($pointage == null || $pointage < NbJourParPeriode($periode)) {

				$etat = ($pointage == null) ? "Vide" : "Incomplet";
				$listePointageAgents[$agent->getIdManager()][$agent->getNomUtilisateur()] = $etat;

				// Envoi de mail si niveau agent, actif durant la période et toujours actif aujourd'hui
				if ($agent->getIdRole() == 1 && array_search($agent->getIdUtilisateur(), array_column($contractsActif,"idUtilisateur"))) {
					envoiMailPointageAgent($agent, $periode, $etat);
				}
			}

			/////////////////////////////////////////////
			// Validations
			/////////////////////////////////////////////

			// Récupération du pointage validé pour la période
			$valide = View_Pointages_PeriodeManager::NombrePointages($idAgent, $periode, "valide", "Utilisateur");
			if ($pointage == NbJourParPeriode($periode) && $valide != $pointage) {
				$listeValidationAFaire[$agent->getIdManager()][] = $agent->getNomUtilisateur();
			}

			/////////////////////////////////////////////
			// Reports
			/////////////////////////////////////////////

			// Récupération du pointage reporté pour la période
			$report = View_Pointages_PeriodeManager::NombrePointages($idAgent, $periode, "reporte", "Utilisateur");
			// Si pointage vide ou si pointage incomplet
			if ($pointage == NbJourParPeriode($periode) && $report != $pointage) {
				$listeReportAFaire[$agent->getIdManager()][] = $agent->getNomUtilisateur();
			}
		}

		///////////////////////////////////////
		// Gestion de l'envois des mails pour les managers
		///////////////////////////////////////
		foreach ($managers as $manager) {
			$idUser = $manager->getIdUtilisateur();
			$nomUser = $manager->getNomUtilisateur();

			$etatManager = array_search_2dim($nomUser, "Vide", $listePointageAgents) ? "Vide" : (array_search_2dim($nomUser, "Incomplet", $listePointageAgents) ? "Incomplet" : "Complet");
			
			// Certains des collaborateurs de ce managers sont en défaut
			$listPointDef = (isset($listePointageAgents[$idUser])) ? $listePointageAgents[$idUser] : null;
			// Ce manager n'a pas validé tous ses collaborateurs
			$listValidDef = (isset($listeValidationAFaire[$idUser])) ? $listeValidationAFaire[$idUser] : null;
			
			if ($etatManager != "Complet" || $listPointDef != null || $listValidDef != null) {
				envoiMailManager($manager, $periode, $etatManager, $listPointDef, $listValidDef);
			}
		}

		///////////////////////////////////////
		// Gestion de l'envois des mails pour les assistantes
		///////////////////////////////////////

		foreach ($assistantes as $assistante) {
			$etatAssistante = isset($listePointageAgents[$assistante->getIdManager()]) && in_array($nomUser, $listePointageAgents[$assistante->getIdManager()]) ? array_shift(array_keys($listePointageAgents[$assistante->getIdManager()])) : "Complet";
			// Envois du mail s'il reste des pointages à reporter ou si elle est elle-même en défaut
			if (isset($listeReportAFaire) || $etatAssistante != "Complet") {
				envoiMailAssistantes($assistante, $periode, $etatAssistante, $listeReportAFaire, $listeManagers);
			}
		}
		echo envoiMailControle($periode);

		// Repère durée de travail
		$tempsFin=microtime(true);
		echo "<br /><br /><br />Travail fait en ".($tempsFin-$tempsDebut)." secondes.";
	}
}