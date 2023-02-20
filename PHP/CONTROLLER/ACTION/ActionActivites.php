<?php
$elm = new Activites($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleActivite());
		$elm->setLibelleActivite($libelle);
		$elm = ActivitesManager::add($elm);
		break;
	}
	case "Modifier": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleActivite());
		$elm->setLibelleActivite($libelle);
		$elm = ActivitesManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ActivitesManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeActivites");