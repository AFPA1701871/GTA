<?php
$elm = new Contrats($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = ContratsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = ContratsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ContratsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeContrats");