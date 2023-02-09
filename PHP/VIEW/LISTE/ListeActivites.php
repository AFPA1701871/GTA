<?php

 echo '<main>';

 echo '<div class="flex-0-1"></div>';

 echo '<div><section class="colonne">';
 

$objets = ActivitesManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-4 gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-4">'.texte("Liste des Activites").'</div>';
echo '<div class="bigEspace"></div>';
 echo '<div class="grid-columns-span-4"><div class="demi"></div><input id=searchInList  title="'.texte("infoSearch").' placeholder="'.texte("mot à chercher").'/><i class="fa-solid fa-filter" title="entrer le mot à chercher puis cliquer sur le filtre"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-4">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a href="index.php?page=FormActivites&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe" data-name= "LibelleActivite">'.texte("LibelleActivite").'</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair ">'.texte("NbElement").' :</div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-4 gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees left">LibelleActivite</div>';
 echo '<a href="index.php?page=FormActivites&mode=Afficher&id=IdActivite"><i class="fas fa-file-contract"></i></a>';
                                    
echo '<a href="index.php?page=FormActivites&mode=Modifier&id=IdActivite"><i class="fas fa-pen"></i></a>';
                                    
echo '<a href="index.php?page=FormActivites&mode=Supprimer&id=IdActivite"><i class="fas fa-trash-alt"></i></a>';
 echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';
                                 
echo '<div class="caseListe grid-columns-span-4">
	<div></div>
	<a href="index.php?page=Accueil"><button><i class="fas fa-sign-out-alt fa-rotate-180"></i></button></a>
	<div></div>
</div>';

echo '<div class="bigEspace grid-columns-span-9"></div>';

echo '<div class="bigEspace grid-columns-span-9 pagination"></div>';

echo '<div class="bigEspace grid-columns-span-9"></div>';
echo'</div>'; //Div
echo '<div class="flex-0-1"></div>';
echo '</section></main>';