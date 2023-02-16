<body class="colonne">
    <header>
        <div class="cote"></div>
        <div>

            <div><a class=logo href="index.php?page=Accueil"><img src="./IMG/LogoGTA_blanc.png" alt=""><p class="titre">GTA</p></a></div>
            <div class="">
                <?php
                if (isset($_SESSION['utilisateur'])) {
                    echo '<div class="center demi">' . texte('Bonjour') . " " . $_SESSION['utilisateur']->getNomUtilisateur() . '</div>';
                    echo '<div class=demi><a href="?page=ChangePassword&src=accueil" class="center"><p>Mot de passe</p><i class="fas fa-lock-open"></i></a></div>';
                    echo '<div class=demi><a href="index.php?page=ActionConnexion&mode=logout" class="center">' . texte("Deconnexion") . '<i class="fas fa-disconnect"></i></a></div>';
                }
                ?>
           <div class=mini>
            
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
