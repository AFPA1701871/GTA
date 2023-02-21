<?php
$periode = "2023-01";
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
    echo '<div class="vCenter gras">Nom du Manager</div>';
    echo '<div class="vCenter gras">Saisis</div>';
    echo '<div class="vCenter gras">Validés</div>';
    echo '<div class="vCenter gras">Report SIRH</div>';
    echo '<div class="vCenter"></div>';

    $managers = UtilisateursManager::getList(['idUtilisateur','nomUtilisateur'], ['idRole'=>2], 'nomUtilisateur');
    foreach ($managers as $key => $manager) {
        $bgc = ($key%2 == 0) ? '': 'bgc';
        $idManager = $manager->getIdUtilisateur();
        echo '<div class="vCenter '.$bgc.'">'.$manager->getNomUtilisateur().'</div>';
        $agents = UtilisateursManager::getList(null, ['idManager'=>$idManager]);
        $saisi = View_Pointages_PeriodeManager::getList(null, ['idManager'=>$idManager,"periode"=>$periode]);
        $valide = View_Pointages_PeriodeManager::getList(null, ['idManager'=>$idManager,"periode"=>$periode, 'validePointage'=>1]);
        $reporte = View_Pointages_PeriodeManager::getList(null, ['idManager'=>$idManager,"periode"=>$periode, 'reportePointage'=>1]);

        echo '<div class="vCenter '.$bgc.'">'.count($saisi).'/'.count($agents).'</div>';
        echo '<div class="vCenter '.$bgc.'">'.count($valide).'/'.count($agents).'</div>';
        echo '<div class="vCenter '.$bgc.'">'.count($reporte).'/'.count($agents).'</div>';
        echo '<div class="vCenter '.$bgc.'"><a class="'.$bgc.'" href="index.php?page=TbManager&idUtilisateur='.$idManager.'&periode='.$periode.'"><i class="fas fa-file-contract"></i></a></div>';
        $nbReports += count($reporte);
        $totalAgents += count($agents);
        $totalRempli += count($saisi);
        $totalValide += count($valide);
    }
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
    echo '<div class="vCenter gras">Date</div>';
    echo '<div class="vCenter gras">Nom de l\'agent</div>';
    echo '<div class="vCenter"></div>';

    $logs = LogsManager::getList(null, ['prisEnCompte'=>0],'dateLog',null,false,false);
    
    foreach ($logs as $key => $log) {
        $bgc = ($key%2 == 0) ? '': 'bgc';
        $nomAgent = UtilisateursManager::getList(['nomUtilisateur'],['idUtilisateur' => $log->getIdUtilisateur()])[0]->getNomUtilisateur();
        echo '<div class="vCenter '.$bgc.'">'.texte($log->getDateModifiee()).'</div>';
        echo '<div class="vCenter '.$bgc.'">'.$nomAgent.'</div>';
        echo '<div class="vCenter '.$bgc.'"><a class="'.$bgc.'" href="index.php?page=ListeLogs&amp;mode=Afficher&amp;id=20"><i class="fas fa-file-contract"></i></a></div>';
    }
    echo '</div>';
echo '</section>';
echo '<div class="cote"></div>';

// ********** FIN DEUXIEME COLONNE **********
echo '</main>';