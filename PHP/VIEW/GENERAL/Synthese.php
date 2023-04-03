<?php

echo '<div class="bigEspace"></div>';
echo '<main class="flex ">';
$totalRempli = 0;
$totalValide = 0;
// ********** PREMIERE COLONNE **********
echo '<div class="cote"></div><div class=colonne>';
echo '<section class="colonne span3">';
//on récupère l'utilisateur
$idUtilisateur = (isset($_GET['idUtilisateur']) && $_GET['idUtilisateur'] != "") ? $_GET['idUtilisateur'] : $_SESSION['utilisateur']->getIdUtilisateur();
$utilisateur = UtilisateursManager::findById($idUtilisateur);
//on récupère la période
$periode = (isset($_GET['periode'])) ? $_GET['periode'] : periodeEnCours($idUtilisateur, "Valide");
//on récupère le nombre de jour ouvré
$joursOuvres = NbJourParPeriode($periode);
// On récupère la liste de tous les utilisateurs ayant complètement saisie la période
$syntheseManager = ($_SESSION['utilisateur']->getIdRole() != 3) ? $_SESSION['utilisateur']->getIdUtilisateur() : null;
$listeUtilisateursFiniPeriode = View_PointagesManager::getListSaisiesCompl($periode, $syntheseManager);
//var_dump($_SESSION);
//on récupère la liste du pointage
$listePointage = View_PointagesManager::getSomme($idUtilisateur, $periode);

/**********************Il faut vérifier sur tous les pointages cas des changements après validation ******************** */

if (!$listePointage) {
    $statut = "Indisponible";
} else {
    $vStatut = 0;
    $rStatut = 0;
    $indStatut = 0;
    do {
        $vStatut = MAX($vStatut, $listePointage[$indStatut]->getValidePointage());
        $rStatut = MAX($rStatut, $listePointage[$indStatut]->getReportePointage());
        $indStatut++;
    } while (($rStatut == 0 || $vStatut == 0) && $indStatut < count($listePointage));

    $statut = ($vStatut > 0) ? "validé " : "";
    $statut .= ($rStatut > 0) ? "reporté SIRH " : "";
    // $statut = ($listePointage[0]->getValidePointage() >0) ? "validé " : "";
    // $statut .= ($listePointage[0]->getReportePointage() >0) ? "reporté SIRH " : "";
}
// *** partie combobox mois/annee ***
echo '<div id="divComboDate" class="demi center">';
echo    creerSelectTab($periode, tabMoisAnnee(), 'periode', true);
echo '  <div class="mini"></div>
        <div class="center highlight">Utilisateur concerné : ' . creerSelectTab($utilisateur->getIdUtilisateur(), $listeUtilisateursFiniPeriode, "idUser", true, null, "Choisissez un utilisateur") . '</div>
        <div class="mini"></div>
        <div class="center highlight">Statut : ' . $statut . '</div>';
echo '</div>';
echo '</section><div class="cote"></div><div class="cote"></div>';

//////////////////////////////////////////
// Cas pas de pointages                 //
//////////////////////////////////////////

if (!$listePointage) {
    if (isset($_GET['idUtilisateur']) && $_GET['idUtilisateur'] != "") {
        $message = 'Désolé, la synthèse de ' . $utilisateur->getNomUtilisateur() . ' pour cette période n\'est pas disponible. Veuillez choisir une autre date.';
    } else {
        $message = 'Veuillez choisir un utilisateur parmis la liste.';
    }
    echo '  <section>
                <div class="vCenter gras">' . $message . '</div>
            </section>';
} else {
    //////////////////////////////////////////
    // Récapitulatif version carte V3       //
    //////////////////////////////////////////
    echo '<div clas="NoDisplay" id=idUtilisateur data-value=' . $idUtilisateur . '></div>';
    echo '<div clas="NoDisplay" id=idPeriode data-value="' . $periode . '"></div>';
    echo '<section class="cards">';
    $cardNum = 1;
    $joursAbs = 0;
    $modifAbsences = false;
    $totalPrct = 0;
    foreach ($listePointage as $key => $pointage) {
        $prct=0;
        $displayClass = " deuxCol ";
        if ($pointage->getNumeroTypePrestation() == 1) {
            // Mémorisation des heures d'absences
            $joursAbs = $pointage->getNbHeuresPointage();
            // On cache la carte des absences
            $displayClass = " noDisplay ";
            // Si modif du nombre de jours absents => modif des % sur toutes les prestations
            $modifAbsences = $roleConnecte >= 3 ? ($pointage->getReportePointage() != 2) : ($pointage->getValidePointage() != 2);
            // On décrémente le numéro de la carte pour rester correct
            $cardNum--;
        }
        // Calcul du %GTA de la prestation 
        if ($pointage->getNumeroTypePrestation() != 1) {
            $prct = (($joursOuvres - $joursAbs != 0) ? Round($pointage->getNbHeuresPointage() / ($joursOuvres - $joursAbs) * 100, 2) : 0);
            $totalPrct += $prct;
        }
        // Si 0, on n'affiche pas la carte
        if ($prct == 0) {
            $displayClass = " noDisplay ";
        }
        // Check, en fonction du rôle, si la prestation en cours contient des pointages non-validés/non-reportés
        $estModif = $roleConnecte >= 3 ? ($pointage->getReportePointage() != 2) : ($pointage->getValidePointage() != 2);
        // Changement de l'affichage de la prestation si présence de pointages pas reportés
        $styleModif = "";
        if ($estModif || $modifAbsences) {
            $styleModif = " modif ";
        }
        echo '
        <div class="card ' . $styleModif . $displayClass . '">
            <div class="span-2">
                <div class="numerotation gras ' . $styleModif . '">' . str_pad($cardNum, 2, "0", STR_PAD_LEFT) . '</div>
                <div class="right gras">' . $pointage->getLibelleTypePrestation() . '</div>
            </div>            
            <div class="innerCard">
                <label class="bgc line">UO de MAD</label>
                <div class=" line right gras">' . $pointage->getNumeroUO() . '</div>
            </div>
            <div class="innerCard">
                <label class="bgc line">Prestation</label>
                <div class=" line right gras">' . $pointage->getCodePrestation() . '</div>
            </div>            
            <div class="innerCard">
                <label class="bgc line">Code Projet</label>
                <div class=" line right gras">' . $pointage->getCodeProjet() . '</div>
            </div>            
            <div class="innerCard">
                <label class="bgc line">Motif</label>
                <div class=" line right gras">' . $pointage->getCodeMotif() . '</div>
            </div>            
            <div class="innerCard">
                <label class="bgc line">Pourcentage</label>
                <div class=" line right gras">' . $prct . '%</div>
            </div>
        </div>';
        $cardNum++;
    }
    echo '</section>
    <section class=" vCenter center"><div>Pourcentage total: ' . $totalPrct . '%</div></section>
    ';


    ///////////////////////////////////
    // Fin des différents affichages //
    ///////////////////////////////////

    // Autoriser les assistantes à valider un pointage avant de le reporter?
    //$contenu = ($roleConnecte == 2 || ($roleConnecte == 3 && $statut=="")) ? "Valider":"Reporter dans SIRH";
    $contenu = ($roleConnecte == 2) ? "Valider" : "Reporter dans SIRH";

    echo '<section class=" vCenter">
<div></div>
<button id=retour><i class="fas fa-house"></i>&nbsp;Retour</button><div></div>
<div></div>
<button id=valide><i class="fas fa-check fa-green"></i>&nbsp;' . $contenu . '</button>
<div></div>
</section>
</div>';
    echo '<div class="cote"></div>';
    echo '</main>';
}
