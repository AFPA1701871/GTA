<?php
$elm = new Activites($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibelleActivite());
			$elm->setLibelleActivite($libelle);
			$elm = ActivitesManager::add($elm);
			header("location:index.php?page=ListeActivites");
			break;
		}
	case "Modifier": {
			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibelleActivite());
			$elm->setLibelleActivite($libelle);
			$elm = ActivitesManager::update($elm);
			header("location:index.php?page=ListeActivites");
			break;
		}
	case "Supprimer": {
			$reponse = ActivitesManager::delete($elm);
			if ($reponse == false) {
				$_SESSION['erreur']['message'] = "Impossible de supprimer l'activité, elle est déjà utilisée";
				$_SESSION['erreur']['redirection'] = "?page=ListeUos";
				$_SESSION['erreur']['detail'] = "<br>";

				$prestas = View_TypePrestationsManager::getList(["LibelleTypePrestation"], ["idActivite" => $elm->getIdActivite()]);
				foreach ($prestas as  $presta) {
					$_SESSION['erreur']['detail'] .= "pour le type de prestation de  : " . $presta->getLibelleTypePrestation() . "<br>";
				}
				$_SESSION['erreur']['detail'] .= "<br>";
				$prestas = View_TypePrestationsManager::getList(["LibellePrestation"], ["idActivite" => $elm->getIdActivite()]);
				foreach ($prestas as  $presta) {
					$_SESSION['erreur']['detail'] .= "pour la prestation de  : " . $presta->getLibellePrestation() . "<br>";
				}


				header("location:index.php?page=Erreur");
			} else {
				header("location:index.php?page=ListeUos");
			}
			break;
		}
}
