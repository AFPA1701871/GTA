<?php
$elm = new Pointages($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = PointagesManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = PointagesManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = PointagesManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListePointages");