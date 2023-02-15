<?php
$elm = new View_Prestations($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = View_PrestationsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = View_PrestationsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = View_PrestationsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=Liste_View_Prestations");