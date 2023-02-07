<?php
$elm = new Uos($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = UosManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = UosManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = UosManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeUos");