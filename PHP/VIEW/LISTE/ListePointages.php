<?php

 echo '<main>';

 echo '<div class="cote"></div>';

 echo '<div><section class="colonne">';
 

$objets = PointagesManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-12 gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-12">'.texte("Liste des Pointages").'</div>';
echo '<div class="bigEspace"></div>';
 echo '<div class="grid-columns-span-12"><div class="demi"></div><input id=searchInList  title="'.texte("infoSearch").' placeholder="'.texte("mot à chercher").'/><i class="fa-solid fa-search" title="entrer le mot à chercher puis cliquer sur le filtre"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-12">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a class="pyjama"  href="index.php?page=FormPointages&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe" data-name= "IdMotif">'.texte("IdMotif").'</div>';
echo '<div class="caseListe labelListe" data-name= "IdPrestation">'.texte("IdPrestation").'</div>';
echo '<div class="caseListe labelListe" data-name= "IdProjet">'.texte("IdProjet").'</div>';
echo '<div class="caseListe labelListe" data-name= "IdUO">'.texte("IdUO").'</div>';
echo '<div class="caseListe labelListe" data-name= "IdUtilisateur">'.texte("IdUtilisateur").'</div>';
echo '<div class="caseListe labelListe" data-name= "DatePointage">'.texte("DatePointage").'</div>';
echo '<div class="caseListe labelListe" data-name= "ValidePointage">'.texte("ValidePointage").'</div>';
echo '<div class="caseListe labelListe" data-name= "ReportePointage">'.texte("ReportePointage").'</div>';
echo '<div class="caseListe labelListe" data-name= "NbHeuresPointage">'.texte("NbHeuresPointage").'</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair "><i class="fas fa-calculator"></i></div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-12 gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees pyjama ">IdMotif</div>';
echo '<div class="donnees pyjama ">IdPrestation</div>';
echo '<div class="donnees pyjama ">IdProjet</div>';
echo '<div class="donnees pyjama ">IdUO</div>';
echo '<div class="donnees pyjama ">IdUtilisateur</div>';
echo '<div class="donnees pyjama ">DatePointage</div>';
echo '<div class="donnees pyjama ">ValidePointage</div>';
echo '<div class="donnees pyjama ">ReportePointage</div>';
echo '<div class="donnees pyjama ">NbHeuresPointage</div>';
 echo '<a class="pyjama"  href="index.php?page=FormPointages&mode=Afficher&id=IdPointage"><i class="fas fa-file-contract"></i></a>';
                                    
echo '<a class="pyjama"  href="index.php?page=FormPointages&mode=Modifier&id=IdPointage"><i class="fas fa-pen"></i></a>';
                                    
echo '<a class="pyjama"  href="index.php?page=FormPointages&mode=Supprimer&id=IdPointage"><i class="fas fa-trash-alt"></i></a>';
 echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';
                                 
echo '<div class="caseListe grid-columns-span-12">
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