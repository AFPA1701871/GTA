<?php
    
$uti =  UtilisateursManager::getList(null, ['mailUtilisateur' => $_POST['mailUtilisateur']]);
if ($uti != null) {
    if ($uti[0]->getPasswordUtilisateur() == crypte($_POST['passwordUtilisateur'])) {       
        echo 'connection reussie';
        $_SESSION['utilisateur'] = $uti[0];
        header("location:index.php?page=Accueil");
    } else {
        var_dump($uti[0]->getPasswordUtilisateur(),crypte($_POST['passwordUtilisateur']));
       // header("location:index.php?page=Default");
    }
} else {
    header("location:index.php?page=Default");
}