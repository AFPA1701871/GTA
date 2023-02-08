<?php
$elm = new Contrats($_POST);
$idUtilisateur = $elm->getIdUtilisateur();

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = ContratsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = ContratsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ContratsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=FormUtilisateurs&mode=Modifier&id=" . $idUtilisateur);