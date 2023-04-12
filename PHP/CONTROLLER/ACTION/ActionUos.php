<?php
$elm = new Uos($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibelleUo());
			$elm->setLibelleUo($libelle);
			$elm = UosManager::add($elm);
			header("location:index.php?page=ListeUos");
			break;
		}
	case "Modifier": {
			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibelleUo());
			$elm->setLibelleUo($libelle);
			$elm = UosManager::update($elm);
			header("location:index.php?page=ListeUos");
			break;
		}
	case "Supprimer": {
			$reponse = UosManager::delete($elm);
			if ($reponse == false) {
				$_SESSION['erreur']['message'] = "Impossible de supprimer l'UO, elle est déjà utilisée";
				$_SESSION['erreur']['redirection'] = "?page=ListeUos";
				$_SESSION['erreur']['detail'] ="";
				$users = UtilisateursManager::getList(null, ["idUo" => $elm->getIdUo()]);
				foreach ($users as  $user) {
					$_SESSION['erreur']['detail'] .= "pour l'utilisateur : ". $user->getNomUtilisateur()."<br>";
				}
				$pointages = View_PointagesManager::getList(null, ["idUo_Pointage" => $elm->getIdUo()]);
				foreach ($pointages as  $pointage) {
					$_SESSION['erreur']['detail'] .= "pour le pointage de  : ". $pointage->getNomUtilisateur()." en date du " .$pointage->getDatePointage()."<br>";
				}
				$preferences =PreferencesManager::getList(null, ["idUo" => $elm->getIdUo()]);
				foreach ($preferences as  $preference) {
					$_SESSION['erreur']['detail'] .= "pour la preference de  : ". UtilisateursManager::findById($preference->getIdUtilisateur())->getNomUtilisateur()."<br>";
				}

				header("location:index.php?page=Erreur");
			} else { header("location:index.php?page=ListeUos");
			}
			break;
		}
}
