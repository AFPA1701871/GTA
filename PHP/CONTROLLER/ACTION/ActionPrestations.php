<?php
$elm = new Prestations($_POST);

if (isset($_POST['idProjet'])) {
	$idprojet = $_POST['idProjet'];
}

switch ($_GET['mode']) {
	case "Ajouter": {
			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibellePrestation());
			$elm->setLibellePrestation($libelle);

			$elm = PrestationsManager::add($elm);

			if ($idprojet) {
				// On crée l'objet entier
				$projet = new Associations(['idPrestation' => $elm, 'idProjet' => $idprojet]);

				// On met à jour l'association
				$projet = AssociationsManager::add($projet);
			}

			header("location:index.php?page=ListePrestations");
			break;
		}
	case "Modifier": {
			// On doit récupérer l'id association à partir de id prestation
			$idasso = AssociationsManager::getList(['idAssociation'], ['idPrestation' => $elm->getIdPrestation()]);

			// On initialise la variable d'idAssociation qu'on utilisera (au cas où l'association n'existe pas encore/plus)
			$idAssoMod = null;

			// Si l'association existe déjà, on récupère son ID
			if ($idasso) {
				$idAssoMod = $idasso[0]->getIdAssociation();
			}

			// On crée l'objet entier
			$projet = new Associations(['idAssociation' => $idAssoMod, 'idPrestation' => $elm->getIdPrestation(), 'idProjet' => $idprojet]);

			// Si l'association n'existait pas/plus
			if (!$idasso) {
				// On la (re)crée
				$projet = AssociationsManager::add($projet);
			}
			// Sinon, si un idProjet est fournit
			elseif ($idprojet) {
				// On met à jour l'association
				$projet = AssociationsManager::update($projet);
			}
			// Si l'association existait mais que l'on ne fournit plus d'idProjet
			else {
				// On supprime l'association
				AssociationsManager::delete($projet);
			}

			// On désactive le rendu de < et >
			$libelle = htmlentities($elm->getLibellePrestation());
			$elm->setLibellePrestation($libelle);

			$elm = PrestationsManager::update($elm);
			header("location:index.php?page=ListePrestations");
			break;
		}
	case "Supprimer": {
			// On doit récupérer l'id association à partir de id prestation
			$idasso = AssociationsManager::getList(['idAssociation'], ['idPrestation' => $elm->getIdPrestation()]);
			if ($idasso != null) {
				// On crée l'objet entier
				$projet = new Associations(['idAssociation' => $idasso[0]->getIdAssociation()]);

				// On supprime l'association
				$projet = AssociationsManager::delete($projet);
			}
			$reponse = PrestationsManager::delete($elm);
			if ($reponse == false) {
				$_SESSION['erreur']['message'] = "Impossible de supprimer la prestation, elle est déjà utilisée";
				$_SESSION['erreur']['redirection'] = "?page=ListePrestations";
				$_SESSION['erreur']['detail'] = "<br>";
				$pointages = View_PointagesManager::getList(['NomUtilisateur','periode'], ['idPrestation' => $elm->getIdPrestation()]);
				foreach ($pointages as  $pointage) {
					$_SESSION['erreur']['detail'] .= "pour le pointage de  : " . $pointage->getNomUtilisateur() . " pour la période " . $pointage->getPeriode() . "<br>";
				}
				$_SESSION['erreur']['detail'] .= "<br>";
				$preferences = PreferencesManager::getList(null, ['idPrestation' => $elm->getIdPrestation()]);
				foreach ($preferences as  $preference) {
					$_SESSION['erreur']['detail'] .= "pour la preference de  : " . UtilisateursManager::findById($preference->getIdUtilisateur())->getNomUtilisateur() . "<br>";
				}

				header("location:index.php?page=Erreur");
			} else {
				header("location:index.php?page=ListePrestations");
			}
			break;
		}
}
