<?php
echo '<div class="bigEspace"></div>';
echo '<main>';

// ********** PRMIERE COLONNE **********
echo '<div class="cote"></div>';
echo '<section id="tabManager">';
echo '<div class="vCenter gras">Nom de l\'agent</div>';
echo '<div class="vCenter gras">Rempli à</div>';
echo '<div class="vCenter gras">Statut</div>';
echo '<div class="cote"></div>';
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
echo '</main>';