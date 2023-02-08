<?php
$elm = new Fermetures($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = FermeturesManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = FermeturesManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = FermeturesManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeFermetures");