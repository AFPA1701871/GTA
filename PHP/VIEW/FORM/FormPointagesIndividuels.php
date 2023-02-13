<?php

echo '<main>';
echo '<div class="cote"></div>';
echo '<div class="mainGrid grid-col2-reduct">';
echo '    <div class="grid-columns-span-2 center infosUser">';
echo '        <div>Année: </div>';
echo '        <div>';
echo '            <select id="anneeVisionne">';
echo '                <option value="2020">2020</option>';
echo '                <option value="2021">2021</option>';
echo '                <option value="2022">2022</option>';
echo '                <option value="2023" selected>2023</option>';
echo '            </select>';
echo '        </div>';
echo '        <div></div>';
echo '        <div>Mois:</div>';
echo '        <div>';
echo '          <select id="moisVisionne">';
echo '              <option value="01">Janvier</option>';
echo '              <option value="02" selected>Février</option>';
echo '              <option value="03">Mars</option>';
echo '              <option value="04">Avril</option>';
echo '              <option value="05">Mai</option>';
echo '              <option value="06">Juin</option>';
echo '              <option value="07">Juillet</option>';
echo '              <option value="08">Aout</option>';
echo '              <option value="09">Septembre</option>';
echo '              <option value="10">Octobre</option>';
echo '              <option value="11">Novembre</option>';
echo '              <option value="12">Décembre</option>';
echo '          </select>';
echo '        </div>';
echo '        <div></div>';
echo '        <div>Nom:</div>';
echo '        <div>Joe Smith</div>';
echo '        <div></div>';
echo '        <div>Matricule:</div>';
echo '        <div>XXXXXXX</div>';
echo '        <div></div>';
echo '        <div>Centre de rattachement:</div>';
echo '        <div>XXXXX</div>';
echo '        <div></div>';
echo '        <div>UO d\'affectation:</div>';
echo '        <div>XXX</div>';
echo '        <div class="grid-columns-span-17 espace"></div>';
echo '    </div>';

$anneeVisionne = 2023;
$moisVisionne = 02;
$joursSemaine = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];
$nbrJoursMois = cal_days_in_month(CAL_GREGORIAN, $moisVisionne, $anneeVisionne);
$listeFermetures = FermeturesManager::getList(null, ["dateFermeture" => $anneeVisionne . "-" . str_pad($moisVisionne, 2, "0", STR_PAD_LEFT) . "-%"], null, null, true);
if (sizeof($listeFermetures) != 0) {
    foreach ($listeFermetures as $fermeture) {
        $listeFermeturesDuMois[] = $fermeture['dateFermeture'];
    }
}else{
    $listeFermeturesDuMois[]=null;
}

echo '    <!--Séparation Prestations/Pointages => Zone Prestations -->';
echo '    <div class="grid-presta tabCol grid-5-reduct pointHead bgc4 leftStickyRigth cellBottom">';
echo '      <div id="anneeSelected" class="noDisplay">2023</div>';
echo '      <div id="moisSelected" class="noDisplay">02</div>';
echo '    </div>';
echo '    <!--Séparation Prestations/Pointages => Zone Pointages -->';
echo '    <div class="grid-pointage tabCol pointHead">';

echo '        <!-- Lignes 9 et 10 -->';
echo '        <div class="cellBottom center grid-lineDouble bgc4">Total</div>';
echo '        <div class="cellBottom center grid-lineDouble bgc4">%GTA</div>';
echo '        <div class="cellBottom grid-lineDouble bgc4"></div>';

for ($jour = 1; $jour <= $nbrJoursMois; $jour++) {
    $jourString = $anneeVisionne . "-" . str_pad($moisVisionne, 2, "0", STR_PAD_LEFT) . "-" . str_pad($jour, 2, "0", STR_PAD_LEFT);
    $jourActu = mktime(0, 0, 0, $moisVisionne, $jour, $anneeVisionne);
    if (getdate($jourActu)['wday'] == 0 || getdate($jourActu)['wday'] == 6) {
        $jourOuvert = "";
        $classeBG = "noWork";
    } elseif (in_array($jourString, $listeFermeturesDuMois)) {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "notApplicable";
    } else {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "work";
    }
    echo '        <div class="center grid-lineDouble cellBottom ' . $classeBG . '">' . $jourOuvert . '</div>';
}
echo '    </div>';
echo '    <div class="grid-presta tabCol pointMove leftStickyRigth">';
echo '                <!--------------------------->';
echo '                <!-- Absences              -->';
echo '                <!--------------------------->';

echo '                <div class="center grid-columns-span-2 fullLine grid-lineSimple cellBottom left titreTypePrestation">0 - Congés, Fériés et absences</div>';
echo '                <!-- Ligne -->';
echo '                <div class="center grid-columns-span-2 fullLine grid-lineSimple cellBottom left">Nb jours absences&nbsp;<small id="info">ne pas saisir les absences RTT</small></div>';
echo '        <!--------------------------->';
echo '        <!-- Prestations de type 1 -->';
echo '        <!--------------------------->';
echo '        <!-- Titre -->';
echo '        <div class="center grid-columns-span-2 fullLine grid-lineSimple cellBottom left titreTypePrestation">1 - Activité de production<i id="AjoutPresta1" class="fas fa-plus plusRigth"></i></div>';
echo '        <!-- Ligne -->';
echo '                <div data-line="1-1" class="center grid-lineDouble cellBottom grid-columns-span-2 prestaLine">';
echo '                    <div class="center grid-lineDouble cellBottom grid-columns-span-4">';
echo '                        <select data-line="1-1">';
echo '                            <option>Prestations de type 1</option>';
echo '                        </select>';
echo '                        <div class="favorise vMini cellRight"><i class="fas fa-fav"></i></div>';
echo '                        <div class="expand-line vMini"><i class="fas fa-open" data-line="1-1"></i></div>';
echo '                    </div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Cde Prest.</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">UO de MAD</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Motif</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Projet</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight"><input class="casePointage" data-line="1-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="1-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight notApplicable"></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="1-1" type="text"></input></div>';
echo '                </div>';

echo '        <!--------------------------->';
echo '        <!-- Prestations de type 2 -->';
echo '        <!--------------------------->';
echo '        <!-- Titre -->';
echo '        <div class="center grid-columns-span-2 fullLine grid-lineSimple cellBottom left titreTypePrestation">2 - Missions Nationales de Service Public<i id="AjoutPresta2" class="fas fa-plus plusRigth"></i></div>';
echo '        <!-- Ligne -->';
echo '                <div data-line="2-1" class="center cellBottom grid-columns-span-2 prestaLine">';
echo '                    <div class="center grid-lineDouble cellBottom grid-columns-span-4">';
echo '                        <select data-line="2-1">';
echo '                            <option>Prestations de type 2</option>';
echo '                        </select>';
echo '                        <div class="favorise vMini cellRight"><i class="fas fa-fav"></i></div>';
echo '                        <div class="expand-line vMini"><i class="fas fa-open" data-line="2-1"></i></div>';
echo '                    </div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Cde Prest.</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">UO de MAD</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Motif</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Projet</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight"><input class="casePointage" data-line="2-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="2-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight notApplicable"></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="2-1" type="text"></input></div>';
echo '                </div>';

echo '        <!--------------------------->';
echo '        <!-- Prestations de type 3 -->';
echo '        <!--------------------------->';
echo '        <!-- Titre -->';
echo '        <div class="center grid-columns-span-2 fullLine grid-lineSimple cellBottom left titreTypePrestation">3 - Perfectionnement<i id="AjoutPresta3" class="fas fa-plus plusRigth"></i></div>';
echo '        <!-- Ligne -->';
echo '                <div data-line="3-1" class="center cellBottom grid-columns-span-2 prestaLine">';
echo '                    <div class="center grid-lineDouble cellBottom grid-columns-span-4">';
echo '                        <select data-line="3-1">';
echo '                            <option>Prestations de type 3</option>';
echo '                        </select>';
echo '                        <div class="favorise vMini cellRight"><i class="fas fa-fav"></i></div>';
echo '                        <div class="expand-line vMini"><i class="fas fa-open" data-line="3-1"></i></div>';
echo '                    </div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Cde Prest.</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">UO de MAD</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Motif</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Projet</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight"><input class="casePointage" data-line="3-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight notApplicable"></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="3-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="3-1" type="text"></input></div>';
echo '                </div>';
echo '        <!--------------------------->';
echo '        <!-- Prestations de type 4 -->';
echo '        <!--------------------------->';
echo '        <!-- Titre -->';
echo '        <div class="center grid-columns-span-2 fullLine grid-lineSimple cellBottom left titreTypePrestation">4 - Mandat<i id="AjoutPresta4" class="fas fa-plus plusRigth"></i></div>';
echo '        <!-- Ligne -->';
echo '                <div data-line="4-1" class="center cellBottom grid-columns-span-2 prestaLine">';
echo '                    <div class="center grid-lineDouble cellBottom grid-columns-span-4">';
echo '                        <select data-line="4-1">';
echo '                            <option>Prestations de type 4</option>';
echo '                        </select>';
echo '                        <div class="favorise vMini cellRight"><i class="fas fa-fav"></i></div>';
echo '                        <div class="expand-line vMini"><i class="fas fa-open" data-line="4-1"></i></div>';
echo '                    </div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Cde Prest.</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">UO de MAD</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Motif</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Projet</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight"><input class="casePointage" data-line="4-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="4-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="4-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight notApplicable"></div>';
echo '                </div>';
echo '        <!--------------------------->';
echo '        <!-- Prestations de type 5 -->';
echo '        <!--------------------------->';
echo '        <!-- Titre -->';
echo '        <div class="center grid-columns-span-2 fullLine grid-lineSimple cellBottom left titreTypePrestation">5 - Autres activités de support<i id="AjoutPresta5" class="fas fa-plus plusRigth"></i></div>';
echo '        <!-- Ligne -->';
echo '                <div data-line="5-1" class="center cellBottom grid-columns-span-2 prestaLine">';
echo '                    <div class="center grid-lineDouble cellBottom grid-columns-span-4">';
echo '                        <select data-line="5-1">';
echo '                            <option>Prestations de type 5</option>';
echo '                        </select>';
echo '                        <div class="favorise vMini cellRight"><i class="fas fa-fav"></i></div>';
echo '                        <div class="expand-line vMini"><i class="fas fa-open" data-line="5-1"></i></div>';
echo '                    </div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Cde Prest.</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">UO de MAD</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Motif</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Projet</div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight"><input class="casePointage" data-line="5-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="5-1" type="text"></input></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight notApplicable"></div>';
echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="casePointage" data-line="5-1" type="text"></input></div>';
echo '                </div>';
echo '    </div>';

////////////////////////////////
// Pointage

echo '    <div class="grid-pointage tabCol pointMove">';
echo '        <div class=" grid-lineSimple cellBottom titreTypePrestation">&nbsp;</div>';
echo '                <div class="cellBottom center grid-lineSimple">0</div>';
echo '                <div class="cellBottom center grid-lineSimple"></div>';
echo '                <div class="cellBottom grid-lineSimple"></div>';
for ($jour = 1; $jour <= $nbrJoursMois; $jour++) {
    $jourString = $anneeVisionne . "-" . str_pad($moisVisionne, 2, "0", STR_PAD_LEFT) . "-" . str_pad($jour, 2, "0", STR_PAD_LEFT);
    $jourActu = mktime(0, 0, 0, $moisVisionne, $jour, $anneeVisionne);
    if (getdate($jourActu)['wday'] == 0 || getdate($jourActu)['wday'] == 6) {
        $jourOuvert = "";
        $classeBG = "noWork";
        $content = "";
    } elseif (in_array($jourString, $listeFermeturesDuMois)) {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "notApplicable";
        $content = "1";
    } else {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "work";
        $content = '<input class="casePointage" type="text"></input>';
    }
    echo '        <div class="center grid-lineSimple cellBottom ' . $classeBG . '">' . $content . '</div>';
}

echo '                <div class=" grid-lineSimple cellBottom titreTypePrestation">&nbsp;</div>';

echo '        <div data-line="1-1" class="cellBottom center grid-lineDouble">0,00</div>';
echo '        <div data-line="1-1" class="cellBottom center grid-lineDouble">0,0%</div>';
echo '        <div data-line="1-1" class="cellBottom grid-lineDouble"></div>';
for ($jour = 1; $jour <= $nbrJoursMois; $jour++) {
    $jourString = $anneeVisionne . "-" . str_pad($moisVisionne, 2, "0", STR_PAD_LEFT) . "-" . str_pad($jour, 2, "0", STR_PAD_LEFT);
    $jourActu = mktime(0, 0, 0, $moisVisionne, $jour, $anneeVisionne);
    if (getdate($jourActu)['wday'] == 0 || getdate($jourActu)['wday'] == 6) {
        $jourOuvert = "";
        $classeBG = "noWork";
        $content = "";
    } elseif (in_array($jourString, $listeFermeturesDuMois)) {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "notApplicable";
        $content = "";
    } else {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "work";
        $content = '<input data-line="1-1" data-date="'.$jourString.'" class="casePointage" type="text"></input>';
    }
    echo '        <div data-line="1-1" class="center grid-lineDouble cellBottom ' . $classeBG . '">' . $content . '</div>';
}

echo '        <div class=" grid-lineSimple titreTypePrestation cellBottom">&nbsp;</div>';

echo '        <div data-line="2-1" class="cellBottom center grid-lineDouble">0,00</div>';
echo '        <div data-line="2-1" class="cellBottom center grid-lineDouble">0,0%</div>';
echo '        <div data-line="2-1" class="cellBottom grid-lineDouble"></div>';
for ($jour = 1; $jour <= $nbrJoursMois; $jour++) {
    $jourString = $anneeVisionne . "-" . str_pad($moisVisionne, 2, "0", STR_PAD_LEFT) . "-" . str_pad($jour, 2, "0", STR_PAD_LEFT);
    $jourActu = mktime(0, 0, 0, $moisVisionne, $jour, $anneeVisionne);
    if (getdate($jourActu)['wday'] == 0 || getdate($jourActu)['wday'] == 6) {
        $jourOuvert = "";
        $classeBG = "noWork";
        $content = "";
    } elseif (in_array($jourString, $listeFermeturesDuMois)) {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "notApplicable";
        $content = "";
    } else {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "work";
        $content = '<input data-line="2-1" data-date="'.$jourString.'" class="casePointage" type="text"></input>';
    }
    echo '        <div data-line="2-1" class="center grid-lineDouble cellBottom ' . $classeBG . '">' . $content . '</div>';
}

echo '        <div class=" titreTypePrestation grid-lineSimple cellBottom">&nbsp;</div>';

echo '        <div data-line="3-1" class="cellBottom center grid-lineDouble">0,00</div>';
echo '        <div data-line="3-1" class="cellBottom center grid-lineDouble">0,0%</div>';
echo '        <div data-line="3-1" class="cellBottom grid-lineDouble"></div>';
for ($jour = 1; $jour <= $nbrJoursMois; $jour++) {
    $jourString = $anneeVisionne . "-" . str_pad($moisVisionne, 2, "0", STR_PAD_LEFT) . "-" . str_pad($jour, 2, "0", STR_PAD_LEFT);
    $jourActu = mktime(0, 0, 0, $moisVisionne, $jour, $anneeVisionne);
    if (getdate($jourActu)['wday'] == 0 || getdate($jourActu)['wday'] == 6) {
        $jourOuvert = "";
        $classeBG = "noWork";
        $content = "";
    } elseif (in_array($jourString, $listeFermeturesDuMois)) {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "notApplicable";
        $content = "";
    } else {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "work";
        $content = '<input data-line="3-1" data-date="'.$jourString.'" class="casePointage" type="text"></input>';
    }
    echo '        <div data-line="3-1" class="center grid-lineDouble cellBottom ' . $classeBG . '">' . $content . '</div>';
}

echo '        <div class=" grid-lineSimple titreTypePrestation cellBottom">&nbsp;</div>';

echo '        <div data-line="4-1" class="cellBottom center grid-lineDouble">0,00</div>';
echo '        <div data-line="4-1" class="cellBottom center grid-lineDouble">0,0%</div>';
echo '        <div data-line="4-1" class="cellBottom grid-lineDouble"></div>';
for ($jour = 1; $jour <= $nbrJoursMois; $jour++) {
    $jourString = $anneeVisionne . "-" . str_pad($moisVisionne, 2, "0", STR_PAD_LEFT) . "-" . str_pad($jour, 2, "0", STR_PAD_LEFT);
    $jourActu = mktime(0, 0, 0, $moisVisionne, $jour, $anneeVisionne);
    if (getdate($jourActu)['wday'] == 0 || getdate($jourActu)['wday'] == 6) {
        $jourOuvert = "";
        $classeBG = "noWork";
        $content = "";
    } elseif (in_array($jourString, $listeFermeturesDuMois)) {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "notApplicable";
        $content = "";
    } else {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "work";
        $content = '<input data-line="4-1" data-date="'.$jourString.'" class="casePointage" type="text"></input>';
    }
    echo '        <div data-line="4-1" class="center grid-lineDouble cellBottom ' . $classeBG . '">' . $content . '</div>';
}

echo '        <div class=" titreTypePrestation grid-lineSimple cellBottom">&nbsp;</div>';

echo '        <div data-line="5-1" class="cellBottom center grid-lineDouble">0,00</div>';
echo '        <div data-line="5-1" class="cellBottom center grid-lineDouble">0,0%</div>';
echo '        <div data-line="5-1" class="cellBottom grid-lineDouble"></div>';
for ($jour = 1; $jour <= $nbrJoursMois; $jour++) {
    $jourString = $anneeVisionne . "-" . str_pad($moisVisionne, 2, "0", STR_PAD_LEFT) . "-" . str_pad($jour, 2, "0", STR_PAD_LEFT);
    $jourActu = mktime(0, 0, 0, $moisVisionne, $jour, $anneeVisionne);
    if (getdate($jourActu)['wday'] == 0 || getdate($jourActu)['wday'] == 6) {
        $jourOuvert = "";
        $classeBG = "noWork";
        $content = "";
    } elseif (in_array($jourString, $listeFermeturesDuMois)) {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "notApplicable";
        $content = "";
    } else {
        $jourOuvert = $jour . "<br/>" . $joursSemaine[getdate($jourActu)['wday']];
        $classeBG = "work";
        $content = '<input data-line="5-1" data-date="'.$jourString.'" class="casePointage" type="text"></input>';
    }
    echo '        <div data-line="5-1" class="center grid-lineDouble cellBottom ' . $classeBG . '">' . $content . '</div>';
}
echo '    </div>';
echo '</div>';
echo '<div class="cote"></div></main>';
