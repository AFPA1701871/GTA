<body class="colonne">
    <header>
        <div class="cote"></div>
        <div>
            <div><a href="index.php?page=Default"><img src="./IMG/croissant.png" alt=""></a></div>
            <div class="">
                <?php
                if (isset($_SESSION['utilisateur'])) {
                    echo '<div class="center">' . texte('Bonjour') . " " . $_SESSION['utilisateur']->getNomUtilisateur() . '</div>';
                    echo '<div><a href="index.php?page=ActionDeconnexion" class="center">' . texte("Deconnexion") . '<i class="fas fa-disconnect"></i></a></div>';
                } 
                ?>

            </div>
        </div>

        <div class="cote"></div>
    </header>