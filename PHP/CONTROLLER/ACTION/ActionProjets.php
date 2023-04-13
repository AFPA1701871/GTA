<?php
$elm = new Projets($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibelleProjet());
			$elm->setLibelleProjet($libelle);
			$elm = ProjetsManager::add($elm);
			header("location:index.php?page=ListeProjets");
			break;
		}
	case "Modifier": {
			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibelleProjet());
			$elm->setLibelleProjet($libelle);
			$elm = ProjetsManager::update($elm);
			header("location:index.php?page=ListeProjets");
			break;
		}
	case "Supprimer": {
			$reponse = ProjetsManager::delete($elm);
			if ($reponse == false) {
				$_SESSION['erreur']['message'] = "Impossible de supprimer le projet, il est déjà utilisée";
				$_SESSION['erreur']['redirection'] = "?page=ListeProjets";
				$_SESSION['erreur']['detail'] = "<br>";
				$pointages = View_PointagesManager::getList(['NomUtilisateur','Periode'], ["idProjet" => $elm->getIdProjet()]);
				foreach ($pointages as  $pointage) {
					$_SESSION['erreur']['detail'] .= "pour le pointage de  : " . $pointage->getNomUtilisateur() . " pour la période  " . $pointage->getPeriode() . "<br>";
				}
				$_SESSION['erreur']['detail'] .= "<br>";
				$preferences = PreferencesManager::getList(null, ["idProjet" => $elm->getIdProjet()]);
				foreach ($preferences as  $preference) {
					$_SESSION['erreur']['detail'] .= "pour la preference de  : " . UtilisateursManager::findById($preference->getIdUtilisateur())->getNomUtilisateur() . "<br>";
				}

				header("location:index.php?page=Erreur");
			} else {
				header("location:index.php?page=ListeProjets");
			}
			break;
		}
}
