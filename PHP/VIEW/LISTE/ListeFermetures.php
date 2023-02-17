<?php
global $regex;

echo '<main>';

echo '<div class="cote"></div>';

echo '<div><section class="colonne">';

$objets = FermeturesManager::getList(null, null, null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-4 gridListe grid-mini">';

echo '<div class="caseListe titreListe grid-columns-span-4">'.texte("Liste des Fermetures").'</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="grid-columns-span-4">';
	echo '<div class="double"></div><input id=searchInList  title="'.texte("infoSearch").'" placeholder="'.texte("mot à chercher").'"/><i class="fa-solid fa-filter" title="'.texte("infoSearch").'"></i><div class="vMini"></div>';
	echo '<div class="divfieldset"><fieldset class="fieldset"><legend>'.texte('addholidays').'</legend><label>'.texte('annee').' :</label><input type="number" id="anneeJoursFeries" name="AnneeJoursFeries" value="'.date('Y').'" pattern="'.$regex["num"].'" /><i class="fas fa-floppy-disk" id="ajoutJoursFeries"></i></fieldset></div>';
	echo '<div class="vMini"></div></div>';
echo '<div class="caseListe grid-columns-span-4">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe">
	<a class="pyjama" href="index.php?page=FormFermetures&mode=Ajouter"><i class="fas fa-plus"></i></a>

</div>
<div></div>
</div>';

echo '<div class="caseListe labelListe" data-name= "DateFermeture">'.texte("DateFermeture").'</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair "><p>'.texte('total').' :</p></div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-4 gridListe grid-contenu grid-mini"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees pyjama ">DateFermeture</div>';
echo '<a class="pyjama"  href="index.php?page=FormFermetures&mode=Afficher&id=IdFermeture"><i class="fas fa-file-contract"></i></a>';

echo '<a class="pyjama"  href="index.php?page=FormFermetures&mode=Modifier&id=IdFermeture"><i class="fas fa-pen"></i></a>';

echo '<a class="pyjama"  href="index.php?page=FormFermetures&mode=Supprimer&id=IdFermeture"><i class="fas fa-trash-alt"></i></a>';
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