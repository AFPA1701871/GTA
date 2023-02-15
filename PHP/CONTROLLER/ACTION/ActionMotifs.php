<?php
$elm = new Motifs($_POST);

// On désactive le rendu de < et >
$libelle = htmlentities($elm->getLibelleMotif());
$elm->setLibelleMotif($libelle);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = MotifsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = MotifsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = MotifsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeMotifs");