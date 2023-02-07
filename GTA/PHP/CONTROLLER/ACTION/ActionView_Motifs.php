<?php
$elm = new View_Motifs($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = View_MotifsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = View_MotifsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = View_MotifsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeGta_View_Motifs");