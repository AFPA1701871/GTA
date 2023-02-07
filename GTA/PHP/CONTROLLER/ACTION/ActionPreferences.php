<?php
$elm = new Preferences($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = PreferencesManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = PreferencesManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = PreferencesManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListePreferences");