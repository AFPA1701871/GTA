<footer class="center">
    <div class="cote"></div>
    <div class="center">
        <a class="easter" href="?page=Easter"><img src="./IMG/death-star.svg" alt=""></a>
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
            if ($page[1] != "FormPointages")
            {
                echo '<script src="./JS/VerifForm.js"></script>';
            }
            if ($page[1] == "FormTypePrestations" && $_GET["mode"] == "Modifier") {
                echo '<script src="./JS/CheckActivites.js"></script>';
            }
            if ($page[1] == "FormPointages" ) {
                echo '<script src="./JS/CrudPointage.js"></script>';
                echo ' <script src="./JS/Pointage.js"></script>';
            }
        } 
    }
    switch ($page[1]) {
        case "ChangePassword":
            echo '<script src="./JS/VerifFormMdp.js"></script>';
            break;
        case "TbAssistante":
            echo '<script src="./JS/Chart.js"></script>';
            echo '<script src="./JS/CreateChartTB.js"></script>';
            break;
        case "TbManager":
            echo '<script src="./JS/Chart.js"></script>';
            echo '<script src="./JS/CreateChartTB.js"></script>';
            break;
        case 'ListeFermetures':
            echo '<script src="./JS/JoursFeries.js"></script>';
            break;
    }
}
echo '</body>
</html>';
