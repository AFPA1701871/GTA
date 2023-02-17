<?php
echo '<div class="bigEspace"></div>';
echo '<main>';

// ********** PRMIERE COLONNE **********
echo '<div class="cote"></div>';
echo '<section class="section1">';
$idManager = $_SESSION['utilisateur']->getIdUtilisateur();
$agents = UtilisateursManager::getList(['idUtilisateur','nomUtilisateur'], ['idRole'=>1, 'idManager'=>$idManager], 'nomUtilisateur');

    // partie combobox mois/annee
    // echo '<div id="divComboDate">';
    //     foreach ($agents as $key => $agent) {
    //         $pointages = PointagesManager::getList(null, ['idUtilisateur'=>$agent->getIdUtilisateur(), 'datePointage'=>])
    //     }
    //     $date = new DateTime();
    //     $date = moisPrecedent($date);
    //     echo creerSelectTab($date, tabMoisAnnee(), 'comboDate', true, null);
    echo '</div>';

    // partie tableau agents
    echo '<div id="tabAgents">';
        echo '<div class="vCenter gras">Nom de l\'agent</div>';
        echo '<div class="vCenter gras">Rempli à</div>';
        echo '<div class="vCenter gras">Statut</div>';
        echo '<div class="cote"></div>';


        foreach ($agents as $key => $agent) {
            $bgc = ($key%2 == 0) ? '': 'bgc';
            $idAgent = $agent->getIdUtilisateur();
            echo '<div class="vCenter '.$bgc.'">'.$agent->getNomUtilisateur().'</div>';
            echo '<div class="vCenter '.$bgc.'"></div>';
            echo '<div class="vCenter '.$bgc.'"></div>';
            echo '<div class="cote"></div>';
        }
    echo '</div>';
echo '</section>';

// ********** DEUXIEME COLONNE **********
echo '<section class="section2">';

    // ***** CAMEMBERT 1*****
    echo '<div class="camembert">';
    echo '<input type="hidden" id="" value=33>';
    echo'<canvas id="chart" data-role="manager"></canvas>';
    echo '</div>';

    // ***** CAMEMBERT 2*****
    echo '<div class="camembert">';
    echo '<input type="hidden" id="" value=50>';
    echo'<canvas id="chart" data-role="manager"></canvas>';
    echo '</div>';

// ********** FIN DEUXIEME COLONNE **********
echo '</section>';
echo '</main>';