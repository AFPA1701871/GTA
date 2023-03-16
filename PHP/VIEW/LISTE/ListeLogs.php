<?php

echo '<main>';

echo '<div class="cote"></div>';

echo '<div><section class="colonne">';


//$objets = LogsManager::getList(null, null,"prisEnCompte, dateModifiee", Parametres::getNbEltParPage(),false,true);
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-6Log gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-6">Liste des changements après modification</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="grid-columns-span-6"><div class="demi"></div><input id=searchInList  title="'.texte("infoSearch").'" placeholder="'.texte("mot à chercher").'"/><i class="fa-solid fa-filter fa-margin" title="'.texte("infoSearch").'"></i><div class="demi"></div></div>';
echo '<div class="caseListe grid-columns-span-6">
<div></div>
<div class="bigEspace"></div>

<div></div>
</div>';

echo '<div class="caseListe labelListe borderbottom" data-name= "ActionLog">ActionLog</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "DateModifiee">Date Modifiée</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "PrisEnCompte">Pris En Compte</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "DateLog">Date de la Modification</div>';
echo '<div class="caseListe labelListe borderbottom" data-name= "UserLog">Modifiée par</div>';

echo '<div><div class=" caseListe texteClair borderbottom " ><p>'.texte('total').' :</p></div><div class="mini borderbottom" id="nbEnregs"></div></div>';
echo '</div><div class="grid-col-6Log gridListe grid-contenu"></div>';

// Affichage des enregistrements de la base de données
echo '<template>';
echo '<div class="donnees pyjama ">ActionLog</div>';
echo '<div class="donnees pyjama ">DateModifiee</div>';
echo '<div class="donnees pyjama ">PrisEnCompte</div>';
echo '<div class="donnees pyjama ">DateLog</div>';
echo '<div class="donnees pyjama ">UserLog</div>';

echo '<a class="pyjama"  href="index.php?page=FormLogs&mode=Modifier&id=IdLog"><i class="fas fa-pen"></i></a>';

echo '</template>';
//Derniere ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';

echo '<div class="caseListe grid-columns-span-6">
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