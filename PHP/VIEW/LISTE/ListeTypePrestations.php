<?php

echo '<main>';

echo '<div class="cote"></div>';

echo '<div><section class="colonne">';


$objets = TypePrestationsManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-8 gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-8">'.texte("Liste des Types Prestations").'</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="grid-columns-span-8"><div class="demi"></div><input id=searchInList  title="'.texte("infoSearch").'" placeholder="'.texte("mot à chercher").'"/><i class="fa-solid fa-filter" title="'.texte("infoSearch").'"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-8">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a class="pyjama"  href="index.php?page=FormTypePrestations&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe borderbottom  " data-name= "NumeroTypePrestation">'.texte("NumeroTypePrestation").'</div>';
echo '<div class="caseListe labelListe  borderbottom left" data-name= "LibelleTypePrestation">'.texte("LibelleTypePrestation").'</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "MotifRequis">'.texte("MotifRequis").'</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "UoRequis">'.texte("UoRequis").'</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "ProjetRequis">'.texte("ProjetRequis").'</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe  borderbottom "></div>';
echo '<div class=" caseListe texteClair borderbottom " ><p>'.texte('total').' :</p></div><div class="mini borderbottom" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-8 gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees pyjama ">NumeroTypePrestation</div>';
echo '<div class="donnees pyjama left">LibelleTypePrestation</div>';
echo '<div class="donnees pyjama ">MotifRequis</div>';
echo '<div class="donnees pyjama ">UoRequis</div>';
echo '<div class="donnees pyjama ">ProjetRequis</div>';
echo '<a class="pyjama"  href="index.php?page=FormTypePrestations&mode=Afficher&id=IdTypePrestation"><i class="fas fa-file-contract"></i></a>';

echo '<a class="pyjama"  href="index.php?page=FormTypePrestations&mode=Modifier&id=IdTypePrestation"><i class="fas fa-pen"></i></a>';

echo '<a class="pyjama"  href="index.php?page=FormTypePrestations&mode=Supprimer&id=IdTypePrestation"><i class="fas fa-trash-alt"></i></a>';
echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';

echo '<div class="caseListe grid-columns-span-8">
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