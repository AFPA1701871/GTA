<?php
echo '<div class="bigEspace"></div>';
echo '<main>';

// ********** PRMIERE COLONNE **********
echo '<div class="cote"></div>';
echo '<section class="section1">';
$idManager = $_SESSION['utilisateur']->getIdUtilisateur();
$agents = UtilisateursManager::getList(['idUtilisateur','nomUtilisateur'], ['idRole'=>1, 'idManager'=>$idManager], 'nomUtilisateur');
$periode = new DateTime();
$periode = moisPrecedent($periode);

    // *** partie combobox mois/annee ***
    echo '<div id="divComboDate">';
        // si dans le mois precedent, il y a au moins un pointage non validé, on affiche le pointage du mois precedent
        $pointagesNonValide = View_PointagesManager::getList(null, ['idManager'=>$idManager, 'periode'=>$periode, 'validePointage'=>0], 'nomUtilisateur');
        if (empty($pointagesNonValide)){
            $periode = new DateTime();
            $periode = $periode->format('Y-m');
            echo creerSelectTab($periode, tabMoisAnnee(), 'comboDate', true);
        }
        // sinon on affiche le mois en cours
        else echo creerSelectTab($periode, tabMoisAnnee(), 'comboDate', true);
    echo '</div>';

    // *** partie tableau agents ***
    $joursOuvres = getNbJoursOuvres($periode);
    echo '<div id="tabAgents">';
        echo '<div class="vCenter gras">Nom de l\'agent</div>';
        echo '<div class="vCenter gras">Rempli à</div>';
        echo '<div class="vCenter gras">Statut</div>';
        echo '<div class="cote"></div>';

        foreach ($agents as $key => $agent) {
            $idAgent = $agent->getIdUtilisateur();
            $pointages = View_PointagesManager::getList(['nbHeuresPointage'], ['periode'=>$periode, 'idUtilisateur'=>$idAgent]);
            foreach ($pointages as $key => $pointage) {
                var_dump($pointage);
            }
            $bgc = ($key%2 == 0) ? '': 'bgc';
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