<?php
$elm = new UOs($_POST);

// On désactive le rendu de < et >
$libelle = htmlentities($elm->getLibelleUO());
$elm->setLibelleUO($libelle);

switch ($_GET['mode']) {
	case "Ajouter": {
			$elm = UOsManager::add($elm);
			break;
		}
	case "Modifier": {
			$elm = UOsManager::update($elm);
			break;
		}
	case "Supprimer": {
			$elm = UOsManager::delete($elm);
			break;
		}
}

header("location:index.php?page=ListeUOs");
