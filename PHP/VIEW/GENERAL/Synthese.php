<?php

echo '<div class="bigEspace"></div>';
echo '<main>';
$totalRempli=0;
$totalValide=0;
// ********** PREMIERE COLONNE **********
echo '<div class="cote"></div>';
echo '<section class=colonne>';
$idUtilisateur = (isset($_GET['idUtilisateur'])) ? $_GET['idUtilisateur'] : $_SESSION['utilisateur']->getIdUtilisateur();
$utilisateur = UtilisateursManager::findById($idUtilisateur);
$periode = (isset($_GET['periode'])) ? $_GET['periode'] : periodeEnCours($idUtilisateur, "Valide");
// *** partie combobox mois/annee ***
echo '<div id="divComboDate" class="demi center">';
echo creerSelectTab($periode, tabMoisAnnee(), 'periode', true);
echo '<div class="mini"></div><div class="center">Utilisateur concerné : '. $utilisateur->getNomUtilisateur().'</div>';
echo '</div>';

// *** partie tableau agents ***
$joursOuvres = NbJourParPeriode($periode);
echo '<div id="tabPointage">';
echo '<div class="vCenter gras">Type de Prestation</div>';
echo '<div class="vCenter gras">Prestation</div>';
echo '<div class="vCenter gras">Code Projet</div>';
echo '<div class="vCenter gras">UO de MAD</div>';
echo '<div class="vCenter gras">Motif</div>';
echo '<div class="vCenter gras">Nb Jours</div>';
echo '<div class="vCenter gras">Pourcentage</div>';

$listePointage = View_PointagesManager::getSomme($idUtilisateur,$periode);
foreach ($listePointage as $key=>$pointage) {
    
    $bgc = ($key % 2 == 0) ? '' : 'bgc';
    echo '<div class="vCenter ' . $bgc . '">' . $pointage->getNumeroTypePrestation() . '</div>';
    echo '<div class="vCenter ' . $bgc . '">' . $pointage->getCodePrestation() . '</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$pointage->getCodeProjet().'</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$pointage->getNumeroUO().'</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$pointage->getCodeMotif().'</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$pointage->getNbHeuresPointage().'</div>';
    echo '<div class="vCenter ' . $bgc . '">'. Round($pointage->getNbHeuresPointage()/$joursOuvres*100,2).'%</div>';
    
}
echo '</div>';
echo '</section>';
echo '<div class="cote"></div>';
$contenu = ($roleConnecte == 2) ? "Valider":"Reporter dans SIRH";
echo '<section class="colonne vCenter">
<div></div>
<button><i class="fas fa-check fa-green"></i>&nbsp;'.$contenu.'</button>
<div></div>
<button><i class="fas fa-house"></i>&nbsp;Retour</button><div></div>
</section>';
echo '<div class="cote"></div>';
echo '</main>';
