<?php

 echo '<main>';

 echo '<div class="cote"></div>';

 echo '<div><section class="colonne">';
 

$objets = View_Utilisateurs_Preferences_PrestationsManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-15 gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-15">'.texte("Liste des Utilisateurs").'</div>';
echo '<div class="bigEspace"></div>';
 echo '<div class="grid-columns-span-15"><div class="demi"></div><input id=searchInList  title="'.texte("infoSearch").'" placeholder="'.texte("mot à chercher").'"/><i class="fa-solid fa-filter" title="entrer le mot à chercher puis cliquer sur le filtre"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-15">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a class="pyjama"  href="index.php?page=FormView_Utilisateurs_Preferences_Prestations&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe" data-name= "IdUtilisateur">IdUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "NomUtilisateur">NomUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "MailUtilisateur">MailUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "MatriculeUtilisateur">MatriculeUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "PasswordUtilisateur">PasswordUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "IdUO">IdUO</div>';
echo '<div class="caseListe labelListe" data-name= "IdRole">IdRole</div>';
echo '<div class="caseListe labelListe" data-name= "IdManager">IdManager</div>';
echo '<div class="caseListe labelListe" data-name= "IdPrestation">IdPrestation</div>';
echo '<div class="caseListe labelListe" data-name= "CodePrestation">CodePrestation</div>';
echo '<div class="caseListe labelListe" data-name= "LibellePrestation">LibellePrestation</div>';
echo '<div class="caseListe labelListe" data-name= "IdActivite">IdActivite</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair "><p>Total :</p></div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-15 gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees ">IdUtilisateur</div>';
echo '<div class="donnees ">NomUtilisateur</div>';
echo '<div class="donnees ">MailUtilisateur</div>';
echo '<div class="donnees ">MatriculeUtilisateur</div>';
echo '<div class="donnees ">PasswordUtilisateur</div>';
echo '<div class="donnees ">IdUO</div>';
echo '<div class="donnees ">IdRole</div>';
echo '<div class="donnees ">IdManager</div>';
echo '<div class="donnees ">IdPrestation</div>';
echo '<div class="donnees ">CodePrestation</div>';
echo '<div class="donnees ">LibellePrestation</div>';
echo '<div class="donnees ">IdActivite</div>';
 echo '<a class="pyjama"  href="index.php?page=FormView_Utilisateurs_Preferences_Prestations&mode=Afficher&id=IdPreference"><i class="fas fa-file-contract"></i></a>';
                                    
echo '<a class="pyjama"  href="index.php?page=FormView_Utilisateurs_Preferences_Prestations&mode=Modifier&id=IdPreference"><i class="fas fa-pen"></i></a>';
                                    
echo '<a class="pyjama"  href="index.php?page=FormView_Utilisateurs_Preferences_Prestations&mode=Supprimer&id=IdPreference"><i class="fas fa-trash-alt"></i></a>';
 echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';
                                 
echo '<div class="caseListe grid-columns-span-15">
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