<?php

echo '<div class="bigEspace"></div>';
echo '<main>';
$totalRempli = 0;
$totalValide = 0;
// ********** PREMIERE COLONNE **********
echo '<div class="cote"></div>';
echo '<section class=colonne>';
$idManager = (isset($_GET['idUtilisateur'])) ? $_GET['idUtilisateur'] : $_SESSION['utilisateur']->getIdUtilisateur();
$manager = UtilisateursManager::findById($idManager);
$agents = View_UtilisateursManager::getList(['idUtilisateur', 'nomUtilisateur'], ['idManager' => $idManager, "actif" => 1], 'nomUtilisateur');
$periode = (isset($_GET['periode'])) ? $_GET['periode'] : periodeEnCours($idManager, "Valide");
// *** partie combobox mois/annee ***
echo '<div id="divComboDate" class="demi center">';
echo creerSelectTab($periode, tabMoisAnnee(), 'periode', true,"class='demi'");
echo '<div class="mini"></div><div class="center">Manager concerné : ' . $manager->getNomUtilisateur() . '</div>';
echo '</div>';

// *** partie tableau agents ***
$joursOuvres = NbJourParPeriode($periode);
echo '<div id="tabAgents">';
echo '<div class="vCenter gras">Nom de l\'agent</div>';
echo '<div class="vCenter gras">Rempli à</div>';
echo '<div class="vCenter gras">Statut</div>';
echo '<div class="vCenter gras">Report SIRH</div>';
echo '<div class="vCenter gras">Valider</div>';
echo '<div class="vCenter gras">Pointage</div>';

foreach ($agents as $key => $agent)
{
    $disabled = " <a></a>";
    $idAgent = $agent->getIdUtilisateur();
    $pointage = View_Pointages_PeriodeManager::SommePointage($idAgent, $periode);
    $valide = View_Pointages_PeriodeManager::NbValide($idAgent, $periode, "Utilisateur");
    $report = View_Pointages_PeriodeManager::NbReporte($idAgent, $periode, "Utilisateur");
    $reporte = ($report==1)?'<i class="fas fa-check"></i>':"";

    $bgc = ($key % 2 == 0) ? '' : 'bgc';
    if ($pointage == null)
    {
        $statut = '<i class="fas fa-circle-dot fa-black"></i>';
    }
    // non commencé
    elseif ($pointage < NbJourParPeriode($periode))
    {
        $statut = '<i class="fas fa-circle fa-orange"></i>'; //en cours
        $totalRempli += $pointage;
    }
    elseif ($valide == 1)
    { //validé
        $statut = '<i class="fas fa-check fa-green"></i>';
        $disabled = '<a href="index.php?page=Synthese&idUtilisateur=' . $agent->getIdUtilisateur() . '"><i class="fas fa-user-check"></i></a>';
        $totalRempli += $pointage;
        $totalValide += $pointage;
    }
    else
    { //terminé
        $statut = '<i class="fas fa-circle fa-green"></i>';
        $disabled = '<a href="index.php?page=Synthese&idUtilisateur=' . $agent->getIdUtilisateur() . '&periode=' . $periode . '"><i class="fas fa-user-check"></i></a>';
        $totalRempli += $pointage;
    }
    echo '<div class="vCenter ' . $bgc . '">' . $agent->getNomUtilisateur() . '</div>';
    echo '<div class="vCenter ' . $bgc . '">' . (round($pointage / $joursOuvres * 100 , 1)) . '%</div>';
    echo '<div class="vCenter ' . $bgc . '">' . $statut . '</div>';
    echo '<div class="vCenter ' . $bgc . '">' . $reporte . '</div>';
    echo '<div class="vCenter ' . $bgc . '">' . $disabled . '</div>';
    echo '<div class="vCenter ' . $bgc . '"><a href="index.php?page=FormPointages&periode=' . $periode . '&idUtilisateur=' . $agent->getIdUtilisateur() . '"><i class="fas fa-clock"></i></a></div>';

}
echo '</div>';
echo '</section>';
echo '<div class="cote"></div>';
// ********** DEUXIEME COLONNE **********
echo '<section class="colonne">';
echo '<input type="hidden" id="rempli" value=' . $totalRempli / count($agents) . '>';
echo '<input type="hidden" id="valide" value=' . $totalValide / count($agents) . '>';

// ***** CAMEMBERT 1*****
echo '<div class="camembert">';
echo '<input type="hidden" id="" value=33>';
echo '<canvas id="chart" data-role="manager"></canvas>';
echo '</div>';

echo '<div>Légende : </div>
        <div> <i class="fas fa-circle-dot fa-black"></i>&nbsp; : Pointage non commencé </div>
        <div> <i class="fas fa-circle fa-orange"></i>&nbsp; : Pointage commencé </div>
        <div> <i class="fas fa-circle fa-green"></i>&nbsp; : Pointage non commencé </div>
        <div> <i class="fas fa-check fa-green"></i>&nbsp; : Pointage validé par le manager </div>';
// ***** CAMEMBERT 2*****
echo '<div class="camembert">';
echo '<input type="hidden" id="" value=50>';
echo '<canvas id="chart" data-role="manager"></canvas>';
echo '</div>';

// ********** FIN DEUXIEME COLONNE **********
echo '</section>';
echo '<div class="cote"></div>';
echo '</main>';
