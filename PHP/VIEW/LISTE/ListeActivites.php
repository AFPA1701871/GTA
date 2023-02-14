<?php

$formtype = ($_GET['page'] == 'FormTypePrestations'? true : false);

if (!$formtype)
{
	echo '<main>';

	echo '<div class="cote"></div>';
}

echo '<div><section class="colonne">';

$objets = ActivitesManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-'.($formtype?5:4).' gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-'.($formtype?5:4).'">'.texte("Liste des Activites").'</div>';
if (!$formtype) { echo '<div class="bigEspace"></div>'; }
echo '<div class="grid-columns-span-'.($formtype?5:4).'"><div class="demi"></div><input id=searchInList  title="'.texte("infoSearch").'" placeholder="'.texte("mot à chercher").'"/><i class="fa-solid fa-filter" title="entrer le mot à chercher puis cliquer sur le filtre"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-'.($formtype?5:4).'">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a class="pyjama"  href="index.php?page=FormActivites&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

if ($formtype) { echo '<div class="caseListe labelListe"></div>'; }
echo '<div class="caseListe labelListe" data-name= "LibelleActivite">'.texte("LibelleActivite").'</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair ">'.(!$formtype ? '<i class="fas fa-calculator"></i>':'').'</div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-'.($formtype?5:4).' gridListe grid-contenu">';

// Affichage des enregistrements de la base de données
if (!$formtype)
{
	echo '</div>';
	echo '<template>';
	echo '<div class="donnees pyjama left">LibelleActivite</div>';
	echo '<a class="pyjama"  href="index.php?page=FormActivites&mode=Afficher&id=IdActivite"><i class="fas fa-file-contract"></i></a>';

	echo '<a class="pyjama"  href="index.php?page=FormActivites&mode=Modifier&id=IdActivite"><i class="fas fa-pen"></i></a>';

	echo '<a class="pyjama"  href="index.php?page=FormActivites&mode=Supprimer&id=IdActivite"><i class="fas fa-trash-alt"></i></a>';
	echo '</template>';
} else {
	foreach ($objets AS $value)
	{
		$activite = ActivitesParTypesManager::getList(['idActivite'], ['idTypePrestation' => $_GET['id'], 'idActivite' => $value->getIdActivite()]);

		echo '<div class="donnees pyjama"><input type="checkbox" class="removeShadow"'.($activite?($activite[0]->getIdActivite()==$value->getIdActivite()?' checked':''):'').' data-id="'.$value->getIdActivite().'" /></div>';
		echo '<div class="donnees pyjama">'.$value->getLibelleActivite().'</div>';
		echo '<a class="pyjama"  href="index.php?page=FormActivites&mode=Afficher&id='.$value->getIdActivite().'"><i class="fas fa-file-contract"></i></a>';

		echo '<a class="pyjama"  href="index.php?page=FormActivites&mode=Modifier&id='.$value->getIdActivite().'"><i class="fas fa-pen"></i></a>';

		echo '<a class="pyjama"  href="index.php?page=FormActivites&mode=Supprimer&id='.$value->getIdActivite().'"><i class="fas fa-trash-alt"></i></a>';
	}

	echo '</div></div>';
}

//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';

echo '<div class="caseListe grid-columns-span-4">
	<div></div>
	<a href="index.php?page=Accueil"><button><i class="fas fa-house fa-rotate-180"></i></button></a>
	<div></div>
</div>';

echo '<div class="bigEspace grid-columns-span-9"></div>';

echo '<div class="bigEspace grid-columns-span-9 pagination"></div>';

echo '<div class="bigEspace grid-columns-span-9"></div>';
echo'</div>'; //Div

if (!$formtype)
{
	echo '<div class="cote"></div>';
	echo '</section></main>';
}