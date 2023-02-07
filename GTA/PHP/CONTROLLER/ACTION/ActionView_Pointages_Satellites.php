<?php
$elm = new View_Pointages_Satellites($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = View_Pointages_SatellitesManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = View_Pointages_SatellitesManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = View_Pointages_SatellitesManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeView_Pointages_Satellites");