<?php
$elm = new Motifs($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleMotif());
		$elm->setLibelleMotif($libelle);
		$elm = MotifsManager::add($elm);
		break;
	}
	case "Modifier": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleMotif());
		$elm->setLibelleMotif($libelle);
		$elm = MotifsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = MotifsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeMotifs");