<?php
$elm = new TypePrestations($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = TypePrestationsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = TypePrestationsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = TypePrestationsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeTypePrestations");