<?php
$elm = new Prestations($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = PrestationsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = PrestationsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = PrestationsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListePrestations");