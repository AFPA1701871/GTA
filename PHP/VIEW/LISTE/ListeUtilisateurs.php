<?php

echo '<main>';

echo '<div class="cote"></div>';

echo '<div><section class="colonne">';


$objets = View_UtilisateursManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>'; //Création du template de la grid
echo '<div class="grid-col-10 gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-10">' . texte("Liste des Utilisateurs") . ' </div>';
echo '<div class="bigEspace"></div>';
echo '<div class="grid-columns-span-10"><div class="demi"></div><input id=searchInList  title="' . texte("infoSearch") . '" placeholder="' . texte("mot à chercher") . '"/><i class="fa-solid fa-filter fa-margin" title="' . texte("infoSearch") . '"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-10">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe"><a class="pyjama"  href="index.php?page=FormUtilisateurs&mode=Ajouter"><i class="fas fa-plus"></i></a></div>
<div></div>
</div>';

echo '<div class="caseListe labelListe borderbottom" data-name= "NomUtilisateur">' . texte("NomUtilisateur") . '</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "MatriculeUtilisateur">' . texte("MatriculeUtilisateur") . '</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "NomManager">' . texte("NomManager") . '</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "Actif">' . texte("Actif") . '</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "NumeroUo">' . texte("NumeroUo") . '</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "NomRole">' . texte("NomRole") . '</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe  borderbottom "></div>';
echo '<div class=" caseListe texteClair borderbottom " ><p>' . texte('total') . ' :</p></div><div class="mini borderbottom" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-10 gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees left pyjama">NomUtilisateur</div>';
echo '<div class="donnees pyjama">MatriculeUtilisateur</div>';
echo '<div class="donnees left pyjama">NomManager</div>';
echo '<div class="donnees pyjama">Actif</div>';
echo '<div class="donnees pyjama">NumeroUo</div>';
echo '<div class="donnees pyjama">NomRole</div>';
echo '<a class="pyjama"  href="index.php?page=FormUtilisateurs&mode=Afficher&id=IdUtilisateur"><i class="fas fa-file-contract"></i></a>';

echo '<a class="pyjama"  href="index.php?page=FormUtilisateurs&mode=Modifier&id=IdUtilisateur"><i class="fas fa-pen"></i></a>';

echo '<a class="pyjama"  href="index.php?page=FormUtilisateurs&mode=Supprimer&id=IdUtilisateur"><i class="fas fa-box-archive"></i></a>';

echo '<a class="pyjama"  href="index.php?page=ActionUtilisateurs&mode=Reinit&id=IdUtilisateur"><img src="IMG/refresh-lock.svg" class="resetPassword" alt="" /></a>';
echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';

echo '<div class="caseListe grid-columns-span-10">
	<div></div>
	<a href="index.php?page=Accueil"><button><i class="fas fa-house fa-rotate-180"></i></button></a>
	<div></div>
</div>';

echo '<div class="bigEspace grid-columns-span-9"></div>';

echo '<div class="bigEspace grid-columns-span-9 pagination"></div>';

echo '<div class="bigEspace grid-columns-span-9"></div>';
echo '</div>'; //Div
echo '<div class="cote"></div>';
echo '</section></main>';
