<?php

echo '<main>';

echo '<div class="cote"></div>';

echo '<div><section class="colonne">';


$objets = EntitesManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-4 gridListe grid-mini">';

echo '<div class="caseListe titreListe grid-columns-span-4">'.texte("Liste des Entites").'</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="grid-columns-span-4"><div class="demi"></div><input id=searchInList  title="'.texte("infoSearch").'" placeholder="'.texte("mot à chercher").'"/><i class="fa-solid fa-filter fa-margin" title="'.texte("infoSearch").'"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-4">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a class="pyjama"  href="index.php?page=FormEntites&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe left borderbottom" data-name= "LibelleEntite">'.texte("LibelleEntite").'</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe  borderbottom"></div>';
echo '<div class=" caseListe texteClair  borderbottom "><p>'.texte('total').' :</p></div><div class="mini borderbottom" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-4 gridListe grid-contenu grid-mini "></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees pyjama left ">LibelleEntite</div>';
echo '<a class="pyjama"  href="index.php?page=FormEntites&mode=Afficher&id=IdEntite"><i class="fas fa-file-contract"></i></a>';

echo '<a class="pyjama"  href="index.php?page=FormEntites&mode=Modifier&id=IdEntite"><i class="fas fa-pen"></i></a>';

echo '<a class="pyjama"  href="index.php?page=FormEntites&mode=Supprimer&id=IdEntite"><i class="fas fa-trash-alt"></i></a>';
echo '</template>';
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
echo '<div class="cote"></div>';
echo '</section></main>';