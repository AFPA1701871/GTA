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
var_dump($listePointage);
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

//////////////////////////////////////////
// Cas pas de pointages                 //
//////////////////////////////////////////

if (!$listePointage) {
    echo '<section>';
    echo '<div class="vCenter gras">';
    if (isset($_GET['idUtilisateur']) && $_GET['idUtilisateur'] != "") {
        $message = 'Désolé, la synthèse de ' . $utilisateur->getNomUtilisateur() . ' pour cette période n\'est pas disponible. Veuillez choisir une autre date.';
    } else {
        $message = 'Veuillez choisir un utilisateur parmis la liste.';
    }
    echo $message;
    echo '</div></section>';
} else {
    //////////////////////////////////////////
    // Récapitulatif version carte V3       //
    //////////////////////////////////////////
    echo '<div clas="NoDisplay" id=idUtilisateur data-value=' . $idUtilisateur . '></div>';
    echo '<div clas="NoDisplay" id=idPeriode data-value="' . $periode . '"></div>';
    echo '<section class="cards">';
    $cardNum = 1;
    $joursAbs=0;
    foreach ($listePointage as $key => $pointage) {
        $displayClass = " deuxCol ";
        if ($pointage->getNumeroTypePrestation() == 1) {
            // Mémorisation des heures d'absences
            $joursAbs = $pointage->getNbHeuresPointage();
            // On cache la carte des absences
            $displayClass = " noDisplay ";
            // On décrémente le numéro de la carte pour rester correct
            $cardNum--;
        }
        // Calcul du %GTA de la prestation 
        $prct=(($joursOuvres - $joursAbs != 0) ? Round($pointage->getNbHeuresPointage() / ($joursOuvres - $joursAbs) * 100, 2) : 0);
        // Si 0, on n'affiche pas la carte
        if($prct==0){
            $displayClass = " noDisplay ";
        }
        // En fonction du rôle, check si la prestation a été modifié au niveau des validations (managers=> "V") ou des reports (assistantes => "R")
        $contCheckModif = $roleConnecte == 3 ? "R" : "V";
        $estModif = View_PointagesManager::checkModif($idUtilisateur, $periode, $contCheckModif, $pointage);
        // Changement de l'affichage de la prestation si présence de pointages pas reportés
        $styleModif = "";
        if ($estModif) {
            $styleModif = " modif ";
        }
        echo '

<div class="card ' . $styleModif . $displayClass . '">
    <div class="span-2"><div class="numerotation gras ' . $styleModif . '">' . str_pad($cardNum, 2, "0", STR_PAD_LEFT) . '</div><div class="right gras">' . $pointage->getLibelleTypePrestation() . '</div></div>
    
    <div class="innerCard"><label class="gras bgc line">UO de MAD</label>
    <div class=" line right">' . $pointage->getNumeroUO() . '</div></div>

    <div class="innerCard"><label class="gras bgc line">Prestation</label>
    <div class=" line right">' . $pointage->getCodePrestation() . '</div></div>
    
    <div class="innerCard"><label class="gras bgc line">Code Projet</label>
    <div class=" line right">' . $pointage->getCodeProjet() . '</div></div>
    
    
    <div class="innerCard"><label class="gras bgc line">Motif</label>
    <div class=" line right">' . $pointage->getCodeMotif() . '</div></div>
    
    <div class="innerCard"><label class="gras bgc line">Pourcentage</label><div class=" line right">';
        echo '' . $prct . '%';
        echo '</div></div></div>
';
        $cardNum++;
    }
    echo '</section>';

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
