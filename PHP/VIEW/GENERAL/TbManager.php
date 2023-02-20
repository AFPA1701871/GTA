<?php

echo '<div class="bigEspace"></div>';
echo '<main>';
$totalRempli=0;
$totalValide=0;
// ********** PREMIERE COLONNE **********
echo '<div class="cote"></div>';
echo '<section class="section1">';
$idManager = (isset($_GET['idManager'])) ? $_GET['idManager'] : $_SESSION['utilisateur']->getIdUtilisateur();
$agents = View_UtilisateursManager::getList(['idUtilisateur', 'nomUtilisateur'], ['idManager' => $idManager,"actif"=>1], 'nomUtilisateur');
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
echo '<div class="vCenter gras">Valider</div>';
echo '<div class="vCenter gras">Pointage</div>';
echo '<div class="cote"></div>';

foreach ($agents as $key => $agent) {
    $disabled=" <a></a>";
    $idAgent = $agent->getIdUtilisateur();
    $pointage = View_Pointages_PeriodeManager::SommePointage($idAgent, $periode);
    $valide = View_Pointages_PeriodeManager::NbValide($idAgent, $periode, "Utilisateur");
    if ( $pointage ==null)
    $statut='<i class="fas fa-circle fa-white"></i>'; // non commencé
    elseif ($pointage < NbJourParPeriode($periode))
    {
        $statut = '<i class="fas fa-circle fa-orange"></i>';  //en cours
        $totalRempli += $pointage;
    }
    elseif ($valide == 1)
    {   //validé
        $statut = '<i class="fas fa-check fa-green"></i>';
        $disabled='<a href="index.php?page=Synthese&id='.$agent->getIdUtilisateur().'"><i class="fas fa-user-check"></i></a>';
        $totalRempli += $pointage;
        $totalValide += $pointage;
    }
    else {//terminé
        $statut = '<i class="fas fa-circle fa-green"></i>';
        $disabled='<a href="index.php?page=Synthese&id='.$agent->getIdUtilisateur().'"><i class="fas fa-user-check"></i></a>';
        $totalRempli += $pointage;
    }
    $bgc = ($key % 2 == 0) ? '' : 'bgc';
    echo '<div class="vCenter ' . $bgc . '">' . $agent->getNomUtilisateur() . '</div>';
    echo '<div class="vCenter ' . $bgc . '">' . $pointage . '</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$statut.'</div>';
    echo '<div class="vCenter ' . $bgc . '">'.$disabled.'</div>';
    echo '<div class="vCenter ' . $bgc . '"><a href="index.php?page=FormPointages&periode='.$periode.'&idUtilisateur='.$agent->getIdUtilisateur().'"><i class="fas fa-clock"></i></a></div>';
    echo '<div class="cote"></div>';
}
echo '</div>';
echo '</section>';

// ********** DEUXIEME COLONNE **********
echo '<section class="section2">';
echo '<input type="hidden" id="rempli" value='.$totalRempli / count($agents).'>';
echo '<input type="hidden" id="valide" value='.$totalValide / count($agents).'>';

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
