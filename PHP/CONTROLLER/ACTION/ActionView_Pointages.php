<?php
$elm = new View_Pointages($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = View_PointagesManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = View_PointagesManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = View_PointagesManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeView_Pointages");