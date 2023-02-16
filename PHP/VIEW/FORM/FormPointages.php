<?php
global $mois;
global $joursSemaine;
/* pour test */
$idUtilisateur = 1;
$user = View_UtilisateursManager::getList(null,["idUtilisateur"=>$idUtilisateur])[0];

$anneeVisionne = date("Y");
$moisVisionne = date("m") * 1;
$periode = $anneeVisionne.'-0'.$moisVisionne;
echo '  <main>
            <div id=IdUtilisateur class="noDisplay">'.$idUtilisateur.'</div>
            <div class="cote"></div>
            <div>
            <div class="mainGrid grid-col2-reduct">
                <div class="grid-columns-span-2 center infosUser">
                    <div class=titreInfosUser>Année : </div>
                <div>';
echo creerSelectTab($periode, tabMoisAnnee(),null, "periode", true);
echo '        </div>
              <div></div>
                <div class=titreInfosUser>Nom : </div>
                <div>' . $user->getNomUtilisateur() . '</div>
                <div></div>
                <div class=titreInfosUser>Matricule : </div>
                <div>' . $user->getMatriculeUtilisateur() . '</div>
                <div></div>
                <div class=titreInfosUser>Centre de rattachement :</div>
                <div>' . $user->getNomCentre() . '</div>
                <div></div>
                <div class=titreInfosUser>UO d\'affectation : </div>
                <div>' . $user->getNumeroUO() . '</div>
                <div class="grid-columns-span-17 espace"></div>
            </div>';

$nbrJoursMois = cal_days_in_month(CAL_GREGORIAN, $moisVisionne, $anneeVisionne);
$listeFermeturesDuMois = FermeturesManager::getDates($moisVisionne);
echo '  <div class="grid-presta tabCol grid-5-reduct pointHead leftStickyRigth cellBottom"></div>
        <div class="grid-pointage tabCol pointHead">
            <div class="cellBottom center grid-lineDouble bgc4">Total</div>
            <div class="cellBottom center grid-lineDouble bgc4 border-left">%GTA</div>
            <div class="cellBottom grid-lineDouble bgc4"></div>';
$nbJourPointe = 0;
$tabJour = [];
for ($i = 1; $i <= $nbrJoursMois; $i++)
{
    //on crée la date au format DateTime
    $jour = (new Datetime())->setDate($anneeVisionne, $moisVisionne, $i);

    // $jour->format('w') donne le jour dans la semaine 0 pour dimanche, 1 pour lundi
    if ($jour->format('w') == 0 || $jour->format('w') == 6)
    {
        $tabJour[$i]["jourOuvert"] = "";
        $tabJour[$i]["classeBG"] = "noWork";
        $tabJour[$i]["content"] = "";
    }
    else
    {
        $nbJourPointe++;
        $tabJour[$i]["jourOuvert"] = $jour->format("d") . "<br/>" . $joursSemaine[$jour->format('w')];
        if (in_array($jour->format("Y-m-d"), $listeFermeturesDuMois))
        {
            $tabJour[$i]["classeBG"] = "notApplicable";
            $tabJour[$i]["content"] = "<input disabled class=' notApplicable inputPointage casePointage'>";
        }
        else
        {
            $tabJour[$i]["classeBG"] = "work";
            $tabJour[$i]["content"] = '<input data-date="' . $jour->format("Y-m-d") . '" data-line class="inputPointage casePointage case" value type="text">';
        }
    }
    echo '        <div data-date='.$jour->format("Y-m-d").' class="center grid-lineDouble cellBottom ' . $tabJour[$i]["classeBG"] . '">' . $tabJour[$i]["jourOuvert"] . '</div>';
}
echo '    </div>';
$typesPrestations = TypePrestationsManager::getList(null, null, "numeroTypePrestation", null, false, false);
foreach ($typesPrestations as $key => $typePresta)
{
    echo '        <div class="center fullLine grid-lineSimple cellBottom left titreTypePrestation">' . $typePresta->getNumeroTypePrestation() . " - " . $typePresta->getLibelleTypePrestation() . '<i id="AjoutPresta1" class="fas fa-plus plusRigth"></i></div>';
    echo '        <div class=" grid-lineSimple cellBottom titreTypePrestation ">&nbsp;</div>';

    // remplacer par periode en cours
    $listePrestation = View_Prestations_Pref_PointManager::getListePrestation($idUtilisateur, $anneeVisionne . "-0" . $moisVisionne, $typePresta->getIdTypePrestation());
    $numPresta = 0;
    foreach ($listePrestation as $prestation)
    {
        $numPresta++;
        echo '    <div class="grid-presta tabCol pointMove leftStickyRigth">
              <div data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '" class="center grid-lineDouble cellBottom grid-columns-span-2 prestaLine">
                  <div class="center grid-lineDouble cellBottom grid-columns-span-4">
                  <input type=hidden name=idPrestation value = "' . $prestation->getIdPrestation() . '" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '">
                  <input value = "' . $prestation->getLibellePrestation() . '" >
                      <div class="favorise vMini cellRight"><i class="fas fa-fav"></i></div>
                      <div class=" border-left expand-line vMini"><i class="fas fa-open" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '"></i></div>
                            </div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Cde Prest.</div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">UO de MAD</div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Motif</div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Projet</div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight"><input class="inputPointage" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '" type="text" value = "' . $prestation->getCodePrestation() . '"></div>
                            <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work">';
        if ($typePresta->getUORequis())
        {
            echo '<input class="inputPointage" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '" type="text" name="inputUo" value = "' . $prestation->getNumeroUO() . '">';
        }
        else
        {
            echo '<input class="inputPointage notApplicable" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '" type="text" name="inputUo" disabled>';
        }

        echo '  </div>
                <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work">';
        if ($typePresta->getMotifRequis())
        {
            echo '<input class="inputPointage" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '" type="text" name="inputMotif" value = "' . $prestation->getCodeMotif() . '">';
        }
        else
        {
            echo '<input class="inputPointage notApplicable" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '" type="text" name="inputMotif" disabled>';
        }

        echo '  </div>
                <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work">';
        if ($typePresta->getProjetRequis())
        {
            echo '<input class="inputPointage" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '" type="text" name="inputProjet" value = "' . $prestation->getCodeProjet() . '">';
        }
        else
        {
            echo '<input class="inputPointage notApplicable" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '" type="text" name="inputProjet"disabled>';
        }

        echo '</div>
                            </div>
            </div>';

////////////////////////////////
        // Pointage

        echo '    <div class="grid-pointage tabCol pointMove">';
        echo '                <div class="cellBottom center grid-lineDouble colTotal" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '">0</div>';
        echo '                <div class="cellBottom center grid-lineDouble border-left colPrctGTA" data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '"></div>';
        echo '                <div class="cellBottom grid-lineDouble"></div>';
        foreach ($tabJour as $i=>$value)
        {
            $jour = (new Datetime())->setDate($anneeVisionne, $moisVisionne, $i);
            $content = str_replace("data-line", 'data-line="' . $typePresta->getNumeroTypePrestation() . '-' . $numPresta . '" ', $value['content']);$jour = (new Datetime())->setDate($anneeVisionne, $moisVisionne, $i);
            $pointage = PointagesManager::getList(null,["idTypePrestation"=>$typePresta->getIdTypePrestation(),"idUtilisateur"=>$idUtilisateur,"idPrestation"=>$prestation->getIdPrestation(),"datePointage"=>$jour->format("Y-m-d")],null,null,false,false);
            if ($pointage!=false) 
                $content = str_replace("value",' value="'.$pointage[0]->getNbHeuresPointage().'" ',$content);
            echo '        <div class="center grid-lineDouble cellBottom ' . $value["classeBG"] . '"  >' . $content . '</div>';
        }
        echo '</div>';
    }
}
echo '</div></div><div class="cote"></main>';
