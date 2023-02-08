<?php
$elm = new Utilisateurs($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
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
}
