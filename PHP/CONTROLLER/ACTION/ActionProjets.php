<?php
$elm = new Projets($_POST);

// On désactive le rendu de < et >
$libelle = htmlentities($elm->getLibelleProjet());
$elm->setLibelleProjet($libelle);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = ProjetsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = ProjetsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ProjetsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeProjets");