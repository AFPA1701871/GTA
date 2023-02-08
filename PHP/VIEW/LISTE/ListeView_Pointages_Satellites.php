<?php

 echo '<main>';

 echo '<div class="cote"></div>';

 echo '<div><section class="colonne">';
 

$objets = View_Pointages_SatellitesManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-29 gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-29">Liste des View_Pointages_Satellites </div>';
echo '<div class="bigEspace"></div>';
 echo '<div class="grid-columns-span-29"><div class="demi"></div><input id=searchInList  title="entrer le mot à chercher puis cliquer sur le filtre" placeholder="mot à chercher"/><i class="fa-solid fa-filter" title="entrer le mot à chercher puis cliquer sur le filtre"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-29">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a href="index.php?page=FormView_Pointages_Satellites&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe" data-name= "DatePointage">DatePointage</div>';
echo '<div class="caseListe labelListe" data-name= "ValidePointage">ValidePointage</div>';
echo '<div class="caseListe labelListe" data-name= "ReportePointage">ReportePointage</div>';
echo '<div class="caseListe labelListe" data-name= "NbHeuresPointage">NbHeuresPointage</div>';
echo '<div class="caseListe labelListe" data-name= "IdUtilisateur">IdUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "NomUtilisateur">NomUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "MailUtilisateur">MailUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "MatriculeUtilisateur">MatriculeUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "PasswordUtilisateur">PasswordUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "IdUO_Utilisateur">IdUO_Utilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "IdRole">IdRole</div>';
echo '<div class="caseListe labelListe" data-name= "IdManager">IdManager</div>';
echo '<div class="caseListe labelListe" data-name= "IdUO_Pointage">IdUO_Pointage</div>';
echo '<div class="caseListe labelListe" data-name= "NumeroUO">NumeroUO</div>';
echo '<div class="caseListe labelListe" data-name= "LibelleUO">LibelleUO</div>';
echo '<div class="caseListe labelListe" data-name= "IdMotif">IdMotif</div>';
echo '<div class="caseListe labelListe" data-name= "CodeMotif">CodeMotif</div>';
echo '<div class="caseListe labelListe" data-name= "LibelleMotif">LibelleMotif</div>';
echo '<div class="caseListe labelListe" data-name= "IdTypePrestation">IdTypePrestation</div>';
echo '<div class="caseListe labelListe" data-name= "IdProjet">IdProjet</div>';
echo '<div class="caseListe labelListe" data-name= "CodeProjet">CodeProjet</div>';
echo '<div class="caseListe labelListe" data-name= "LibelleProjet">LibelleProjet</div>';
echo '<div class="caseListe labelListe" data-name= "IdPrestation">IdPrestation</div>';
echo '<div class="caseListe labelListe" data-name= "CodePrestation">CodePrestation</div>';
echo '<div class="caseListe labelListe" data-name= "LibellePrestation">LibellePrestation</div>';
echo '<div class="caseListe labelListe" data-name= "IdActivite">IdActivite</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair ">Nombre d\'éléments :</div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-29 gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees ">DatePointage</div>';
echo '<div class="donnees ">ValidePointage</div>';
echo '<div class="donnees ">ReportePointage</div>';
echo '<div class="donnees ">NbHeuresPointage</div>';
echo '<div class="donnees ">IdUtilisateur</div>';
echo '<div class="donnees ">NomUtilisateur</div>';
echo '<div class="donnees ">MailUtilisateur</div>';
echo '<div class="donnees ">MatriculeUtilisateur</div>';
echo '<div class="donnees ">PasswordUtilisateur</div>';
echo '<div class="donnees ">IdUO_Utilisateur</div>';
echo '<div class="donnees ">IdRole</div>';
echo '<div class="donnees ">IdManager</div>';
echo '<div class="donnees ">IdUO_Pointage</div>';
echo '<div class="donnees ">NumeroUO</div>';
echo '<div class="donnees ">LibelleUO</div>';
echo '<div class="donnees ">IdMotif</div>';
echo '<div class="donnees ">CodeMotif</div>';
echo '<div class="donnees ">LibelleMotif</div>';
echo '<div class="donnees ">IdTypePrestation</div>';
echo '<div class="donnees ">IdProjet</div>';
echo '<div class="donnees ">CodeProjet</div>';
echo '<div class="donnees ">LibelleProjet</div>';
echo '<div class="donnees ">IdPrestation</div>';
echo '<div class="donnees ">CodePrestation</div>';
echo '<div class="donnees ">LibellePrestation</div>';
echo '<div class="donnees ">IdActivite</div>';
 echo '<a href="index.php?page=FormView_Pointages_Satellites&mode=Afficher&id=IdPointage"><i class="fas fa-file-contract"></i></a>';
                                    
echo '<a href="index.php?page=FormView_Pointages_Satellites&mode=Modifier&id=IdPointage"><i class="fas fa-pen"></i></a>';
                                    
echo '<a href="index.php?page=FormView_Pointages_Satellites&mode=Supprimer&id=IdPointage"><i class="fas fa-trash-alt"></i></a>';
 echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';
                                 
echo '<div class="caseListe grid-columns-span-29">
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