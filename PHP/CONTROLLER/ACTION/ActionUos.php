<?php
$elm = new Uos($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleUo());
		$elm->setLibelleUo($libelle);
		$elm = UosManager::add($elm);
		break;
	}
	case "Modifier": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleUo());
		$elm->setLibelleUo($libelle);
		$elm = UosManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = UosManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeUos");
