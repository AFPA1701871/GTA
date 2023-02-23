<?php
global $mois;
global $joursSemaine;
$idUtilisateur =  (isset($_GET['idUtilisateur']))?$_GET['idUtilisateur']:$_SESSION['utilisateur']->getIdUtilisateur();

$periode = (isset($_GET['periode']))?$_GET['periode']:periodeEnCours($idUtilisateur,"Pointage");
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
                <div class="grid-columns-span-17 espace"></div>
            </div>';
// Entete de Prestations
echo '  <div class="grid-presta tabCol pointHead  cellBottom trans alert center">
<p>Changement sauveguardé</p><i class="fas fa-floppy-disk"></i>
</div>
        <div class="grid-pointage tabCol pointHead">
            <div class="cellBottom center grid-lineDouble bgc4">Total</div>
            <div class="cellBottom center grid-lineDouble bgc4 border-left">%GTA</div>
            <div class="cellBottom grid-lineDouble bgc4"></div>';
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
    } else {
        $tabJour[$i]["jourOuvert"] = $jour->format("d") . "<br/>" . $joursSemaine[$jour->format('w')];
        if (in_array($jour->format("Y-m-d"), $listeFermeturesDuMois)) {
            $tabJour[$i]["classeBG"] = "notApplicable";
            $tabJour[$i]["content"] = "<input disabled class=' notApplicable inputPointage casePointage'>";
        } else {
            $nbJourPointe++;
            $tabJour[$i]["classeBG"] = "work";
            $tabJour[$i]["content"] = '<input data-date="' . $jour->format("Y-m-d") . '" data-line class="inputPointage casePointage case" value type="text" idPointage >';
        }
    }
    echo '        <div data-date=' . $jour->format("Y-m-d") . ' class="center grid-lineDouble cellBottom ' . $tabJour[$i]["classeBG"] . '">' . $tabJour[$i]["jourOuvert"] . '</div>';
}
echo '    </div>';
$numPresta = 0;
// Boucle sur les Types de Prestations
foreach ($typesPrestations as $key => $typePresta) {
    $idTypePrestation = $typePresta->getIdTypePrestation();
    echo '        <div class="center fullLine grid-lineSimple cellBottom left titreTypePrestation" data-idTypePrestation = ' . $idTypePrestation . '>' . $typePresta->getNumeroTypePrestation() . " - " . $typePresta->getLibelleTypePrestation() . '<i id="AjoutPresta1" class="fas fa-plus plusRigth"></i></div>';
    echo '        <div class=" grid-lineSimple cellBottom titreTypePrestation ">&nbsp;</div>';

    // on récupère les prestations de ce type
    $listePrestation = View_Prestations_Pref_PointManager::getListePrestation($idUtilisateur, $periode, $idTypePrestation);
    
    // boucle sur les prestations
    foreach ($listePrestation as $prestation) {
        $numPresta++; // permet de numéroter les prestations
        $dataline = ' data-line="' . $numPresta . '"';
        // recherche si prestation fait parti des preferences 
        $cond =["idUtilisateur"=>$prestation->getIdUtilisateur(),"idTypePrestation"=>$prestation->getIdTypePrestation(),"idPrestation"=>$prestation->getIdPrestation()];
        if ($prestation->getIdUo()!=null) $cond["idUo"]=$prestation->getIdUo();
        if ($prestation->getIdMotif()!=null) $cond["idMotif"]=$prestation->getIdMotif();
        if ($prestation->getIdProjet()!=null) $cond["idProjet"]=$prestation->getIdProjet();
        $pref = PreferencesManager::getList(null,$cond);
        $classFavorisActif=(count($pref)>0 && $pref[0]->getIdPreference()!=null)?'favActive':'';
        // 9 parties constituants la prestation
        echo '    <div class="grid-presta tabCol pointMove leftStickyRigth">
                    <input name="idTypePrestation" type=hidden value=' . $idTypePrestation . ' ' . $dataline . '>
              <div ' . $dataline . ' class="center grid-lineDouble cellBottom grid-columns-span-2 prestaLine">
                  <div class="center grid-lineDouble cellBottom grid-columns-span-4">
                  <input type=hidden name=idPrestation value = "' . $prestation->getIdPrestation() . '" ' . $dataline . '>
                  <input type=hidden name=idPreference value = "' . $prestation->getIdPreference() . '" ' . $dataline . '>
                  <input value = "' . $prestation->getLibellePrestation() . '" disabled>
                      <div class="favorise vMini cellRight"><i class="fas fa-fav '.$classFavorisActif.' "></i></div>
                      <div class=" border-left expand-line vMini"><i class="fas fa-open" ' . $dataline . '></i></div>
                            </div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight ">Code Prest.</div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Uo de MAD</div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Motif</div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Projet</div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight"><input class="inputPointage" ' . $dataline . ' type="text" value = "' . $prestation->getCodePrestation() . '" disabled name=codePrestation></div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work">';
        if ($typePresta->getUoRequis()) { 
            // modifier la vue pour recupérer le libelle de l'Uo iden projet et motif
            echo '<input class="inputPointage" ' . $dataline . ' type="text" name="inputUo" value = "' . $prestation->getNumeroUo() . '" disabled title = "' . $prestation->getLibelleUo() . '">';
        } else {
            echo '<input class="inputPointage notApplicable" ' . $dataline . ' type="text" name="inputUo" disabled>';
        }
        echo '<input type=hidden name=idUo value = "' . $prestation->getIdUo() . '" ' . $dataline . '>';
        echo '  </div>
                <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work">';
        if ($typePresta->getMotifRequis()) {
            echo '<input class="inputPointage" disabled ' . $dataline . ' type="text" name="inputMotif" value = "' . $prestation->getCodeMotif() . '" title="' . $prestation->getLibelleMotif() . '">';
        } else {
            echo '<input class="inputPointage notApplicable" ' . $dataline . ' type="text" name="inputMotif" disabled>';
        }
        echo '<input type=hidden name=idMotif value = "' . $prestation->getIdMotif() . '" ' . $dataline . '>';
        echo '  </div>
                <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work">';
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

        echo '    <div class="grid-pointage tabCol pointMove">';
        echo '                <div class="cellBottom center grid-lineDouble colTotal" ' . $dataline . '>0</div>';
        echo '                <div class="cellBottom center grid-lineDouble colPrctGTA border-left" ' . $dataline . '></div>';
        echo '                <div class="cellBottom grid-lineDouble"></div>';
        foreach ($tabJour as $i => $value) {
            $conditions=[];
            $jour = (new Datetime())->setDate($periodeTab[0], $periodeTab[1], $i);
            $content = str_replace("data-line", $dataline, $value['content']);
            $jour = (new Datetime())->setDate($periodeTab[0], $periodeTab[1], $i);
            // on prépare les conditions pour aller chercher le pointage 
            $conditions["idTypePrestation"] = $idTypePrestation;
            $conditions["idUtilisateur"] = $idUtilisateur;
            $conditions["idPrestation"] = $prestation->getIdPrestation();
            $conditions["datePointage"] = $jour->format("Y-m-d");
            if ($prestation->getMotifRequis() && $prestation->getIdMotif()!=null) $conditions["idMotif"] = $prestation->getIdMotif();
            if ($prestation->getProjetRequis() && $prestation->getIdProjet()!=null) $conditions["idProjet"] = $prestation->getIdProjet();
            if ($prestation->getUoRequis() && $prestation->getIdUo()!=null) $conditions["idUo"] = $prestation->getIdUo();
            $pointage = PointagesManager::getList(null, $conditions, null, null, false, false);
            if ($pointage != false) {
                $content = str_replace("value", ' value="' . $pointage[0]->getNbHeuresPointage() . '" ', $content);
                $content = str_replace("idPointage", ' data-idPointage="' . $pointage[0]->getIdPointage() . '" ', $content);
            }
            echo '        <div class="center grid-lineDouble cellBottom ' . $value["classeBG"] . '"  >' . $content . '</div>';
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
      <div dataline class="center grid-lineDouble cellBottom grid-columns-span-2 prestaLine">
          <div class="center grid-lineDouble cellBottom grid-columns-span-4">
          <input name=idPrestation >
          <input type="hidden" name=idPreference dataline >
              <div class="favorise vMini cellRight"><i class="fas fa-fav"></i></div>
              <div class=" border-left expand-line vMini"><i class="fas fa-close" dataline ></i></div>
                    </div>
                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight ">Code Prest.</div>
                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Uo de MAD</div>
                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Motif</div>
                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Projet</div>
                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight"><input class="inputPointage" dataline disabled type="text" name=codePrestation></div>
                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work">';

echo '      <input name="inputUo">
            </div>
            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work">
                <input name="inputMotif">
            </div>
            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work">
                <input name="inputProjet">
            </div>
        </div>
    </div>
</template>';
// pour retrouver le prochain numero de prestation en JS
echo '<input id=numPrestaMax type=hidden value=' . $numPresta . '>';
echo '</div></div><div class="cote"></main>';
