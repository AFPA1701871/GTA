<?php
global $mois;
$nbReports = 0;
$totalAgents = 0;

$totalRempli=0;
$totalValide=0;
$idUtilisateur = $_SESSION['utilisateur']->getIdUtilisateur();
echo '<div class="bigEspace"></div>';
echo '<main>';
$periode = (isset($_GET['periode'])) ? $_GET['periode'] : periodeEnCours($idUtilisateur, "Reporte");

// ********** PREMIERE COLONNE **********
echo '<div class="cote"></div>';
echo '<section class=colonne>';
// *** partie combobox mois/annee ***
echo '<div id="divComboDate" class="demi center">';
echo creerSelectTab($periode, tabMoisAnnee(), 'periode', true);
echo '<div ></div>';
echo '</div>';

echo '<div class="mini center titre" >Etat des pointages</div>';
echo '<div id="tabManagers">';
    echo '<div class="vCenter gras borderbottom ">Nom du Manager</div>';
    echo '<div class="vCenter gras borderbottom ">Saisis</div>';
    echo '<div class="vCenter gras borderbottom ">Validés</div>';
    echo '<div class="vCenter gras borderbottom ">Report SIRH</div>';
    echo '<div class="vCenter borderbottom "></div>';

    $managers = View_UtilisateursManager::getList(['idUtilisateur','nomUtilisateur'], ['idRole'=>[2,4], 'Actif'=>1], 'nomUtilisateur');
    foreach ($managers as $key => $manager) {
        $bgc = ($key%2 == 0) ? '': 'bgc';
        $idManager = $manager->getIdUtilisateur();
        echo '<div class="vCenter '.$bgc.'">'.$manager->getNomUtilisateur().'</div>';
        $agents = View_UtilisateursManager::getListActifPeriode($periode,  $idManager);
        $saisi = View_Pointages_PeriodeManager::NombrePointages($idManager, $periode, null, "Manager");
        $valide = View_Pointages_PeriodeManager::NombrePointages($idManager, $periode, "valide", "Manager");
        $reporte = View_Pointages_PeriodeManager::NombrePointages($idManager, $periode, "reporte", "Manager");

        echo '<div class="vCenter '.$bgc.'">'.$saisi.'/'.count($agents).'</div>';
        echo '<div class="vCenter '.$bgc.'">'.$valide.'/'.count($agents).'</div>';
        echo '<div class="vCenter '.$bgc.'">'.$reporte.'/'.count($agents).'</div>';
        echo '<div class="vCenter '.$bgc.'"><a class="'.$bgc.'" href="index.php?page=TbManager&idUtilisateur='.$idManager.'&periode='.$periode.'"><i class="fas fa-file-contract"></i></a></div>';
        $nbReports += $reporte;
        $totalAgents += count($agents);
        $totalRempli += $saisi;
        $totalValide += $valide;
    }

    ////////////////////////////////////////////////////
    // Début Affichages des totaux après le tableau
    ////////////////////////////////////////////////////
    $bgc = ($bgc=='bgc')?'':'bgc';
    echo '<div class="vCenter gras '.$bgc.'">Totaux</div>';
    echo '<div class="vCenter gras '.$bgc.'">'.$totalRempli.'/'.$totalAgents.'</div>';
    echo '<div class="vCenter gras '.$bgc.'">'.$totalValide.'/'.$totalAgents.'</div>';
    echo '<div class="vCenter gras '.$bgc.'">'.$nbReports.'/'.$totalAgents.'</div>';
    echo '<div class="vCenter '.$bgc.'"></div>';
    ////////////////////////////////////////////////////
    // Fin Affichages des totaux après le tableau
    ////////////////////////////////////////////////////

echo '</div></section>';
echo '<div class="cote"></div>';
// ********** DEUXIEME COLONNE **********
echo '<section class="colonne">';

    // ***** CAMEMBERT *****
    $reportPourcentage = $nbReports * 100 / $totalAgents;
    echo '<div class="camembert">';
    echo '<input type="hidden" id="rempli" value='.$totalRempli * 100 / $totalAgents.'>';
    echo '<input type="hidden" id="valide" value='.$totalValide * 100 / $totalAgents.'>';
    echo '<input type="hidden" id="reporte" value='.$nbReports * 100 / $totalAgents.'>';
    echo'<canvas id="chart" data-role="assistante"></canvas>';
    echo '</div>';
    echo '<div class="mini center titre" >Pointages modifiés après saisie RH</div>';

    // ***** LISTE RE-MODIF *****
    echo '<div id="tabReModif">';
    echo '<div class="vCenter gras borderbottom ">Date</div>';
    echo '<div class="vCenter gras borderbottom ">Nom de l\'agent</div>';
    echo '<div class="vCenter borderbottom "></div>';

    $logs = View_LogsManager::getList(null, ['prisEnCompte'=>0],"periode",null,false,false);
    
    foreach ($logs as $key => $log) {
        $periode = $log->getPeriode();
        $bgc = ($key%2 == 0) ? '': 'bgc';
        echo '<div class="vCenter '.$bgc.'">'.tabMoisAnnee()[$periode].'</div>';
        echo '<div class="vCenter '.$bgc.'">'.$log->getNomUtilisateur().'</div>';
        echo '<div class="vCenter '.$bgc.'"><a class="'.$bgc.'" href="index.php?page=Synthese&periode='.$log->getPeriode().'&idUtilisateur='.$log->getIdUtilisateur().'"><i class="fas fa-file-contract"></i></a></div>';
    }
    echo '</div>';
echo '</section>';
echo '<div class="cote"></div>';

// ********** FIN DEUXIEME COLONNE **********
echo '</main>';