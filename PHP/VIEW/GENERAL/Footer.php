<footer class="center">
    <div class="cote"></div>
    <div class="center">
        <a class="easter" href="?page=Easter"></a>
        <p>Fait par les stagiaires de la promotion CDA 2022/2023 de Martine Poix.</p>
        <div id="backToTop"><i class="fa-solid fa-square-caret-up fa-2x"></i></div>
    </div>
    <div class="cote"></div>
</footer>
<?php
echo ' <script src="./JS/script.js"></script>';
if (isset($page)) {
    preg_match("/Liste|Form/", $page[1], $matches);
    if ($matches != null) {
        if ($matches[0] == "Liste") {
            //    <script src="./JS/FiltresListe.js"></script>
            echo '  
            <script src="./JS/Tri.js"></script>
            <script src="./JS/SelectionListe.js"></script>
            <script src="./JS/Filtre.js"></script>
            <script src="./JS/Pagination.js"></script>
            ';
        } else if ($matches[0] == "Form") {
            echo '<script src="./JS/VerifForm.js"></script>';
            if ($page[1] == "FormTypePrestations" && $_GET["mode"] == "Modifier") {
                echo '<script src="./JS/CheckActivites.js"></script>';
            }
            echo ' <script src="./JS/pointage.js"></script>';
        } 
    }
    switch ($page[1]) {
        case "ChangePassword":
            echo '<script src="./JS/VerifFormMdp.js"></script>';
            break;
        case 'Accueil':
            echo ' <script src="./JS/pointage.js"></script>';
            break;
    }
}
echo '</body>
</html>';
