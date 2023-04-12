<?php
$elm = new Utilisateurs($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
			// On désactive le rendu de < et >
			$nom = htmlentities($elm->getNomUtilisateur());
			$elm->setNomUtilisateur($nom);
			$matricule = htmlentities($elm->getMatriculeUtilisateur());
			$elm->setMatriculeUtilisateur($matricule);
			$elm->setPasswordUtilisateur(crypte(passwordDefault($elm)));
			$elm = UtilisateursManager::add($elm);
			if ($elm != 0) {
				//on lui ajoute une preference pour les absences
				PreferencesManager::add(new Preferences(["idPrestation" => 1, "idUtilisateur" => $elm, "idTypePrestation" => 1]));
				// Utilisateur crée, redirection vers son formulaire de modification
				header("location:index.php?page=FormUtilisateurs&mode=Modifier&id=" . $elm);
			} else {
				// Utilisateur non crée, retour au formulaire d'ajout
				header("location:index.php?page=FormUtilisateurs&mode=Ajouter");
			}
			break;
		}
	case "Modifier": {
			// On désactive le rendu de < et >
			$nom = htmlentities($elm->getNomUtilisateur());
			$elm->setNomUtilisateur($nom);
			$matricule = htmlentities($elm->getMatriculeUtilisateur());
			$elm->setMatriculeUtilisateur($matricule);
			$elm = UtilisateursManager::update($elm);
			header("location:index.php?page=ListeUtilisateurs");
			break;
		}
	case "Supprimer": {
			//on lui retire la preference pour les absences
			$prefAbsence = PreferencesManager::getList(null, ["idPrestation" => 1, "idUtilisateur" => $elm->getIdUtilisateur(), "idTypePrestation" => 1])[0];
			PreferencesManager::delete($prefAbsence);
			$reponse = UtilisateursManager::delete($elm);
			if ($reponse == false) {
				// on remet la preference pour les absences
				PreferencesManager::add($prefAbsence);
				$_SESSION['erreur']['message'] = "Impossible de supprimer l'utilisateur, il a déjà un contrat, du pointage ou des favoris";
				$_SESSION['erreur']['redirection'] = "?page=ListeUtilisateurs";
				header("location:index.php?page=Erreur");
			} else  header("location:index.php?page=ListeUtilisateurs");
			break;
		}
	case "Reinit": {
			$elm = UtilisateursManager::findById($_GET["id"]);
			$elm->setPasswordUtilisateur(crypte(passwordDefault($elm)));
			header("location:index.php?page=ListeUtilisateurs");
			UtilisateursManager::update($elm);
			break;
		}
}
