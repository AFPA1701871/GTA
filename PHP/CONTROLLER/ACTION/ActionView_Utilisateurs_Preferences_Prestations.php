<?php
$elm = new View_Utilisateurs_Preferences_Prestations($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = View_Utilisateurs_Preferences_PrestationsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = View_Utilisateurs_Preferences_PrestationsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = View_Utilisateurs_Preferences_PrestationsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeView_Utilisateurs_Preferences_Prestations");