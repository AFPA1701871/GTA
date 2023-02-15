<?php
$nbReports = 0;
$totalAgents = 0;
echo '<div class="bigEspace"></div>';
echo '<main>';

// ********** PRMIERE COLONNE **********
echo '<div class="cote"></div>';
echo '<section id="tabManager">';
echo '<div class="vCenter gras">Nom du Manager</div>';
echo '<div class="vCenter gras">Saisis</div>';
echo '<div class="vCenter gras">Validés</div>';
echo '<div class="vCenter gras">Report SIRH</div>';
echo '<div class="vCenter"></div>';
echo '<div class="cote"></div>';

$managers = UtilisateursManager::getList(['idUtilisateur','nomUtilisateur'], ['idRole'=>2], 'nomUtilisateur');
foreach ($managers as $key => $manager) {
    $bgc = ($key%2 == 0) ? '': 'bgc';
    $idManager = $manager->getIdUtilisateur();
    echo '<div class="vCenter '.$bgc.'">'.$manager->getNomUtilisateur().'</div>';
    $agents = UtilisateursManager::getList(null, ['idManager'=>$idManager]);
    $saisi = View_PointagesManager::getList(null, ['idManager'=>$idManager]);
    $valide = View_PointagesManager::getList(null, ['idManager'=>$idManager, 'validePointage'=>1]);
    $reporte = View_PointagesManager::getList(null, ['idManager'=>$idManager, 'reportePointage'=>1]);

    echo '<div class="vCenter '.$bgc.'">'.count($saisi).'/'.count($agents).'</div>';
    echo '<div class="vCenter '.$bgc.'">'.count($valide).'/'.count($agents).'</div>';
    echo '<div class="vCenter '.$bgc.'">'.count($reporte).'/'.count($agents).'</div>';
    echo '<div class="vCenter '.$bgc.'"><a class="'.$bgc.'" href="index.php?page=FormCentres&amp;mode=Afficher&amp;id=20"><i class="fas fa-file-contract"></i></a></div>';
    echo '<div class="cote "></div>';
    $nbReports += count($reporte);
    $totalAgents += count($agents);
}
echo '</section>';

// ********** DEUXIEME COLONNE **********
echo '<section class="section2">';
// ***** CAMEMBERT *****
$reportPourcentage = $nbReports * 100 / $totalAgents;
echo '<div class="camembert">';
echo '<input type="hidden" id="reporte" value='.$reportPourcentage.'>';
echo'<canvas id="chart" data-role="assistante"></canvas>';
echo '</div>';

// ***** LISTE RE-MODIF *****
echo '<div id="tabReModif">';
echo '<div class="vCenter gras">Date</div>';
echo '<div class="vCenter gras">Nom de l\'agent</div>';
echo '<div class="vCenter"></div>';

$logs = LogsManager::getList(['dateLog', 'idUtilisateur'], ['prisEnCompte'=>0],'dateLog');
foreach ($logs as $key => $log) {
    $bgc = ($key%2 == 0) ? '': 'bgc';
    $nomAgent = UtilisateursManager::getList(['nomUtilisateur'],['idUtilisateur' => $log->getIdUtilisateur()])[0]->getNomUtilisateur();
    echo '<div class="vCenter '.$bgc.'">'.texte($log->getDateLog()).'</div>';
    echo '<div class="vCenter '.$bgc.'">'.$nomAgent.'</div>';
    echo '<div class="vCenter '.$bgc.'"><a class="'.$bgc.'" href="index.php?page=FormCentres&amp;mode=Afficher&amp;id=20"><i class="fas fa-file-contract"></i></a></div>';
}
echo '</div>';
echo '</section>';
echo '<div class="cote"></div>';

// ********** FIN DEUXIEME COLONNE **********
echo '</main>';