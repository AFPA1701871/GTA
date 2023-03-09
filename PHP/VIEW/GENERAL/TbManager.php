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
echo creerSelectTab($periode, tabMoisAnnee(), 'periode', true, "class='demi'");
echo '<div class="mini"></div><div class="center highlight">Manager concerné : ' . $manager->getNomUtilisateur() . '</div>';
echo '</div>';

// *** partie tableau agents ***
$joursOuvres = NbJourParPeriode($periode);
echo '<div id="tabAgents">';
echo '<div class="vCenter gras borderbottom">Nom de l\'agent</div>';
echo '<div class="vCenter gras borderbottom">Rempli à</div>';
echo '<div class="vCenter gras borderbottom">Statut</div>';
echo '<div class="vCenter gras borderbottom">Report SIRH</div>';
echo '<div class="vCenter gras borderbottom">Valider</div>';
echo '<div class="vCenter gras borderbottom">Pointage</div>';

foreach ($agents as $key => $agent) {
    $disabled = " <a></a>";
    $idAgent = $agent->getIdUtilisateur();
    $pointage = View_Pointages_PeriodeManager::SommePointage($idAgent, $periode);
    $valide = View_Pointages_PeriodeManager::SyntheseV3($idAgent, $periode, "valide", "Utilisateur", false);
    // $valide = View_Pointages_PeriodeManager::Synthese($idAgent, $periode, "valide");
    // Ancienne version
    // $valide = View_Pointages_PeriodeManager::JoursValides($idAgent, $periode);
    $report = View_Pointages_PeriodeManager::SyntheseV3($idAgent, $periode, "reporte", "Utilisateur", false);
    // $report = View_Pointages_PeriodeManager::Synthese($idAgent, $periode, "reporte");
    // Ancienne version
    //$report = View_Pointages_PeriodeManager::JoursReportes($idAgent, $periode, "Utilisateur");
    $reporte="";
    $bgc = ($key % 2 == 0) ? '' : 'bgc';
    if ($pointage == null) {
        $statut = '<i class="fas fa-circle-dot fa-black"></i>';
    }
    // non commencé
    elseif ($pointage < NbJourParPeriode($periode)) {
        $statut = '<i class="fas fa-circle fa-orange"></i>'; //en cours
        $totalRempli += $pointage;
    } elseif ($valide == $joursOuvres) { //validé
        $statut = '<i class="fas fa-check fa-green"></i>';
        if ($roleConnecte == 3) //lien vers la page de validation sur colonne SIRH
        {
            $disabled = '<i class="fas fa-user-check"></i>';
            $reporte = '<a href="index.php?page=Synthese&idUtilisateur=' . $agent->getIdUtilisateur() . '&periode=' . $periode . '"><i class="fas fa-todo fa-green" ></i></a>';
        } else //lien vers la page de validation sur colonne valider
        {
            $reporte = '<i class="fas fa-todo fa-green" ></i>';
            $disabled = '<a href="index.php?page=Synthese&idUtilisateur=' . $agent->getIdUtilisateur() . '&periode=' . $periode . '"><i class="fas fa-user-check"></i></a>';
        }
        $totalRempli += $pointage;
        $totalValide += $pointage;
    } else { //terminé
        $statut = '<i class="fas fa-circle fa-green"></i>';
        $disabled = '<a href="index.php?page=Synthese&idUtilisateur=' . $agent->getIdUtilisateur() . '&periode=' . $periode . '"><i class="fas fa-user-check"></i></a>';
        $totalRempli += $pointage;
    }
    $reporte = ($report == $joursOuvres) ? '<i class="fas fa-check"></i>' : $reporte;
    
    echo '<div class="vCenter ' . $bgc . '">' . $agent->getNomUtilisateur() . '</div>';
    echo '<div class="vCenter ' . $bgc . '">' . (round($pointage / $joursOuvres * 100, 1)) . '%</div>';
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
// Nécessite "*$joursOuvres", contrairement à TbAssistante, car $totalRempli et $totalValide retournent le nombres d'heures et non le nombre de salarié ayant la totalité
echo '<input type="hidden" id="rempli" value=' . (round(($totalRempli*100) / (count($agents)*$joursOuvres),1)) . '>';
echo '<input type="hidden" id="valide" value=' . (round(($totalValide*100) / (count($agents)*$joursOuvres),1)) . '>';

// ***** CAMEMBERT 1*****
echo '<div class="camembert">';
echo '<input type="hidden" id="" value=33>';
echo '<canvas id="chart" data-role="manager"></canvas>';
echo '</div>';

echo '<div class="colonne espace"><div class=>Légende : </div>
<div>&nbsp;</div>
<div class=>Colonne statut : </div>
<div> <i class="fas fa-circle-dot fa-black"></i>&nbsp; : Pointage non commencé </div>
<div> <i class="fas fa-circle fa-orange"></i>&nbsp; : Pointage commencé </div>
<div> <i class="fas fa-circle fa-green"></i>&nbsp; : Pointage complet </div>
<div> <i class="fas fa-check fa-green"></i>&nbsp; : Pointage validé par le manager </div>
<div>&nbsp;</div>
        <div class=>Colonne Report SIRH : </div>
        <div> <i class="fas fa-todo fa-green"></i>&nbsp; : Report possible </div>
        <div> <i class="fas fa-check fa-green"></i>&nbsp; : Report effectué </div>
        </div>';
// ***** CAMEMBERT 2*****
echo '<div class="camembert">';
echo '<input type="hidden" id="" value=50>';
echo '<canvas id="chart" data-role="manager"></canvas>';
echo '</div>';

// ********** FIN DEUXIEME COLONNE **********
echo '</section>';
echo '<div class="cote"></div>';
echo '</main>';
