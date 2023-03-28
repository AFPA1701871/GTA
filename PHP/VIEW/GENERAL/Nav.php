<?php
echo '
<nav>
    <aside class="cote"></aside>
    <menu class="flex">';
if ($roleConnecte >= 3) {
    echo '<div class="relative center">' . texte("Données administratives") . '<i class="fa-solid fa-angle-down fa-margin"></i>
    <div class="sous-menu colonne">
        <a href="?page=ListeCentres"><div>' . texte("Centres") . '</div></a>
        <a href="?page=ListeFermetures"><div>' . texte("Fermetures") . '</div></a>
        <a href="?page=ListeUos"><div>' . texte("Uos") . '</div></a>
    </div>
</div>
<div class="relative center">' . texte("Données pointages") . '<i class="fa-solid fa-angle-down fa-margin"></i>
    <div class="sous-menu colonne">
        <a href="?page=ListeUtilisateurs"><div>' . texte("Utilisateurs") . '</div></a>
        <a href="?page=ListeMotifs"><div>' . texte("Motifs") . '</div></a>
        <a href="?page=ListePrestations"><div>' . texte("Prestations") . '</div></a>
        <a href="?page=ListeProjets"><div>' . texte("Projets") . '</div></a>
        <a href="?page=ListeTypePrestations"><div>' . texte("TypePrestations") . '</div></a>
        <a href="?page=ListeActivites"><div>' . texte("Activites") . '</div></a>
    </div>
</div>';
    if ($roleConnecte == 3) {
        echo '<div class="relative center">' . texte("Recaps") . '<i class="fa-solid fa-angle-down fa-margin"></i>
            <div class="sous-menu colonne"><a href="?page=TbAssistante"><div>'.texte("TableauBord").'</div></a><a href="?page=Synthese"><div>'.texte("Syntheses").'</div></a></div></div>';
    } else {
        echo '<div class="relative center">' . texte("TableauBord") . '<i class="fa-solid fa-angle-down fa-margin"></i>
    <div class="sous-menu colonne">
        <a href="?page=TbAssistante"><div>' . texte("TbAssistante") . '</div></a>
        <a href="?page=TbManager"><div>' . texte("TbManager") . '</div></a>
        <a href="?page=ActionMail"><div>' . texte("Envoi Mail test") . '</div></a>
        <a href="?page=Synthese"><div>' . texte("Syntheses") . '</div></a>
    </div>
</div>';
    }
} else if ($roleConnecte == 2) {
    echo '<a href="?page=TbManager" class=center><div>' . texte("TableauBord") . '</div></a>';
}
echo '<a href="?page=FormPointages" class=center><div>' . texte("Pointage") . '</div></a>
    </menu>
    <aside class="cote"></aside>
</nav>';
