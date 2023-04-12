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
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleTypePrestation());
		$elm->setLibelleTypePrestation($libelle);
		$elm = TypePrestationsManager::add($elm);
		header("location:index.php?page=FormTypePrestations&mode=Modifier&id=" . $elm);
		break;
	}
	case "Modifier": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibelleTypePrestation());
		$elm->setLibelleTypePrestation($libelle);
		$elm = TypePrestationsManager::update($elm);
		header("location:index.php?page=ListeTypePrestations");
		break;
	}
	case "Supprimer": {
		$reponse = TypePrestationsManager::delete($elm);if ($reponse == false) {
			$_SESSION['erreur']['message'] = "Impossible de supprimer le type de prestation, il est déjà utilisée";
			$_SESSION['erreur']['redirection'] = "?page=ListeTypePrestations";
			$_SESSION['erreur']['detail'] ="Enlever les activités associées<br>";
			$pointages = View_PointagesManager::getList(null, ["idTypePrestation" => $elm->getIdTypePrestation()]);
			foreach ($pointages as  $pointage) {
				$_SESSION['erreur']['detail'] .= "pour le pointage de  : ". $pointage->getNomUtilisateur()." en date du " .$pointage->getDatePointage()."<br>";
			}
			$preferences =PreferencesManager::getList(null, ["idTypePrestation" => $elm->getIdTypePrestation()]);
			foreach ($preferences as  $preference) {
				$_SESSION['erreur']['detail'] .= "pour la preference de  : ". UtilisateursManager::findById($preference->getIdUtilisateur())->getNomUtilisateur()."<br>";
			}

			header("location:index.php?page=Erreur");
		} else { header("location:index.php?page=ListeTypePrestations");}
		break;
	}
}
