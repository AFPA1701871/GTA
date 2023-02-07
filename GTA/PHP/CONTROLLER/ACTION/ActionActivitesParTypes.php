<?php
$elm = new ActivitesParTypes($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = ActivitesParTypesManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = ActivitesParTypesManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ActivitesParTypesManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeActivitesParTypes");