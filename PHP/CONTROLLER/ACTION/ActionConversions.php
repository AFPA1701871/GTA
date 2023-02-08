<?php
$elm = new Conversions($_POST);

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