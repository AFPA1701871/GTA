<?php

echo '<div class="bigEspace"></div>';
echo '<main class="flex ">';
$totalRempli=0;
$totalValide=0;
// ********** PREMIERE COLONNE **********
echo '<div class="cote"></div><div class=colonne>';
echo '<section class="colonne span3">';
//on récupère l'utilisateur
$idUtilisateur = (isset($_GET['idUtilisateur'])) ? $_GET['idUtilisateur'] : $_SESSION['utilisateur']->getIdUtilisateur();
$utilisateur = UtilisateursManager::findById($idUtilisateur);
//on récupère la période
$periode = (isset($_GET['periode'])) ? $_GET['periode'] : periodeEnCours($idUtilisateur, "Valide");
//on récupère le nombre de jour ouvré
$joursOuvres = NbJourParPeriode($periode);
//on récupère la liste du pointage
$listePointage = View_PointagesManager::getSomme($idUtilisateur,$periode);

/**********************Il faut vérifier sur tous les pointages cas des changements après validation ******************** */
$statut = ($listePointage[0]->getValidePointage()==1)?"validé ":"";
$statut .= ($listePointage[0]->getReportePointage()==1)?"reporté SIRH ":"";
// *** partie combobox mois/annee ***
echo '<div id="divComboDate" class="demi center">';
echo    creerSelectTab($periode, tabMoisAnnee(), 'periode', true);
echo '  <div class="mini"></div>
        <div class="center highlight">Utilisateur concerné : '. $utilisateur->getNomUtilisateur().'</div>
        <div class="mini"></div>
        <div class="center highlight">Statut : '. $statut.'</div>';
echo '</div>';
echo '</section><div class="cote"></div><div class="cote"></div><section> ';
// *** partie tableau agents ***


echo '<div id="tabPointage">';
echo '<div class="vCenter gras">Type de Prestation</div>';
echo '<div class="vCenter gras">Prestation</div>';
echo '<div class="vCenter gras">Code Projet</div>';
echo '<div class="vCenter gras">UO de MAD</div>';
echo '<div class="vCenter gras">Motif</div>';
echo '<div class="vCenter gras">Nb Jours</div>';
echo '<div class="vCenter gras">Pourcentage</div>';
$joursAbs=0;
foreach ($listePointage as $key=>$pointage) {
    
    $bgc = ($key % 2 == 0) ? '' : 'bgc';
    echo '<div class="vCenter ' . $bgc . '">' . $pointage->getNumeroTypePrestation() . '</div>';
    echo '<div class="vCenter ' . $bgc . '">' . $pointage->getCodePrestation() . '</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$pointage->getCodeProjet().'</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$pointage->getNumeroUO().'</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$pointage->getCodeMotif().'</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$pointage->getNbHeuresPointage().'</div>';
    if($pointage->getNumeroTypePrestation()==1){
        $joursAbs=$pointage->getNbHeuresPointage();
        echo '<div class="vCenter ' . $bgc . '"></div>';
    }else{
    echo '<div class="vCenter ' . $bgc . '">'. (($joursOuvres-$joursAbs!=0)?Round($pointage->getNbHeuresPointage()/($joursOuvres-$joursAbs)*100,2):0).'%</div>';
    }
}
echo '<div clas="NoDisplay" id=idUtilisateur data-value='.$idUtilisateur.'></div>';
echo '<div clas="NoDisplay" id=idPeriode data-value="'.$periode.'"></div>';
echo '</div>';
echo '</section>';
echo '<div class="cote"></div>';

// Autoriser les assistantes à valider un pointage avant de le reporter?
//$contenu = ($roleConnecte == 2 || ($roleConnecte == 3 && $statut=="")) ? "Valider":"Reporter dans SIRH";
$contenu = ($roleConnecte == 2) ? "Valider":"Reporter dans SIRH";

echo '<section class=" vCenter">
<div></div>
<button id=retour><i class="fas fa-house"></i>&nbsp;Retour</button><div></div>
<div></div>
<button id=valide><i class="fas fa-check fa-green"></i>&nbsp;'.$contenu.'</button>
<div></div>
</section>
</div>';
echo '<div class="cote"></div>';
echo '</main>';
