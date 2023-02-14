<?php

 echo '<main>';

 echo '<div class="cote"></div>';

 echo '<div><section class="colonne">';
 

$objets = UosManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-5 gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-5">'.texte("Liste des Uos").'</div>';
echo '<div class="bigEspace"></div>';
 echo '<div class="grid-columns-span-5"><div class="demi"></div><input id=searchInList  title="'.texte("infoSearch").' placeholder="'.texte("mot à chercher").'/><i class="fa-solid fa-filter" title="entrer le mot à chercher puis cliquer sur le filtre"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-5">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a class="pyjama"  href="index.php?page=FormUos&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe" data-name= "NumeroUO">'.texte("NumeroUO").'</div>';
echo '<div class="caseListe labelListe left" data-name= "LibelleUO">'.texte("LibelleUO").'</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair "><i class="fas fa-calculator"></i></div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-5 gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees pyjama ">NumeroUO</div>';
echo '<div class="donnees pyjama left">LibelleUO</div>';
 echo '<a class="pyjama"  href="index.php?page=FormUos&mode=Afficher&id=IdUO"><i class="fas fa-file-contract"></i></a>';
                                    
echo '<a class="pyjama"  href="index.php?page=FormUos&mode=Modifier&id=IdUO"><i class="fas fa-pen"></i></a>';
                                    
echo '<a class="pyjama"  href="index.php?page=FormUos&mode=Supprimer&id=IdUO"><i class="fas fa-trash-alt"></i></a>';
 echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';
                                 
echo '<div class="caseListe grid-columns-span-5">
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