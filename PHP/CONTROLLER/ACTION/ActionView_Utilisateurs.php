<?php
$elm = new View_Utilisateurs($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
			$elm = View_UtilisateursManager::add($elm);
			break;
		}
	case "Modifier": {
			$elm = View_UtilisateursManager::update($elm);
			break;
		}
	case "Supprimer": {
			$elm = View_UtilisateursManager::delete($elm);
			break;
		}
}

header("location:index.php?page=ListeView_Utilisateurs");
