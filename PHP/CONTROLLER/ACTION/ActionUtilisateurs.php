<?php
$elm = new Utilisateurs($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm->setPasswordUtilisateur(passwordDefault($elm));
		$elm = UtilisateursManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = UtilisateursManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = UtilisateursManager::delete($elm);
		break;
	}
	case "Reinit": {
		$elm = UtilisateursManager::findById($_GET["id"]);
		$elm->setMdpUser(crypte(passwordDefault($elm)));
		UtilisateursManager::update($elm);
		break;
	}
}

header("location:index.php?page=ListeUtilisateurs");