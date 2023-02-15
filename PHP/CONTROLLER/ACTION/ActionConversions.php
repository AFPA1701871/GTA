<?php
$elm = new Conversions($_POST);

// On désactive le rendu de < et >
$quotient = htmlentities($elm->getCoeffConversion());
$elm->setCoeffConversion($quotient);

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = ConversionsManager::add($elm);
		break;
	}
	case "Modifier": {
		$elm = ConversionsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ConversionsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeConversions");