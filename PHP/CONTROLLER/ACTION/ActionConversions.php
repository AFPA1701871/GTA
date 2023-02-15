<?php
$elm = new Conversions($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
		// On désactive le rendu de < et >
		$quotient = htmlentities($elm->getCoeffConversion());
		$elm->setCoeffConversion($quotient);
		$elm = ConversionsManager::add($elm);
		break;
	}
	case "Modifier": {
		// On désactive le rendu de < et >
		$quotient = htmlentities($elm->getCoeffConversion());
		$elm->setCoeffConversion($quotient);
		$elm = ConversionsManager::update($elm);
		break;
	}
	case "Supprimer": {
		$elm = ConversionsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListeConversions");