<?php
$elm = new Projets($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = ProjetsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = ProjetsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ProjetsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeProjets");