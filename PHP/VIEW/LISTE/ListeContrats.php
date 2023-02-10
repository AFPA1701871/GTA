<?php

$formtype = ($_GET['page'] == 'FormUtilisateurs' && $_GET['mode'] == 'Afficher' ? true : false);

echo '<div><section class="colonne">';

$objets = ContratsManager::getList(null, ['idUtilisateur' => $_GET['id']], null, Parametres::getNbEltParPage());
echo '<div class="noDisplay NbEltParPage">' . Parametres::getNbEltParPage() . '</div>';
echo '<div class="bigEspace"></div>';
echo '<div class="bigEspace"></div>';//Création du template de la grid
echo '<div class="grid-col-'.($formtype?'4-nobutton':7).' gridListe">';

echo '<div class="caseListe titreListe grid-columns-span-'.($formtype?'4-nobutton':7).'">'.texte("Liste des Contrats").'</div>';
echo '<div class="caseListe grid-columns-span-'.($formtype?'4-nobutton':7).'">
<div></div>
<div class="bigEspace"></div>
<div class="caseListe">'.(!$formtype?'<a href="index.php?page=FormContrats&mode=Ajouter&idutilisateur='.$_GET['id'].'"><i class="fas fa-plus"></i></a>':'').'</div>
<div></div>
</div>';

echo '<div class="caseListe labelListe" data-name= "IdCentre">IdCentre</div>';
echo '<div class="caseListe labelListe" data-name= "IdUtilisateur">IdUtilisateur</div>';
echo '<div class="caseListe labelListe" data-name= "DateDebutContrat">DateDebutContrat</div>';
echo '<div class="caseListe labelListe" data-name= "DateFinContrat">DateFinContrat</div>';

//Remplissage de div vide pour la structure de la grid
echo '<div class="caseListe"></div>';
echo '<div class=" caseListe texteClair "></div><div class="mini" id="nbEnregs"></div> ';
echo '</div><div class="grid-col-'.($formtype?'4-nobutton':7).' gridListe grid-contenu">';

// Affichage des enregistrements de la base de données
foreach ($objets AS $value)
{
	echo '<div class="donnees ">'.CentresManager::findById($value->getIdCentre())->getNomCentre().'</div>';
	echo '<div class="donnees ">'.UtilisateursManager::findById($value->getIdUtilisateur())->getNomUtilisateur().'</div>';
	echo '<div class="donnees ">'.$value->getDateDebutContrat().'</div>';
	echo '<div class="donnees ">'.$value->getDateFinContrat().'</div>';
	if (!$formtype){
		echo '<a href="index.php?page=FormContrats&mode=Afficher&id='.$value->getIdContrat().'&idutilisateur='.$_GET['id'].'"><i class="fas fa-file-contract"></i></a>';

		echo '<a href="index.php?page=FormContrats&mode=Modifier&id='.$value->getIdContrat().'&idutilisateur='.$_GET['id'].'"><i class="fas fa-pen"></i></a>';

		echo '<a href="index.php?page=FormContrats&mode=Supprimer&id='.$value->getIdContrat().'&idutilisateur='.$_GET['id'].'"><i class="fas fa-trash-alt"></i></a>';
	}
}
echo '</div></div>';

//Dernière ligne du tableau (bouton retour)
echo '<div class="bigEspace"></div>';

echo '<div class="caseListe grid-columns-span-7">
	<div></div>
	<a href="index.php?page=ListeUtilisateurs"><button><i class="fas fa-house fa-rotate-180"></i></button></a>
	<div></div>
</div>';

echo '<div class="bigEspace grid-columns-span-9"></div>';

echo '<div class="bigEspace grid-columns-span-9 pagination"></div>';

echo '<div class="bigEspace grid-columns-span-9"></div>';
echo'</div>';
