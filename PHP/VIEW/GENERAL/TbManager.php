<?php

echo '<div class="bigEspace"></div>';
echo '<main>';

// ********** PRMIERE COLONNE **********
echo '<div class="cote"></div>';
echo '<section class="section1">';
$idManager = (isset($_GET['idManager'])) ? $_GET['idManager'] : $_SESSION['utilisateur']->getIdUtilisateur();
$agents = UtilisateursManager::getList(['idUtilisateur', 'nomUtilisateur'], ['idManager' => $idManager], 'nomUtilisateur');
$periode = periodeEnCours($idManager, "Valide");
// *** partie combobox mois/annee ***
echo '<div id="divComboDate">';
echo creerSelectTab($periode, tabMoisAnnee(), 'comboDate', true);
echo '</div>';

// *** partie tableau agents ***
$joursOuvres = NbJourParPeriode($periode);
echo '<div id="tabAgents">';
echo '<div class="vCenter gras">Nom de l\'agent</div>';
echo '<div class="vCenter gras">Rempli à</div>';
echo '<div class="vCenter gras">Statut</div>';
echo '<div class="cote"></div>';

foreach ($agents as $key => $agent) {
    $idAgent = $agent->getIdUtilisateur();
    $pointage = View_Pointages_PeriodeManager::SommePointage($idAgent, $periode);
    $valide = View_Pointages_PeriodeManager::NbValide($idAgent, $periode, "Utilisateur");
    if ( $pointage ==null)
    $statut="pas commencé";
    elseif ($pointage < NbJourParPeriode($periode))
        $statut = "en cours";
    elseif ($valide == 1)
        $statut = "validé";
    else $statut = "terminé";
    $bgc = ($key % 2 == 0) ? '' : 'bgc';
    echo '<div class="vCenter ' . $bgc . '">' . $agent->getNomUtilisateur() . '</div>';
    echo '<div class="vCenter ' . $bgc . '">' . $pointage . '</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$statut.'</div>';
    echo '<div class="cote"></div>';
}
echo '</div>';
echo '</section>';

// ********** DEUXIEME COLONNE **********
echo '<section class="section2">';

// ***** CAMEMBERT 1*****
echo '<div class="camembert">';
echo '<input type="hidden" id="" value=33>';
echo '<canvas id="chart" data-role="manager"></canvas>';
echo '</div>';

// ***** CAMEMBERT 2*****
echo '<div class="camembert">';
echo '<input type="hidden" id="" value=50>';
echo '<canvas id="chart" data-role="manager"></canvas>';
echo '</div>';

// ********** FIN DEUXIEME COLONNE **********
echo '</section>';
echo '</main>';
