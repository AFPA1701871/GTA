<?php
$elm = new Prestations($_POST);

if (isset($_POST['idProjet']))
{
	$idprojet = $_POST['idProjet'];
}

switch ($_GET['mode']) {
	case "Ajouter": {
		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibellePrestation());
		$elm->setLibellePrestation($libelle);

		$elm = PrestationsManager::add($elm);

		if ($idprojet)
		{
			// On crée l'objet entier
			$projet = new Associations(['idPrestation' => $elm, 'idProjet' => $idprojet]);

			// On met à jour l'association
			$projet = AssociationsManager::add($projet);
		}

		break;
	}
	case "Modifier": {
		if ($idprojet)
		{
			// On doit récupérer l'id association à partir de id prestation
			$idasso = AssociationsManager::getList(['idAssociation'], ['idPrestation' => $elm->getIdPrestation()]);

			// On crée l'objet entier
			$projet = new Associations(['idAssociation' => $idasso[0]->getIdAssociation(), 'idPrestation' => $elm->getIdPrestation(), 'idProjet' => $idprojet]);

			// On met à jour l'association
			$projet = AssociationsManager::update($projet);
		}

		// On désactive le rendu de < et >
		$libelle = htmlentities($elm->getLibellePrestation());
		$elm->setLibellePrestation($libelle);

		$elm = PrestationsManager::update($elm);
		break;
	}
	case "Supprimer": {
		// On doit récupérer l'id association à partir de id prestation
		$idasso = AssociationsManager::getList(['idAssociation'], ['idPrestation' => $elm->getIdPrestation()]);

		// On crée l'objet entier
		$projet = new Associations(['idAssociation' => $idasso[0]->getIdAssociation()]);

		// On supprime l'association
		$projet = AssociationsManager::delete($projet);

		$elm = PrestationsManager::delete($elm);
		break;
	}
}

header("location:index.php?page=ListePrestations");