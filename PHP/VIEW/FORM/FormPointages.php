<?php
global $mois;
global $joursSemaine;
$idUtilisateur =  (isset($_GET['idUtilisateur'])) ? $_GET['idUtilisateur'] : $_SESSION['utilisateur']->getIdUtilisateur();

$periode = (isset($_GET['periode'])) ? $_GET['periode'] : periodeEnCours($idUtilisateur, "Pointage");
// Preparation des données issus de l'idUtilisateur et de la période
$user = View_UtilisateursManager::getList(null, ["idUtilisateur" => $idUtilisateur])[0];
$periodeTab = explode("-", $periode);
$nbrJoursMois = cal_days_in_month(CAL_GREGORIAN, (int) $periodeTab[1], $periodeTab[0]);
$listeFermeturesDuMois = FermeturesManager::getDates($periode);
$tabJour = []; // contient pour chaque jour les classes et les contents à mettre sur l'entête et sur chaque ligne de prestation
// $tabJour["jourOuvert"] : pour déterminer si le jour est plié (exemple week-end) ou déplié
// $tabJour["classeBG"] : pour déterminer si le jour est gris ou pas
// $tabJour["content"] : pour déterminer le contenu des cases à l'intersection des lignes de prestations et des colonnes jours
// il fera l'objet d'un replace  quand on aura l'information du pointage
$typesPrestations = TypePrestationsManager::getList(null, null, "numeroTypePrestation", null, false, false);

// ENTETE de PAGE
echo '  <main>
            <div id=IdUtilisateur class="noDisplay">' . $idUtilisateur . '</div>
            <div class="cote"></div>
            <div>
            <div class="mainGrid grid-col2-reduct">
                <div class="grid-columns-span-2 center infosUser">
                    <div class=titreInfosUser>Année : </div>
                <div>';
echo            creerSelectTab($periode, tabMoisAnnee(), "periode", true, null);
echo '        </div>
              <div></div>
                <div class="titreInfosUser highlight">Nom : </div>
                <div class="highlight">' . $user->getNomUtilisateur() . '</div>
                <div></div>
                <div class=titreInfosUser>Matricule : </div>
                <div>' . $user->getMatriculeUtilisateur() . '</div>
                <div></div>
                <div class=titreInfosUser>Centre de rattachement :</div>
                <div>' . $user->getNomCentre() . '</div>
                <div></div>
                <div class=titreInfosUser>Uo d\'affectation : </div>
                <div>' . $user->getNumeroUo() . '</div>
                <div class="grid-columns-span-17 espace"></div>';
if ($roleConnecte >= 2) {
    echo '
                <div class="grid-columns-span-17 espace"><div></div><div class="mini"><a class="" href="?page=Synthese&idUtilisateur=' . $idUtilisateur . '&periode=' . $periode . '">Sa synthèse</a></div></div>
                <div class="grid-columns-span-17 espace"></div>';
}
echo '
            </div>';
// Entete de Prestations
echo '  <div class=" tabCol pointHead invisible trans  center">
<p>Changement sauvegardé</p><i class="fas fa-floppy-disk"></i>
</div>
        <div class="grid-pointage tabCol pointHead">
            <div class=" center grid-lineDouble bgc4">Total</div>
            <div class=" center grid-lineDouble bgc4 border-left">%GTA</div>
            <div class=" grid-lineDouble bgc4"></div>';
// Entete de jours    + préparation des cases de pointage         
$nbJourPointe = 0;
for ($i = 1; $i <= $nbrJoursMois; $i++) {
    //on crée la date au format DateTime
    $jour = (new Datetime())->setDate($periodeTab[0], $periodeTab[1], $i);

    // $jour->format('w') donne le jour dans la semaine 0 pour dimanche, 1 pour lundi
    if ($jour->format('w') == 0 || $jour->format('w') == 6) {
        $tabJour[$i]["jourOuvert"] = "";
        $tabJour[$i]["classeBG"] = "noWork";
        $tabJour[$i]["content"] = "";
        $tabJour[$i]["contentL1"] = "";
    } else {
        $tabJour[$i]["jourOuvert"] = $jour->format("d") . "<br/>" . $joursSemaine[$jour->format('w')];

        $condAbs["idTypePrestation"] = 1;
        $condAbs["idUtilisateur"] = $idUtilisateur;
        $condAbs["idPrestation"] = 1;
        $condAbs["datePointage"] = $jour->format("Y-m-d");
        $pointageAbs = PointagesManager::getList(null, $condAbs, null, null, false, false);

        if (in_array($jour->format("Y-m-d"), $listeFermeturesDuMois)) {
            $tabJour[$i]["classeBG"] = "notApplicable";
            $tabJour[$i]["content"] = "<input disabled class=' notApplicable inputPointage casePointage'>";
            $tabJour[$i]["contentL1"] = "<input disabled class=' notApplicable inputPointage casePointage'>";
        } else {
            $nbJourPointe++;
            if (($pointageAbs != null && $pointageAbs[0]->getNbHeuresPointage() == 1)) {
                $tabJour[$i]["classeBG"] = "notApplicable";
                $tabJour[$i]["contentL1"] = '<input data-date="' . $jour->format("Y-m-d") . '" data-line class="inputPointage casePointage  notApplicable" value type="text" idPointage >';
                $tabJour[$i]["content"] = '<input data-date="' . $jour->format("Y-m-d") . '" data-line class="inputPointage casePointage  notApplicable" type="text" idPointage disabled>';
            } else {
                $tabJour[$i]["classeBG"] = "work";
                $tabJour[$i]["content"] = '<input data-date="' . $jour->format("Y-m-d") . '" data-line class="inputPointage casePointage " value type="text" idPointage >';
                $tabJour[$i]["contentL1"] = '<input data-date="' . $jour->format("Y-m-d") . '" data-line class="inputPointage casePointage " value type="text" idPointage >';
            }
        }
    }
    echo '        <div data-date=' . $jour->format("Y-m-d") . ' data-somme=0 class="center grid-lineDouble  ' . $tabJour[$i]["classeBG"] . '">' . $tabJour[$i]["jourOuvert"] . '</div>';
}
echo '    </div>';
$numPresta = 0;
// Boucle sur les Types de Prestations
foreach ($typesPrestations as $key => $typePresta) {
    $iconeAjoutLigne = ($typePresta->getNumeroTypePrestation() != 1) ? '<i id="AjoutPresta1" class="fas fa-plus left-auto"></i>' : '';
    $idTypePrestation = $typePresta->getIdTypePrestation();
    echo '        <div class="center fullLine marginTopBottom left titreTypePrestation" data-idTypePrestation = ' . $idTypePrestation . '>' . $typePresta->getNumeroTypePrestation() . " - " . $typePresta->getLibelleTypePrestation() . ' ' . $iconeAjoutLigne . '</div>';
    echo '        <div class=" marginTopBottom titreTypePrestation ">&nbsp;</div>';

    // on récupère les prestations de ce type
    $listePrestation = View_Prestations_Pref_PointManager::getListePrestation($idUtilisateur, $periode, $idTypePrestation);
    // boucle sur les prestations
    foreach ($listePrestation as $prestation) {
        $numPresta++; // permet de numéroter les prestations
        $dataline = ' data-line="' . $numPresta . '"';
        // recherche si prestation fait parti des preferences 
        $cond = ["idUtilisateur" => $prestation->getIdUtilisateur(), "idTypePrestation" => $prestation->getIdTypePrestation(), "idPrestation" => $prestation->getIdPrestation()];

        if ($prestation->getIdUo() != null) $cond["idUo"] = $prestation->getIdUo();
        if ($prestation->getIdMotif() != null) $cond["idMotif"] = $prestation->getIdMotif();
        if ($prestation->getIdProjet() != null) $cond["idProjet"] = $prestation->getIdProjet();

        $pref = PreferencesManager::getList(null, $cond, null, null, false, false);
        $pref = ($pref != false) ? $pref[0] : new Preferences();
        $classFavorisActif = ($pref->getIdPreference() != null) ? 'favActive' : '';

        // Gestion de l'affichage de "Hors RTT" en rouge -> appelé 10 lignes plus bas
        $classRTT = ($idTypePrestation == 1) ? ' class="classRTT" ' : '';

        // 9 parties constituants la prestation
        echo '    <div class="grid-presta tabCol pointMove leftStickyRigth">
                    <input name="idTypePrestation" type=hidden value=' . $idTypePrestation . ' ' . $dataline . '>
              <div ' . $dataline . ' class="center grid-lineDouble grid-columns-span-2 prestaLine">
                  <div class="center grid-lineDouble  grid-columns-span-4">
                  <input type=hidden name=idPrestation value = "' . $prestation->getIdPrestation() . '" ' . $dataline . '>
                  <input type=hidden name=idPreference value = "' . $pref->getIdPreference() . '" ' . $dataline . '>';
        if (strlen($prestation->getLibellePrestation()) > 30) {
            echo '<textarea ' . $classRTT . ' disabled>' . $prestation->getLibellePrestation() . '</textarea>';
        } else {
            echo '<input value = "' . $prestation->getLibellePrestation() . '" ' . $classRTT . ' disabled>';
        }

        echo '
                      <div class="favorise vMini cellRight"><i class="fas fa-fav ' . $classFavorisActif . ' "></i></div>
                      <div class=" border-left expand-line vMini"><i class="fas fa-open" ' . $dataline . '></i></div>
                            </div>
                            <div class="center marginTopBottom cellCachable noDisplay cellRight ">Code Prest.</div>
                            <div class="center marginTopBottom cellCachable noDisplay cellRight">Uo de MAD</div>
                            <div class="center marginTopBottom cellCachable noDisplay cellRight">Code Motif</div>
                            <div class="center marginTopBottom cellCachable noDisplay cellRight">Code Projet</div>
                            <div class="center marginTopBottom cellCachable noDisplay cellRight"><input class="inputPointage" ' . $dataline . ' type="text" value = "' . $prestation->getCodePrestation() . '" disabled name=codePrestation></div>
                            <div class="center marginTopBottom cellCachable noDisplay cellRight work">';
        if ($typePresta->getUoRequis()) {
            // modifier la vue pour recupérer le libelle de l'Uo iden projet et motif
            echo '<input class="inputPointage" ' . $dataline . ' type="text" name="inputUo" value = "' . $prestation->getNumeroUo() . '" disabled title = "' . $prestation->getLibelleUo() . '">';
        } else {
            echo '<input class="inputPointage notApplicable" ' . $dataline . ' type="text" name="inputUo" disabled>';
        }
        echo '<input type=hidden name=idUo value = "' . $prestation->getIdUo() . '" ' . $dataline . '>';
        echo '  </div>
                <div class="center marginTopBottom cellCachable noDisplay  cellRight work">';
        if ($typePresta->getMotifRequis()) {
            echo '<input class="inputPointage" disabled ' . $dataline . ' type="text" name="inputMotif" value = "' . $prestation->getCodeMotif() . '" title="' . $prestation->getLibelleMotif() . '">';
        } else {
            echo '<input class="inputPointage notApplicable" ' . $dataline . ' type="text" name="inputMotif" disabled>';
        }
        echo '<input type=hidden name=idMotif value = "' . $prestation->getIdMotif() . '" ' . $dataline . '>';
        echo '  </div>
                <div class="center marginTopBottom cellCachable noDisplay  cellRight work">';
        if ($typePresta->getProjetRequis()) {
            echo '<input class="inputPointage" disabled ' . $dataline . ' type="text" name="inputProjet" value = "' . $prestation->getCodeProjet() . '" title="' . $prestation->getLibelleProjet() . '">';
        } else {
            echo '<input class="inputPointage notApplicable" ' . $dataline . ' type="text" name="inputProjet" disabled>';
        }
        echo '<input type=hidden name=idProjet value = "' . $prestation->getIdProjet() . '" ' . $dataline . '>';
        echo '</div>
                            </div>
            </div>';

        // Partie Pointage
        $conditions = [];
        $total = 0;
        // on prépare les conditions pour aller chercher le pointage 
        $conditions["idTypePrestation"] = $idTypePrestation;
        $conditions["idUtilisateur"] = $idUtilisateur;
        $conditions["idPrestation"] = $prestation->getIdPrestation();
        if ($prestation->getMotifRequis()) $conditions["idMotif"] = $prestation->getIdMotif();
        if ($prestation->getProjetRequis()) $conditions["idProjet"] = $prestation->getIdProjet();
        if ($prestation->getUoRequis()) $conditions["idUo"] = $prestation->getIdUo();
        $conditions["datePointage"] = $periode . "%";
        $pointages = PointagesManager::getList(null, $conditions, null, null, false, false);
        foreach ($pointages as $value) {
            $total += $value->getNbHeuresPointage();
        }
        echo '    <div class="grid-pointage tabCol pointMove">';
        echo '                <div class=" center grid-lineDouble colTotal" ' . $dataline . '>' . $total . '</div>';
        echo '                <div class=" center grid-lineDouble colPrctGTA border-left" ' . $dataline . '></div>';
        echo '                <div class=" grid-lineDouble"></div>';
        foreach ($tabJour as $i => $value) {
            $jour = (new Datetime())->setDate($periodeTab[0], $periodeTab[1], $i);

            $contentUsed = ($idTypePrestation == 1) ? $value['contentL1'] : $value['content'];

            $content = str_replace("data-line", $dataline, $contentUsed);
            $jour = (new Datetime())->setDate($periodeTab[0], $periodeTab[1], $i);
            $conditions["datePointage"] = $jour->format("Y-m-d");
            //echo json_encode($conditions);
            $pointage = PointagesManager::getList(null, $conditions, null, null, false, false);
            if ($pointage != false) {
                $content = str_replace("value", ' value="' . ($pointage[0]->getNbHeuresPointage() != 0 ? $pointage[0]->getNbHeuresPointage() : "") . '" ', $content);
                $content = str_replace("idPointage", ' data-idPointage="' . $pointage[0]->getIdPointage() . '" ', $content);
            }
            echo '        <div class="center grid-lineDouble  ' . $value["classeBG"] . '"  >' . $content . '</div>';
        }
        echo '</div>';
    }
}

// template pour reproduire la partie de gauche d'une ligne de pointage
// plusieurs parties feront l'objet d'un remplacement pour mettre les bonnes références (data-line, idtypePresttaion, ...)
// Certains input seront remplacés par des select
echo '<template id=lignePresta>
        <div class="grid-presta tabCol pointMove leftStickyRigth">
      <input name="idTypePrestation">
      <div dataline class="center grid-lineDouble grid-columns-span-2 prestaLine">
          <div class="center grid-lineDouble  grid-columns-span-4">
          <input name=idPrestation >
          <input type="hidden" name=idPreference dataline >
              <div class="favorise vMini cellRight"><i class="fas fa-fav"></i></div>
              <div class=" border-left expand-line vMini"><i class="fas fa-close" dataline ></i></div>
                    </div>
                    <div class="center marginTopBottom cellCachable noDisplay cellRight ">Code Prest.</div>
                    <div class="center marginTopBottom cellCachable noDisplay cellRight">Uo de MAD</div>
                    <div class="center marginTopBottom cellCachable noDisplay cellRight">Code Motif</div>
                    <div class="center marginTopBottom cellCachable noDisplay cellRight">Code Projet</div>
                    <div class="center marginTopBottom cellCachable noDisplay cellRight"><input class="inputPointage" dataline disabled type="text" name=codePrestation></div>
                    <div class="center marginTopBottom cellCachable noDisplay cellRight work">';

echo '      <input name="inputUo">
            </div>
            <div class="center marginTopBottom cellCachable noDisplay cellRight work">
                <input name="inputMotif">
            </div>
            <div class="center marginTopBottom cellCachable noDisplay cellRight work">
                <input name="inputProjet">
            </div>
        </div>
    </div>
</template>';
// pour retrouver le prochain numero de prestation en JS
echo '<input id=numPrestaMax type=hidden value=' . $numPresta . '>';
echo '</div></div><div class="cote"></main>';

// Div modale
echo '<div id="modale"></div>';
// Template de la Modale
echo '<template id="contentModale">
        <div class="cote"></div>
        <div class="lbContent center">    
            <div class="espace colSpan2"></div>
                <div class="noDisplay">
                    <input type="hidden" value=valueidtypepresta name="IdTypePrestation">
                </div>
                <label>Type de prestation :</label><Label class="gras">libelleTypePresta</label>

                <div class="espace colSpan2"></div>

                <fieldset>
                    <legend>Prestation :</legend>
                    <div class="center marginTopBottom">
                        <input id="searchPrestation" title="Entrer le mot à chercher puis cliquer sur le filtre" placeholder="Recherche...">
                        <i class="fa-solid fa-filter fa-margin" title="Entrer le mot à chercher puis cliquer sur le filtre"></i>
                    </div>
                    <div class="noDisplay">
                        <input type="hidden" valueIdPresta name="modalePrestation">
                    </div>
                    <div id="selectPrestation" class="marginTopBottom"></div>
                </fieldset>

                <div class="espace colSpan2"></div>

                <fieldset id="fldUo">
                    <legend>UO de MAD :</legend>
                    <div class="center marginTopBottom">
                        <input id="searchUo" title="Entrer le mot à chercher puis cliquer sur le filtre" placeholder="Recherche...">
                        <i class="fa-solid fa-filter fa-margin" title="Entrer le mot à chercher puis cliquer sur le filtre"></i>
                    </div>
                    <div class="noDisplay">
                        <input type="hidden" name="modaleUo">
                    </div>
                    <div id="selectUo" class="marginTopBottom"></div>
                </fieldset>

                <fieldset id="fldMotif">
                    <legend>Code Motif :</legend>
                    <div class="center marginTopBottom">
                        <input id="searchMotif" title="Entrer le mot à chercher puis cliquer sur le filtre" placeholder="Recherche...">
                        <i class="fa-solid fa-filter fa-margin" title="Entrer le mot à chercher puis cliquer sur le filtre"></i>
                    </div>
                    <div class="noDisplay">
                        <input type="hidden" name="modaleMotif">
                    </div>
                    <div id="selectMotif" class="marginTopBottom"></div>
                </fieldset>

                <fieldset id="fldProjet">
                    <legend>Code Projet :</legend>
                    <div class="center marginTopBottom">
                        <input id="searchProjet" title="Entrer le mot à chercher puis cliquer sur le filtre" placeholder="Recherche...">
                        <i class="fa-solid fa-filter fa-margin" title="Entrer le mot à chercher puis cliquer sur le filtre"></i>
                    </div>
                    <div class="noDisplay">
                        <input type="hidden" name="modaleProjet">
                    </div>
                    <div id="selectProjet" class="marginTopBottom"></div>
                </fieldset>

                <div class="espace colSpan2"></div>

                <div class="colSpan2 divBtnModale">
                    <button name="closeModale" type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button>
                    <button name="addModale" type="button" disabled><i class="fas fa-paper-plane"></i></button>
                </div>

                <div class="espace"></div>
            </div>
            <div class="cote"></div>
</template>';
