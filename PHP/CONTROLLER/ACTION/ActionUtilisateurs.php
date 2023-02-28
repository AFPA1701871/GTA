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
			//on lui a joute une preference pour les absences
			PreferencesManager::add(new Preferences(["idPrestation"=>1,"idUtilisateur"=>$elm,"idTypePrestation"=>1]));
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
		// ARCHIVAGE A CODER

		// $elm = UtilisateursManager::delete($elm);
		 header("location:index.php?page=ListeUtilisateurs");
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
