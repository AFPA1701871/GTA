<?php
$elm = new TypePrestations($_POST);

// Remplacement des null par 0 pour les checkboxs
if ($elm->getMotifRequis() == null) {
	$elm->setMotifRequis(0);
}
if ($elm->getUoRequis() == null) {
	$elm->setUoRequis(0);
}
if ($elm->getProjetRequis() == null) {
	$elm->setProjetRequis(0);
}

switch ($_GET['mode']) {
	case "Ajouter": {
		$elm = TypePrestationsManager::add($elm);
		header("location:index.php?page=FormTypePrestations&mode=Modifier&id=" . $elm);
		break;
	}
	case "Modifier": {
		$elm = TypePrestationsManager::update($elm);
		header("location:index.php?page=ListeTypePrestations");
		break;
	}
	case "Supprimer": {
		$elm = TypePrestationsManager::delete($elm);
		header("location:index.php?page=ListeTypePrestations");
		break;
	}
}
