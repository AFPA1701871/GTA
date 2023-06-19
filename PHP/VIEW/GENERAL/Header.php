 <?php
 $entite = isset($_SESSION['entite'])?$_SESSION["entite"]:"";
 $libEntite = $entite!=0 && $entite!=""?EntitesManager::findbyId($entite)->getLibelleEntite():"";
 echo '<body class="colonne">
    <header>
        <div class="cote"></div>
        <div>

            <div class=wrapperlogo>
                <a class=logo href="index.php?page='.
                (isset($_SESSION['utilisateur']) && $nom != 'ChangePassword' ? 'Accueil' : ($nom == 'ChangePassword' && empty($_GET['src']) ? 'ChangePassword' : (isset($_GET['src']) ? 'Accueil' : 'Default'))).'">
                <img src="./IMG/LogoGTA_blanc.png" alt="">
               <div class="colonne"> <div class="titre">GTA</div>'.$libEntite.'</div>
            </a></div>
            <div class="">';
               
                if (isset($_SESSION['utilisateur'])) {
                    echo '<input type=hidden id=idEntite value='.$entite.'>';
                   
                    echo '<div class="center demi">' . texte('Bonjour') . " " . $_SESSION['utilisateur']->getNomUtilisateur() . '</div>';
                    if (($nom == 'ChangePassword' && !empty($_GET['src'])) || $nom != 'ChangePassword')
                    {
                        echo '<div class=demi><a href="?page=ChangePassword&src=accueil" class="center"><p>Mot de passe</p><i class="fas fa-lock-open fa-margin"></i></a></div>';
                    }
                    echo '<div class=demi><a href="index.php?page=ActionConnexion&mode=logout" class="center">' . texte("Deconnexion") . '<i class="fas fa-disconnect fa-margin"></i></a></div>';
                }
                ?>
            <div class='mini left-auto'>
            
                <div class="darkmode">
                <input type="checkbox" class="checkbox" id="checkbox">
                <label for="checkbox" class="label">
                    <i class="fas fa-moon"></i>
                    <i class='fas fa-sun'></i>
                    <div class='ball'>
                </label>
            </div>
            </div>
            
            </div>
            
        </div>
        </div>
        <div class="cote"></div>
    </header>
