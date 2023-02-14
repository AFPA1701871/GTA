<?php

 echo '<main>';

 echo '<div class="cote"></div>';

 echo '<div><section class="colonne">';
 

$objets = LogsManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-7 gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-7">'.texte("Liste des Logs").'</div>';
echo '<div class="bigEspace"></div>';
 echo '<div class="grid-columns-span-7"><div class="demi"></div><input id=searchInList  title="'.texte("infoSearch").' placeholder="'.texte("mot à chercher").'/><i class="fa-solid fa-filter" title="entrer le mot à chercher puis cliquer sur le filtre"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-7">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a class="pyjama"  href="index.php?page=FormLogs&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe" data-name= "DateLog">DateLog</div>';
echo '<div class="caseListe labelListe" data-name= "ActionLog">ActionLog</div>';
echo '<div class="caseListe labelListe" data-name= "PrisEnCompte">PrisEnCompte</div>';
echo '<div class="caseListe labelListe" data-name= "IdUtilisateur">IdUtilisateur</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair "><p>Total :</p></div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-7 gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees pyjama ">DateLog</div>';
echo '<div class="donnees pyjama ">ActionLog</div>';
echo '<div class="donnees pyjama ">PrisEnCompte</div>';
echo '<div class="donnees pyjama ">IdUtilisateur</div>';
 echo '<a class="pyjama"  href="index.php?page=FormLogs&mode=Afficher&id=IdLog"><i class="fas fa-file-contract"></i></a>';
                                    
echo '<a class="pyjama"  href="index.php?page=FormLogs&mode=Modifier&id=IdLog"><i class="fas fa-pen"></i></a>';
                                    
echo '<a class="pyjama"  href="index.php?page=FormLogs&mode=Supprimer&id=IdLog"><i class="fas fa-trash-alt"></i></a>';
 echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';
                                 
echo '<div class="caseListe grid-columns-span-7">
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