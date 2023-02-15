// permet de filtrer le résultat sur une recherche full texte
filtre = document.getElementsByName("filtre")[0];
if (filtre != undefined)
    filtre.addEventListener("change", function () {
        AfficherPage(pageActive, true);
    });

function stringCondition() {
    if (filtre != undefined && filtre.value != "")
        return filtre.value;
    return "";
}

/*********************GESTION DES FILTRES TEXTE **********************/

var recherche = document.querySelector('#searchInList');
if (recherche != undefined) {
    recherche.addEventListener("blur", RechercheFullTexte);
}

/********************* FONCTIONS **********************/
function RechercheFullTexte() {
    arrayConditions.fullTexte = recherche.value;
    AfficherPage(pageActive, true);
}

