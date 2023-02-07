<?php
$elm = new Activites($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = ActivitesManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = ActivitesManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ActivitesManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeActivites");