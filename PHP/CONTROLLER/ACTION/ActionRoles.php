<?php
$elm = new Roles($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = RolesManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = RolesManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = RolesManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeRoles");