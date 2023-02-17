<nav>
    <aside class="cote"></aside>
    <menu class="flex">
        <?php if ($roleConnecte >= 3) { ?>
        <div class="relative"><?= texte("Données administratives")?>
        <i class="fa-solid fa-angle-down"></i>
            <div class="sous-menu colonne">
                <a href='?page=ListeCentres'>
                    <div><?= texte("Centres")?></div>
                </a>
                <a href='?page=ListeConversions'>
                    <div><?= texte("Conversions")?></div>
                </a>
                <a href='?page=ListeFermetures'>
                    <div><?= texte("Fermetures")?></div>
                </a>
                <a href='?page=ListeUOs'>
                    <div><?= texte("Uos")?></div>
                </a>
            </div>
        </div>
        <a href='?page=ListeUtilisateurs'>
            <div><?= texte("Utilisateurs")?></div>
        </a>
        <div class="relative"><?= texte("Données pointages")?>
        <i class="fa-solid fa-angle-down"></i>
            <div class="sous-menu colonne">
                <a href='?page=ListeMotifs'>
                    <div><?= texte("Motifs")?></div>
                </a>
                <a href='?page=ListePrestations'>
                    <div><?= texte("Prestations")?></div>
                </a>
                <a href='?page=ListeProjets'>
                    <div><?= texte("Projets")?></div>
                </a>
                <a href='?page=ListeTypePrestations'>
                    <div><?= texte("TypePrestations")?></div>
                </a>
                <a href='?page=ListeActivites'>
                    <div><?= texte("Activites")?></div>
                </a>
            </div>
        </div>
        <?php } else if ($roleConnecte == 2) { ?>
        <?php } ?>
        <a href='?page=FormPointages'>
            <div><?= texte("Pointages")?></div>
        </a>
    </menu>
    <aside class="cote"></aside>
</nav>