<?php
$elm = new Centres($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		// On désactive le rendu de < et >
		$nom = htmlentities($elm->getNomCentre());
		$elm->setNomCentre($nom);
		$elm = CentresManager::add($elm);
		break;
	}
	case "Modifier": {
		// On désactive le rendu de < et >
		$nom = htmlentities($elm->getNomCentre());
		$elm->setNomCentre($nom);
		$elm = CentresManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = CentresManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeCentres");