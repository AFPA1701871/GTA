<?php

$elm = new Utilisateurs($_POST);

// On désactive le rendu de < et >
$nom = htmlentities($elm->getNomUtilisateur());
$elm->setNomUtilisateur($nom);
$matricule = htmlentities($elm->getMatriculeUtilisateur());
$elm->setMatriculeUtilisateur($matricule);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm->setPasswordUtilisateur(crypte(passwordDefault($elm)));
		$elm = UtilisateursManager::add($elm);
		header("location:index.php?page=FormUtilisateurs&mode=Modifier&id=" . $elm);
		break;
	}
	case "Modifier": {
		$elm = UtilisateursManager::update($elm);
		header("location:index.php?page=ListeUtilisateurs");
		break;
	}
	case "Supprimer": {
		$elm = UtilisateursManager::delete($elm);
		header("location:index.php?page=ListeUtilisateurs");
		break;
	}
	case "Reinit": {
		$elm = UtilisateursManager::findById($_GET["id"]);
		$elm->setMdpUser(crypte(passwordDefault($elm)));
		UtilisateursManager::update($elm);
		break;
	}
}
