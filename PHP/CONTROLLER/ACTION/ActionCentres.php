<?php
$elm = new Centres($_POST);

switch ($_GET['mode']) {
	case "Ajouter": {
			// On désactive le rendu de < et >
			$nom = htmlentities($elm->getNomCentre());
			$elm->setNomCentre($nom);
			$elm = CentresManager::add($elm);
			header("location:index.php?page=ListeCentres");
			break;
		}
	case "Modifier": {
			// On désactive le rendu de < et >
			$nom = htmlentities($elm->getNomCentre());
			$elm->setNomCentre($nom);
			$elm = CentresManager::update($elm);
			header("location:index.php?page=ListeCentres");
			break;
		}
	case "Supprimer": {
			$reponse = CentresManager::delete($elm);
			if ($reponse == false) {
				$_SESSION['erreur']['message'] = "Impossible de supprimer le centre, il est déjà utilisée";
				$_SESSION['erreur']['redirection'] = "?page=ListeCentres";
				$_SESSION['erreur']['detail'] = "<br>";
				$users = View_UtilisateursManager::getList(['NomUtilisateur'], ["idCentre" => $elm->getIdCentre()]);
				foreach ($users as  $user) {
					$_SESSION['erreur']['detail'] .= "pour le contrat de l'utilisateur : " . $user->getNomUtilisateur() . "<br>";
				}
				header("location:index.php?page=Erreur");
			} else {
				header("location:index.php?page=ListeCentres");
			}
			break;
		}
}
