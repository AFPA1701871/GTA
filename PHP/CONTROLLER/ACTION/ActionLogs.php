<?php
$elm = new Logs($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = LogsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = LogsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = LogsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeLogs");