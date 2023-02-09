<?php
if ($_POST['motDePasse'] == $_POST['confirmPassword']) {
    $adresseUsed = UtilisateursManager::getList(['adresseMail'],['adresseMail' => $_POST['adresseMail']]);
     if($adresseUsed == null){
        $u = new Utilisateurs($_POST);
        $u -> setRole(1);
        $u->setMotDePasse(crypte($u->getMotDePasse()));
        UtilisateursManager::add($u);
        $_SESSION['utilisateur'] = $u;
        header("location:index.php?page=Accueil");
     }
     else {
        header("location:index.php?page=Default");
    }
} else {
    header("location:index.php?page=Default");
}