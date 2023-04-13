<?php
$mode = isset($_GET["mode"]) ? $_GET["mode"] : "login";
switch ($mode)
{
    case 'login':
        $uti = UtilisateursManager::getList(null, ['matriculeUtilisateur' => $_POST['matriculeUtilisateur']]);
        if ($uti != null)
        {
            $uti = $uti[0];
            if ($uti->getPasswordUtilisateur() == crypte($_POST['passwordUtilisateur']))
            {
                echo 'connection reussie';
                if($uti->getIdRole()==4){
                    $uti->setIdRole(2);
                }
                $_SESSION['utilisateur'] = $uti;
                /* On vérifie qu'il ne s'agit pas du mot de passe par défaut  */
                if (crypte($_POST['passwordUtilisateur']) == crypte(passwordDefault($uti)))
                {
                    conn_log("première connexion", $uti->toString());
                    header("location: index.php?page=ChangePassword");
                }
                else
                {
                    conn_log("connexion réussie", $uti->toString());
                    header("location:index.php?page=Accueil");
                }
            }
            else
            {
                echo '<main class=center><h3>La connexion a échouée</h3></main>';
                conn_log("connexion échouée", $uti->toString());
                header("refresh:3;url=index.php?page=Default");
            }
        }
        else
        {
            echo '<main class=center><h3>La connexion a échouée</h3></main>';
            conn_log("l'utilisateur n'existe pas", $_POST["matriculeUtilisateur"]);
            header("refresh:3;url=index.php?page=Default");
        }
        break;
    case 'logout':
        session_destroy();
        header("location: index.php?page=Connexion");
        break;
    case 'change':
        $uti = $_SESSION['utilisateur'];
        $uti->setPasswordUtilisateur(crypte($_POST["passwordUtilisateur"]));
        UtilisateursManager::update($uti);
        header("location: index.php?page=Accueil");
        break;
}

function conn_log($texte, $uti)
{
    $ligne = date('Y-m-d H:i:s') . "\t" . $texte . "\t" . $uti . PHP_EOL;

    /* ouverture du fichier de log, le mode "a+" permet d'écrire à la fin */
    if ($fp = fopen("./LOG/Connexion.log", "a+"))
    {
        /* écriture de la ligne à concurrence de 1024 caractères */
        fwrite($fp, $ligne, 1024);
        /* fermeture du fichier */
        fclose($fp);
    }
}
