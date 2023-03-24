/** Gestion de la fenetre modale qui s'affiche lors de l'ajout d prestation à la feuille de pointage **/

var modale = document.getElementById("modale");

// Gestions des champs Uo, Motif et Projet
// Liste d'objets correspondants aux champs, avec:
// - "champ" le nom du champ/table, 
// - "besoin" indiquant si ce champ est demandé pour ce type de prestation et
// - "colonnes" un tableau listant les colonnes qui seront demandées lors de l'appel ajax
var listSubFields = [
    { champ: "Uo", besoin: 0, colonnes: ["NumeroUo", "LibelleUo"] },
    { champ: "Motif", besoin: 0, colonnes: ["CodeMotif", "LibelleMotif"] },
    { champ: "Projet", besoin: 0, colonnes: ["CodeProjet", "LibelleProjet"] }
];

// Association des noms des champs à leur position dans le tableau listSubField
const UO = 0;
const MOTIF = 1;
const PROJET = 2;

/**
 * Fonction affichant la modale et attribuant les variables correspondantes au type de prestation donné
 *
 * @param   {[type]}  e  [e description]
 */
function openModale(e) {
    //On récupère le template de la modale
    let tmpModale = document.getElementById("contentModale");
    // On remplit la modale avec le template
    modale.innerHTML = tmpModale.innerHTML;

    // Récupère informations TypePrestation
    let plus = e.target;
    let idTypePrestation = plus.parentNode.getAttribute("data-idtypeprestation");
    let typePresta = AppelAjax("TypePrestations", idTypePrestation, null, "", false, null)[0];

    // Affiche la Modale
    modale.style.display = "flex";

    // Calcul le nombre de champs secondaires possibles pour le type de prestation
    let nbSubFld = typePresta.uoRequis * 1 + typePresta.motifRequis * 1 + typePresta.projetRequis * 1;
    // Applique une hauteur spécifique à la modale si les 3 sont possibles (pour forcer la possibilité de scroll)
    modale.querySelector(".lbContent").classList.toggle("modHeight", (nbSubFld == 3));

    // Remplit la partie TypePresta
    modale.innerHTML = modale.innerHTML.replaceAll("valueidtypepresta", idTypePrestation);
    modale.innerHTML = modale.innerHTML.replaceAll("libelleTypePresta", typePresta.libelleTypePrestation);

    // Partie Prestation
    idPrestation = modale.querySelector("[name=modalePrestation]").value;
    var divSearchPrestation = modale.querySelector("#searchPrestation");
    divSearchPrestation.addEventListener("change", function () {
        updateSelectModale("Prestation")
    });
    var divSelectPrestation = modale.querySelector("#selectPrestation");
    condPresta = {};
    condPresta['idTypePrestation'] = idTypePrestation;
    selectModPrestation = AppelAjax("View_TypePrestations", idPrestation, ["CodePrestation", "LibellePrestation"], ' class="modSelect" ', true, condPresta);
    divSelectPrestation.innerHTML = selectModPrestation;
    inputSelectPresta = divSelectPrestation.firstChild;
    inputSelectPresta.setAttribute("title", inputSelectPresta.selectedOptions[0].text)
    // Mise a jour du title du selectPresta
    inputSelectPresta.addEventListener("change", function () {
        updateTitle(event);
        reportPrestation(event);
    });

    // Assigne les valeur indiquant si le champ est "requis"
    listSubFields[UO].besoin=typePresta.uoRequis;
    listSubFields[MOTIF].besoin=typePresta.motifRequis;
    listSubFields[PROJET].besoin=typePresta.projetRequis;

    // Pour chacun des objets/champs
    listSubFields.forEach(element => {
        // On récupère l'input d'ID
        let id = modale.querySelector("input[name=modale" + element.champ + "]");
        // On récupère le champ du filtre
        let divSearch = modale.querySelector("#search" + element.champ);
        // On récupère le fieldset actuel
        let fld = modale.querySelector("#fld" + element.champ);
        // On récupère la div qui contiendra le select
        let divSelect = modale.querySelector("#select" + element.champ);
        // Si le champ actuel n'est pas demandé
        if (element.besoin != 1) {
            // On cache le fieldset
            fld.classList.add("noDisplay");
        } else {
            // Sinon, on ajoute un eventListener sur le filtre
            divSearch.addEventListener("change", () => {
                updateSelectModale(element.champ);
            });
            // Limite des motifs en fonction du type de prestation
            let cond={};
            if(element.champ=="Motif"){
                cond["idTypePrestation"]=idTypePrestation;
            }
            // On initialise le select avec toutes les valeurs possibles
            divSelect.innerHTML = AppelAjax(element.champ + "s", id.value, element.colonnes, ' class="modSelect" ', true, element.champ=="Motif"?cond:null);
            // On ajoute un eventListener sur le select pour MAJ du title
            divSelect.firstChild.addEventListener("change", updateTitle);
        }
    });
}

/**
 * Ajout d'eventListeners sur les bouton "Annuler" et "Valider" de la modale
 *
 */
function btnsModale() {
    // Récupération des boutons
    btnAnnuler = modale.getElementsByTagName("button")[0];
    btnAjouter = modale.getElementsByTagName("button")[1];
    // Ajout des eventListeners
    btnAnnuler.addEventListener("click", closeModale);
    btnAjouter.addEventListener("click", function () {
        ajoutLigne();
        closeModale();
    });
}

/**
 * Fonction fermant la modale
 *
 */
function closeModale() {
    // On referme la modale
    modale.style.display = "none";
}

/**
 * Fonction activant ou désactivant le bouton "Valider" en fonction de validOk
 *
 * @param   boolean  validOk  Le bouton "Valider" doit-il être actif
 *
 */
function gestionBtnValid(validOk) {
    btnValid = document.getElementById("modale").querySelector('[name="addModale"]');
    btnValid.disabled = (!validOk);
}

/**
 * Fonction permettant de reporter les choix effectués dans la modale sur une nouvelle ligne de pointage
 *
 */
function ajoutLigne() {
    // On récupère l'ID du type de prestation
    let idTypePresta = modale.querySelector('[name="IdTypePrestation"]').value;

    // Point de départ pour l'ajout d'une ligne
    let titreTypePresta = document.querySelector('[data-idtypeprestation="' + idTypePresta + '"]');

    // on clone le template
    temp = document.querySelector("#lignePresta");
    contenu = temp.content.cloneNode(true);

    // on insert avant le prochain type
    titreTypePresta.parentNode.insertBefore(contenu, titreTypePresta.nextElementSibling.nextElementSibling);
    nouvelleLigne = titreTypePresta.nextElementSibling.nextElementSibling

    /**  on modifie l'élément insérer */
    nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="idTypePrestation">', '<input name="idTypePrestation" type=hidden value="' + idTypePresta + '"  dataline >');

    // Prestation
    let idPresta = modale.querySelector('[name="modalePrestation"]').value;
    // On récupère ce qui était indiqué dans le select (CODE | LIBELLE)
    let libelleSelectPresta = modale.querySelector('[name="idPrestation"]').selectedOptions[0].text;

    // On sépare le code ([0]) et le libelle ([1])
    splitPresta = splitCodeLibelle(libelleSelectPresta);

    nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replace('<input name="idPrestation">', '<input value="' + splitPresta[1] + '" disabled><input type=hidden name=idPrestation value="' + idPresta + '" dataline >');

    // Code Prestation
    nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replace('"codePrestation"', '"codePrestation" value="' + splitPresta[0] + '" title="' + splitPresta[0] + '"');

    // mis à jour disabled dans motif/projet/uo
    typePrestation = AppelAjax("TypePrestations", idTypePresta, null, "", false, null)[0];

    // Assigne les valeur indiquant si le champ est "requis"
    listSubFields[UO].besoin=typePrestation.uoRequis;
    listSubFields[MOTIF].besoin=typePrestation.motifRequis;
    listSubFields[PROJET].besoin=typePrestation.projetRequis;

    listSubFields.forEach(element => {
        let input = "";
        if (element.besoin == 1) {
            let id = modale.querySelector('[name="modale' + element.champ + '"]').value;
            let title = "";
            let value = "";
            if (id != "" && id != null) {
                let select = modale.querySelector('[name="id' + element.champ + '"').selectedOptions[0].text;

                let split = splitCodeLibelle(select);
                value = split[0];
                title = split[1];
            }
            input = '<input class="inputPointage" dataline type="text" name="input' + element.champ + '" value="' + value + '" disabled title="' + title + '"></input><input class="inputPointage notApplicable" dataline type="hidden" name="id' + element.champ + '" disabled value="' + id + '">';
        } else {
            input= '<input class="inputPointage notApplicable" dataline  type="text" name="id' + element.champ + '" disabled>';
        }
        nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="input' + element.champ + '">', input);
    });

    // trouver data-line
    numPresta = (document.querySelector("#numPrestaMax").value) * 1 + 1;
    document.querySelector("#numPrestaMax").value = numPresta;
    nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('dataline=""', 'data-line="' + numPresta + '"');

    /**  mettre les cases */
    // on sélectionne une ligne de case de pointage et on la duplique
    gridpointage = document.querySelectorAll(".grid-pointage")[1].cloneNode(true);
    // on l'ajoute à la dom
    titreTypePresta.parentNode.insertBefore(gridpointage, titreTypePresta.nextElementSibling.nextElementSibling.nextElementSibling);
    nouvellecasePointage = titreTypePresta.nextElementSibling.nextElementSibling.nextElementSibling;

    // on remet les pointages à "" et on met le bon data-line
    //les inputs
    for (let i = 3; i < nouvellecasePointage.children.length; i++) {
        const element = nouvellecasePointage.children[i];
        //element est une div. on modifie l'input à l'intérieur
        if (element.children.length > 0) {
            element.children[0].value = "";
            element.children[0].setAttribute("data-line", numPresta);
            element.children[0].setAttribute("data-idPointage", "");
            // ajouter les evenements sur les cases
            element.children[0].addEventListener("change", changePointage);
            element.children[0].addEventListener('focus', SelectColonne);
            element.children[0].addEventListener('blur', SelectColonne);
            element.children[0].addEventListener("wheel", scrollHoriz);
        }
        //le total et le pourcentage
        nouvellecasePointage.children[0].setAttribute("data-line", numPresta);
        nouvellecasePointage.children[1].setAttribute("data-line", numPresta);
        //Remise à zéro des colonnes Total et pourcentage
        document.querySelector("div.colTotal[data-line='" + numPresta + "']").textContent = "0.00"
        document.querySelector("div.colPrctGTA[data-line='" + numPresta + "']").textContent = "0%"

        /* evenement*/
        //on ajoute l'evenement pour expand
        nouvelleLigne.querySelector(".expand-line").addEventListener("click", expand);
        nouvelleLigne.querySelector(".expand-line").dispatchEvent(new Event("click"));
        //on ajoute l'evenement pour favoris
        nouvelleLigne.querySelector(".fa-fav").addEventListener("click", UpdateFav);
    }
}

/**
 * Fonction permettant de séparer le code (retour[0]) du libelle (retour[1])
 *
 */
function splitCodeLibelle(string) {
    let splitLibelle = string.split(" | ");
    let code = splitLibelle[0];
    let libelle = "";
    for (let index = 1; index < splitLibelle.length; index++) {
        const element = splitLibelle[index];
        libelle = libelle + " " + element;
    }
    return [code, libelle];
}

/**
 * Fonction mettant à jour l'attribut "title" d'un select après modif
 * et mettant à jour l'ID dans l'input hidden
 *
 * @param   {[type]}  event  L'évenement déclancheur
 *
 */
function updateTitle(event) {
    // On détermine quel select est concerné
    let cible = event.target;
    let name = cible.name;
    let inputId = modale.querySelector('input[name="modale' + name.slice(2) + '"]');
    // On met le text de l'option choisie dans son title
    cible.setAttribute("title", cible.selectedOptions[0].text);
    // Et on en profite pour mettre à jour l'ID dans l'input hidden
    inputId.setAttribute("value", cible.value);
}

/**
 * Fonction remplaçant un select pour application du filtre correspondant
 *
 * @param   {string}  champ  Le champ concerné ("Prestation", "Uo", "Motif" ou "Projet")
 *
 */
function updateSelectModale(champ) {
    // On récupère l'ID du type de prestation
    let idTypePrestation = modale.querySelector('[name="IdTypePrestation"]').value;
    // On récupère la div dans laquelle on mettra le select
    let cible = modale.querySelector("#select" + champ);
    // On récupère le filtre
    let search = modale.querySelector("#search" + champ);
    // Initialisation des conditions
    let cond = {};
    switch (champ) {
        case "Prestation":
            // Si "Prestation", les conditions sont l'idTypePrestation et le filtre
            cond['idTypePrestation'] = idTypePrestation;
            cond.fullTexte = search.value;
            // On crée le nouveau select
            select = AppelAjax("View_TypePrestations", modale.querySelector("input[name=modale" + champ + "]").value, ["CodePrestation", "LibellePrestation"], ' class="modSelect" ', true, cond);
            break;
        case "Uo":
        case "Motif":
        case "Projet":
            // Si "Uo", "Motif" ou "Projet", la condition n'est que le filtre
            cond.fullTexte = search.value;
            if(champ=="Motif"){
                cond.idTypePrestation=idTypePrestation;
            }
            // On récupère la constante correspondante au champ
            numSubField=eval(champ.toUpperCase());
            // On crée le nouveau select
            select = AppelAjax(champ+"s", modale.querySelector("input[name=modale" + champ + "]").value, listSubFields[numSubField].colonnes, ' class="modSelect" ', true, cond);
            break;
        default:
            break;
    }
    // On place le select au bon endroit
    cible.innerHTML = select;
    // On remet le title
    cible.firstChild.setAttribute("title", cible.firstChild.selectedOptions[0].text);
    // On remet l'eventListener sur le changement du nouveau select
    cible.firstChild.addEventListener("change", function () {
        updateTitle(event);
        id = modale.querySelector("input[name=modale" + champ + "]");
        id.value = cible.firstChild.value;
        if(champ=="Prestation"){      
            reportPrestation(event);
        }
    });
}

/**
 * Fonction qui attribue automatiquement les valeurs propres à la prestation
 *
 * @param   {*}  event  Événement déclencheur
 *
 */
function reportPrestation(event) {
    let selectPresta = event.target;
    let field = document.getElementById("modale");
    // Report de l'idPrestation et du codePrestation dans tous les cas
    field.querySelector('input[name="modalePrestation"]').value = selectPresta.value;

    condition = {};
    condition["idPrestation"] = selectPresta.value;
    // Report du projet pour MNSP
    projet = AppelAjax("View_Prestations", null, ["idProjet", "codeProjet", "libelleProjet"], null, false, condition);
    if (projet != false && projet[0].idProjet != null) {
        field.querySelector('input[name="modaleProjet"]').value = projet[0].idProjet;
        field.querySelector('select[name="idProjet"]').value = projet[0].idProjet;
        field.querySelector('select[name="idProjet"]').title = projet[0].libelleProjet;
    }

    // Active ou désactive le bouton "Valider" en fonction de la prestation
    console.log(selectPresta.value);
    gestionBtnValid(selectPresta.value != null && selectPresta.value != "");
}
