/* Permet la mise à jour immédiate en base de données des modifications d'activitésliées au type de prestation*/

// Récupérer l'idTypePrestation dans l'url
var urlcourante = document.location.href;
var url = new URL(urlcourante);
var idTypePrestation = url.searchParams.get("id");

// Récupération des checkboxs
lesChecks = document.querySelectorAll(".removeShadow");

// Ajout de l'évènement
lesChecks.forEach((check) => {
    check.addEventListener("change", activitesTypesPrestations);
});

function activitesTypesPrestations(e) {
    check = e.target;

    // Récupération de l'idActivite
    idActivite = check.getAttribute("data-id");

    const requ = new XMLHttpRequest();
    if (check.checked == true) {
        // Action ajouter
        action = 0;
    } else {
        // action supprimer
        action = 1;
    }

    // AJAX
    requ.open("POST", "index.php?page=MAJActivitesParTypesAPI", true);
    requ.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    args = "mode=" + action + "&idActivite=" + idActivite + "&idTypePrestation=" + idTypePrestation;
    requ.send(args);
}
