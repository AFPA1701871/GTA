<?php
$elm = new Associations($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = AssociationsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = AssociationsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = AssociationsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeAssociations");