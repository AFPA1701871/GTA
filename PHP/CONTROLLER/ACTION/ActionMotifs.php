<?php
$elm = new Motifs($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibelleMotif());
			$elm->setLibelleMotif($libelle);
			$elm = MotifsManager::add($elm);
			header("location:index.php?page=ListeMotifs");
			break;
		}
	case "Modifier": {
			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibelleMotif());
			$elm->setLibelleMotif($libelle);
			$elm = MotifsManager::update($elm);
			header("location:index.php?page=ListeMotifs");
			break;
		}
	case "Supprimer": {
			$reponse = MotifsManager::delete($elm);
			if ($reponse == false) {
				$_SESSION['erreur']['message'] = "Impossible de supprimer le motif, il est déjà utilisée";
				$_SESSION['erreur']['redirection'] = "?page=ListeMotifs";
				$_SESSION['erreur']['detail'] = "<br>";

				$pointages = View_PointagesManager::getList(null, ["idMotif" => $elm->getIdMotif()]);
				foreach ($pointages as  $pointage) {
					$_SESSION['erreur']['detail'] .= "pour le pointage de  : " . $pointage->getNomUtilisateur() . " en date du " . $pointage->getDatePointage() . "<br>";
				}
				$_SESSION['erreur']['detail'] .= "<br>";
				$preferences = PreferencesManager::getList(null, ["idMotif" => $elm->getIdMotif()]);
				foreach ($preferences as  $preference) {
					$_SESSION['erreur']['detail'] .= "pour la preference de  : " . UtilisateursManager::findById($preference->getIdUtilisateur())->getNomUtilisateur() . "<br>";
				}

				header("location:index.php?page=Erreur");
			} else {
				header("location:index.php?page=ListeMotifs");
			}
			break;
		}
}
