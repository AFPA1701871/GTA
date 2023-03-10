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
$pointageVModif = View_PointagesManager::checkModif($idUtilisateur, $periode, "V");
$pointageRModif = View_PointagesManager::checkModif($idUtilisateur, $periode, "R");
/**********************Il faut vérifier sur tous les pointages cas des changements après validation ******************** */
if (!$listePointage) {
    $statut = "Indisponible";
} else {
    $statut = ($listePointage[0]->getValidePointage() == 1) ? "validé " . (($pointageVModif) ? "(modifié) " : "") : "";
    $statut .= ($listePointage[0]->getReportePointage() == 1) ? "reporté SIRH " . (($pointageRModif) ? "(modifié) " : "") : "";
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

$listeaffiche=["card1", "card2", "card3"];
$displTab = (!isset($_GET["display"]) || !in_array($_GET["display"],$listeaffiche))? "" : " noDisplay ";
$displCa1 = (isset($_GET["display"]) && $_GET["display"]=="card1")? "" : " noDisplay ";
$displCa2 = (isset($_GET["display"]) && $_GET["display"]=="card2")? "" : " noDisplay ";
$displCa3 = (isset($_GET["display"]) && $_GET["display"]=="card3")? "" : " noDisplay ";

echo '<section class="liensTemp">
<a href="index.php?page=Synthese&idUtilisateur='.$idUtilisateur.'&periode='.$periode.'">Tableau</a>
<a href="index.php?page=Synthese&idUtilisateur='.$idUtilisateur.'&periode='.$periode.'&display=card1">Cards V1</a>
<a href="index.php?page=Synthese&idUtilisateur='.$idUtilisateur.'&periode='.$periode.'&display=card2">Cards V2</a>
<a href="index.php?page=Synthese&idUtilisateur='.$idUtilisateur.'&periode='.$periode.'&display=card3">Cards V3</a>
</section>';

//////////////////////////////////////////
// Récapitulatif version tabbleau       //
//////////////////////////////////////////
echo '<div class="'.$displTab.'"><section>';
if (!$listePointage) {
    echo '<div class="vCenter gras">';
    if (isset($_GET['idUtilisateur']) && $_GET['idUtilisateur'] != "") {
        $message = 'Désolé, la synthèse de ' . $utilisateur->getNomUtilisateur() . ' pour cette période n\'est pas disponible. Veuillez choisir une autre date.';
    } else {
        $message = 'Veuillez choisir un utilisateur parmis la liste.';
    }
    echo $message;
    echo '</div>';
} else {
    // *** partie tableau agents ***

    echo '<div id="tabPointage">';
    echo '<div class="vCenter gras">Type de Prestation</div>';
    echo '<div class="vCenter gras">Prestation</div>';
    echo '<div class="vCenter gras">Code Projet</div>';
    echo '<div class="vCenter gras">UO de MAD</div>';
    echo '<div class="vCenter gras">Motif</div>';
    echo '<div class="vCenter gras">Nb Jours</div>';
    echo '<div class="vCenter gras">Pourcentage</div>';
    $joursAbs = 0;
    foreach ($listePointage as $key => $pointage) {
        $estModif = View_PointagesManager::checkModif($idUtilisateur, $periode, "R", true, $pointage->getIdTypePrestation(), $pointage->getCodePrestation(), $pointage->getIdProjet(), $pointage->getIdMotif(), $pointage->getIdUo_Pointage());
        $styleModif = "";
        if ($estModif) {
            $styleModif = " fa-red ";
        }
        $bgc = ($key % 2 == 0) ? '' : 'bgc';
        echo '<div class="vCenter ' . $bgc . '">' . $pointage->getNumeroTypePrestation() . '</div>';
        echo '<div class="vCenter ' . $bgc . '">' . $pointage->getCodePrestation() . '</div>';
        echo '<div class="vCenter ' . $bgc . '">' . $pointage->getCodeProjet() . '</div>';
        echo '<div class="vCenter ' . $bgc . '">' . $pointage->getNumeroUO() . '</div>';
        echo '<div class="vCenter ' . $bgc . '">' . $pointage->getCodeMotif() . '</div>';
        echo '<div class="vCenter ' . $styleModif . $bgc . '">' . $pointage->getNbHeuresPointage() . '</div>';
        if ($pointage->getNumeroTypePrestation() == 1) {
            $joursAbs = $pointage->getNbHeuresPointage();
            echo '<div class="vCenter ' . $bgc . '"></div>';
        } else {
            echo '<div class="vCenter ' . $styleModif . $bgc . '">' . (($joursOuvres - $joursAbs != 0) ? Round($pointage->getNbHeuresPointage() / ($joursOuvres - $joursAbs) * 100, 2) : 0) . '%</div>';
        }
    }
    echo '<div clas="NoDisplay" id=idUtilisateur data-value=' . $idUtilisateur . '></div>';
    echo '<div clas="NoDisplay" id=idPeriode data-value="' . $periode . '"></div>';
    echo '</div>';
    echo '</section></div>';

    //////////////////////////////////////////
    // Récapitulatif version carte V1       //
    //////////////////////////////////////////

    echo '<div class="'.$displCa1.'"><section class="cards">';
    foreach ($listePointage as $key => $pointage) {
        $estModif = View_PointagesManager::checkModif($idUtilisateur, $periode, "R", true, $pointage->getIdTypePrestation(), $pointage->getCodePrestation(), $pointage->getIdProjet(), $pointage->getIdMotif(), $pointage->getIdUo_Pointage());
        $styleModif = "";
        if ($estModif) {
            $styleModif = " modif ";
        }
        echo '
    
    <div class="card deuxCol ' . $styleModif . '">
        <div class="span-2"><div class="numerotation gras ' . $styleModif . '">' . str_pad(($key + 1), 2, "0", STR_PAD_LEFT) . '</div></div>
        <label class="gras">Type de Prestation</label>
        <div class="right">' . $pointage->getLibelleTypePrestation() . '</div>
        <label class="gras bgc">Prestation</label>
        <div class="right bgc">' . $pointage->getCodePrestation() . '</div>
        <label class="gras">Code Projet</label>
        <div class="right">' . $pointage->getCodeProjet() . '</div>
        <label class="gras bgc">UO de MAD</label>
        <div class="right bgc">' . $pointage->getNumeroUO() . '</div>
        <label class="gras">Motif</label>
        <div class="right">' . $pointage->getCodeMotif() . '</div>
        <label class="gras bgc">Nb Jours</label>
        <div class="right bgc">' . $pointage->getNbHeuresPointage() . '</div>
        <label class="gras">Pourcentage</label>';
        if ($pointage->getNumeroTypePrestation() == 1) {
            $joursAbs = $pointage->getNbHeuresPointage();
            echo '<div></div>';
        } else {
            echo '<div class="right">' . (($joursOuvres - $joursAbs != 0) ? Round($pointage->getNbHeuresPointage() / ($joursOuvres - $joursAbs) * 100, 2) : 0) . '%</div>';
        }
        echo '</div>
    ';
    }
    echo '</section></div>';

    //////////////////////////////////////////
    // Récapitulatif version carte V2       //
    //////////////////////////////////////////

    echo '<div class="'.$displCa2.'"><section class="cards">';
    foreach ($listePointage as $key => $pointage) {
        $estModif = View_PointagesManager::checkModif($idUtilisateur, $periode, "R", true, $pointage->getIdTypePrestation(), $pointage->getCodePrestation(), $pointage->getIdProjet(), $pointage->getIdMotif(), $pointage->getIdUo_Pointage());
        $styleModif = "";
        if ($estModif) {
            $styleModif = " modif ";
        }
        echo '
    
    <div class="card deuxCol ' . $styleModif . '">
        <div class="span-2"><div class="numerotation gras ' . $styleModif . '">' . str_pad(($key + 1), 2, "0", STR_PAD_LEFT) . '</div><div class="right gras">' . $pointage->getLibelleTypePrestation() . '</div></div>
        <label class="gras bgc line">Prestation</label>
        <label class="gras bgc right line">Code Projet</label>
        <div class="line">' . $pointage->getCodePrestation() . '</div>
        <div class="right line">' . $pointage->getCodeProjet() . '</div>
        <label class="gras bgc line">UO de MAD</label>
        <label class="gras bgc right line">Motif</label>
        <div class="line">' . $pointage->getNumeroUO() . '</div>
        <div class="right line">' . $pointage->getCodeMotif() . '</div>
        <label class="gras bgc line">Nb Jours</label>
        <label class="gras bgc right line">Pourcentage</label>
        <div class="line">' . $pointage->getNbHeuresPointage() . '</div>';
        if ($pointage->getNumeroTypePrestation() == 1) {
            $joursAbs = $pointage->getNbHeuresPointage();
            echo '<div class="line"></div>';
        } else {
            echo '<div class="right line">' . (($joursOuvres - $joursAbs != 0) ? Round($pointage->getNbHeuresPointage() / ($joursOuvres - $joursAbs) * 100, 2) : 0) . '%</div>';
        }
        echo '</div>
    ';
    }
    echo '</section></div>';
    //////////////////////////////////////////
    // Récapitulatif version carte V3       //
    //////////////////////////////////////////

    echo '<div class="'.$displCa3.'"><section class="cards">';
    foreach ($listePointage as $key => $pointage) {
        $estModif = View_PointagesManager::checkModif($idUtilisateur, $periode, "R", true, $pointage->getIdTypePrestation(), $pointage->getCodePrestation(), $pointage->getIdProjet(), $pointage->getIdMotif(), $pointage->getIdUo_Pointage());
        $styleModif = "";
        if ($estModif) {
            $styleModif = " modif ";
        }
        echo '

<div class="card3 deuxCol ' . $styleModif . '">
    <div class="span-2"><div class="numerotation gras ' . $styleModif . '">' . str_pad(($key + 1), 2, "0", STR_PAD_LEFT) . '</div><div class="right gras">' . $pointage->getLibelleTypePrestation() . '</div></div>
    
    <div class="innerCard"><label class="gras bgc line">Prestation</label>
    <div class=" line right">' . $pointage->getCodePrestation() . '</div></div>
    
    <div class="innerCard"><label class="gras bgc line">Code Projet</label>
    <div class=" line right">' . $pointage->getCodeProjet() . '</div></div>
    
    <div class="innerCard"><label class="gras bgc line">UO de MAD</label>
    <div class=" line right">' . $pointage->getNumeroUO() . '</div></div>
    
    <div class="innerCard"><label class="gras bgc line">Motif</label>
    <div class=" line right">' . $pointage->getCodeMotif() . '</div></div>
    
    <div class="innerCard"><label class="gras bgc line">Nb Jours</label>
    <div class=" line right">' . $pointage->getNbHeuresPointage() . '</div></div>
    
    <div class="innerCard"><label class="gras bgc line">Pourcentage</label><div class=" line right">';
        if ($pointage->getNumeroTypePrestation() == 1) {
            $joursAbs = $pointage->getNbHeuresPointage();
        } else {
            echo '' . (($joursOuvres - $joursAbs != 0) ? Round($pointage->getNbHeuresPointage() / ($joursOuvres - $joursAbs) * 100, 2) : 0) . '%';
        }
        echo '</div></div></div>
';
    }
    echo '</section></div>';

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
