<?php
$elm = new Entites($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
			// On désactive le rendu de < et >
			$nom = htmlentities($elm->getLibelleEntite());
			$elm->setLibelleEntite($nom);
			$elm = EntitesManager::add($elm);
			header("location:index.php?page=ListeEntites");
			break;
		}
	case "Modifier": {
			// On désactive le rendu de < et >
			$nom = htmlentities($elm->getLibelleEntite());
			$elm->setLibelleEntite($nom);
			$elm = EntitesManager::update($elm);
			header("location:index.php?page=ListeEntites");
			break;
		}
	case "Supprimer": {
		var_dump($elm);
			$reponse = EntitesManager::delete($elm);
			if ($reponse == false) {
				$_SESSION['erreur']['message'] = "Impossible de supprimer l'Entite, il est déjà utilisée";
				$_SESSION['erreur']['redirection'] = "?page=ListeEntites";
				$_SESSION['erreur']['detail'] = "<br>";
				header("location:index.php?page=Erreur");
			} else {
				header("location:index.php?page=ListeEntites");
			}
			break;
		}
}
