<?php
global $mois;
global $joursSemaine;
/* pour test */
$idUtilisateur = 1;
$user = View_UtilisateursManager::findById($idUtilisateur);

$anneeVisionne = date("Y");
$moisVisionne = date("m") * 1;
echo '<main>';
echo '<div class="cote"></div>';
echo '<div class="mainGrid grid-col2-reduct">';
echo '    <div class="grid-columns-span-2 center infosUser">';
echo '        <div>Année: </div>';
echo '        <div>';
echo creerSelectTab($anneeVisionne, Parametres::getAnneeDisponible(), null, "anneeVisionne", false);
echo '        </div>';
echo '        <div></div>';
echo '        <div>Mois:</div>';
echo '        <div>';
// A remplacer par mois en cours dès que disponible
echo creerSelectTab($mois[$moisVisionne], $mois, null, "moisVisionne", true);
echo '        </div>';
echo '        <div></div>';
echo '        <div>Nom:</div>';
echo '        <div>' . $user->getNomUtilisateur() . '</div>';
echo '        <div></div>';
echo '        <div>Matricule:</div>';
echo '        <div>' . $user->getMatriculeUtilisateur() . '</div>';
echo '        <div></div>';
echo '        <div>Centre de rattachement:</div>';
echo '        <div>XXXXX</div>';
// echo '        <div>'.$user->getCentreUtilisateur().'</div>';
echo '        <div></div>';
echo '        <div>UO d\'affectation:</div>';
echo '        <div>test' . $user->getNumeroUO() . '</div>';
echo '        <div class="grid-columns-span-17 espace"></div>';
echo '    </div>';

$nbrJoursMois = cal_days_in_month(CAL_GREGORIAN, $moisVisionne, $anneeVisionne);
$listeFermetures = FermeturesManager::getList(null, null, null, null, true);
if (sizeof($listeFermetures) != 0) {
    foreach ($listeFermetures as $fermeture) {
        $listeFermeturesDuMois[] = $fermeture['dateFermeture'];
    }
}
else
{
    $listeFermeturesDuMois[] = null;
}

echo '    <!--Séparation Prestations/Pointages => Zone Prestations -->';
echo '    <div class="grid-presta tabCol grid-5-reduct pointHead leftStickyRigth cellBottom"></div>';
echo '    <!--Séparation Prestations/Pointages => Zone Pointages -->';
echo '    <div class="grid-pointage tabCol pointHead">';

echo '        <!-- Lignes 9 et 10 -->';
echo '        <div class="cellBottom center grid-lineDouble bgc4">Total</div>';
echo '        <div class="cellBottom center grid-lineDouble bgc4">%GTA</div>';
echo '        <div class="cellBottom grid-lineDouble bgc4"></div>';
$nbJourPointe = 0;
for ($i = 1; $i <= $nbrJoursMois; $i++)
{
    //on crée la date au format DateTime
    $jour = (new Datetime())->setDate($anneeVisionne, $moisVisionne, $i);
    // $jour->format('w') donne le jour dans la semaine 0 pour dimanche, 1 pour lundi
    if ($jour->format('w') == 0 || $jour->format('w') == 6)
    {
        $jourOuvert = "";
        $classeBG = "noWork";
    }
    else
    {
        $nbJourPointe++;
        $jourOuvert = $jour->format("d") . "<br/>" . $joursSemaine[$jour->format('w')];
        if (in_array($jour, $listeFermeturesDuMois))
        {
            $classeBG = "notApplicable";
        }
        else
        {
            $classeBG = "work";
        }
    }
    echo '        <div data-date='.$jour->format("Y-m-d").' class="center grid-lineDouble cellBottom ' . $classeBG . '">' . $jourOuvert . '</div>';
}
echo '    </div>';
$typesPrestations = TypePrestationsManager::getList(null, null, "numeroTypePrestation", null, false, false);
foreach ($typesPrestations as $key => $value)
{

    echo '    <div class="grid-presta tabCol pointMove leftStickyRigth">';
    echo '        <!-- Titre -->';
    echo '        <div class="center grid-columns-span-2 fullLine grid-lineSimple cellBottom left titreTypePrestation">' . $value->getNumeroTypePrestation() . " - " . $value->getLibelleTypePrestation() . '<i id="AjoutPresta1" class="fas fa-plus plusRigth"></i></div>';
    echo '        <!-- Ligne -->';
    echo '                <div data-line="' . $value->getNumeroTypePrestation() . '-1" class="center grid-lineDouble cellBottom grid-columns-span-2 prestaLine">';
    echo '                    <div class="center grid-lineDouble cellBottom grid-columns-span-4">';
    echo '                        <select data-line="' . $value->getNumeroTypePrestation() . '-1">';
    echo '                            <option>Prestations de type 1</option>';
    echo '                        </select>';
    echo '                        <div class="favorise vMini cellRight"><i class="fas fa-fav"></i></div>';
    echo '                        <div class="expand-line vMini"><i class="fas fa-open" data-line="' . $value->getNumeroTypePrestation() . '-1"></i></div>';
    echo '                    </div>';
    echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Cde Prest.</div>';
    echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">UO de MAD</div>';
    echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Motif</div>';
    echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight">Code Projet</div>';
    echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight"><input class="inputPointage" data-line="' . $value->getNumeroTypePrestation() . '-1" type="text"></input></div>';
    echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="inputPointage" data-line="' . $value->getNumeroTypePrestation() . '-1" type="text"></input></div>';
    echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight notApplicable"></div>';
    echo '                    <div class="center grid-lineSimple colCachable noDisplay cellBottom cellRight work"><input class="inputPointage" data-line="' . $value->getNumeroTypePrestation() . '-1" type="text"></input></div>';
    echo '                </div>';
    echo '    </div>';

////////////////////////////////
    // Pointage

    echo '    <div class="grid-pointage tabCol pointMove">';
    echo '        <div class=" grid-lineSimple cellBottom titreTypePrestation grid-columns-span-31">&nbsp;</div>';
    echo '                <div class="cellBottom center grid-lineDouble colTotal" data-line="' . $value->getNumeroTypePrestation() . '-1">0</div>';
    echo '                <div class="cellBottom center grid-lineDouble" data-line="' . $value->getNumeroTypePrestation() . '-1"></div>';
    echo '                <div class="cellBottom grid-lineDouble"></div>';
    for ($i = 1; $i <= $nbrJoursMois; $i++)
    {
        //on crée la date au format DateTime
        $jour = (new Datetime())->setDate($anneeVisionne, $moisVisionne, $i);
        $content="";
        // $jour->format('w') donne le jour dans la semaine 0 pour dimanche, 1 pour lundi
        if ($jour->format('w') == 0 || $jour->format('w') == 6)
        {
            $jourOuvert = "";
            $classeBG = "noWork";
        }
        else
        {
            $nbJourPointe++;
            $jourOuvert = $jour->format("d") . "<br/>" . $joursSemaine[$jour->format('w')];
            if (in_array($jour, $listeFermeturesDuMois))
            {
                $classeBG = "notApplicable";
            }
            else
            {
                $classeBG = "work";
                $content = '<input data-date="'.$jour->format("Y-m-d").'" data-line="' . $value->getNumeroTypePrestation() . '-1" class="inputPointage casePointage" type="text"></input>';  }
        }
        echo '        <div class="center grid-lineDouble cellBottom ' . $classeBG . '"  >' . $content . '</div>';
    }

    echo '</div>';
}
echo '</div><div class="cote"></div></main>';
