<?php
$elm = new Centres($_POST);

// On désactive le rendu de < et >
$nom = htmlentities($elm->getNomCentre());
$elm->setNomCentre($nom);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = CentresManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = CentresManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = CentresManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeCentres");