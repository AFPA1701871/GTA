<?php
$elm = new Projets($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleProjet());
		$elm->setLibelleProjet($libelle);
		$elm = ProjetsManager::add($elm);
		break;
	}
	case "Modifier": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleProjet());
		$elm->setLibelleProjet($libelle);
		$elm = ProjetsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ProjetsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeProjets");