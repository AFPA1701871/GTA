<?php

 echo '<main>';

 echo '<div class="flex-0-1"></div>';

 echo '<div><section class="colonne">';
 

$objets = TypePrestationsManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-8 gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-8">Liste des TypePrestations </div>';
echo '<div class="bigEspace"></div>';
 echo '<div class="grid-columns-span-8"><div class="demi"></div><input name="filtre" title="entrer le mot à chercher puis cliquer sur le filtre" placeholder="mot à chercher"/><i class="fa-solid fa-filter" title="entrer le mot à chercher puis cliquer sur le filtre"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-8">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a href="index.php?page=FormTypePrestations&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe" data-name= "NumeroTypePrestation">NumeroTypePrestation</div>';
echo '<div class="caseListe labelListe" data-name= "LibelleTypePrestation">LibelleTypePrestation</div>';
echo '<div class="caseListe labelListe" data-name= "MotifRequis">MotifRequis</div>';
echo '<div class="caseListe labelListe" data-name= "UoRequis">UoRequis</div>';
echo '<div class="caseListe labelListe" data-name= "ProjetRequis">ProjetRequis</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair ">Nombre d\'éléments :</div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-8 gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees ">NumeroTypePrestation</div>';
echo '<div class="donnees ">LibelleTypePrestation</div>';
echo '<div class="donnees ">MotifRequis</div>';
echo '<div class="donnees ">UoRequis</div>';
echo '<div class="donnees ">ProjetRequis</div>';
 echo '<a href="index.php?page=FormTypePrestations&mode=Afficher&id=IdTypePrestation"><i class="fas fa-file-contract"></i></a>';
                                    
echo '<a href="index.php?page=FormTypePrestations&mode=Modifier&id=IdTypePrestation"><i class="fas fa-pen"></i></a>';
                                    
echo '<a href="index.php?page=FormTypePrestations&mode=Supprimer&id=IdTypePrestation"><i class="fas fa-trash-alt"></i></a>';
 echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';
                                 
echo '<div class="caseListe grid-columns-span-8">
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