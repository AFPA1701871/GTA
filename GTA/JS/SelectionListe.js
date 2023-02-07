/* Repérer la page et la classe correspondante */

var urlcourante = document.location.href;
var url = new URL(urlcourante);
var page = url.searchParams.get("page");
var classe = page.substring(5);
var manager = classe + "Manager";
var selection = {};

/* Limite de données en fonction du profil  et de la page */

switch (page) {
    /* Exemple: 
    case "ListeUtilisateurs":
        selection.actif = "1";
        break;
    case "ListeOffres":
        selection.idCentre = centreUser;
        break;*/
    default:
        console.log(selection);
        break;

}

