/* gestion de la grille de pointage
    gestion des favoris, des scrolls, 
    gestion des colonnes en fonction de la configuration du mois
    gestion des apparences des cellules en fonction de l'état du pointage pour la journée
    gestion des nombres décimaux
*/

/*********************************INITIALISATION ******************************************/
window.addEventListener("load", setGridPointage);

listeStarFav = document.querySelectorAll(".fa-fav");
listeStarFav.forEach(etoile => {
    etoile.addEventListener("click", UpdateFav);
});

listeCases = document.querySelectorAll('.casePointage');
listeCases.forEach(caseJour => {
    // caseJour.addEventListener('change', ChangeCellule);
    caseJour.addEventListener('focus', SelectColonne);
    caseJour.addEventListener('blur', SelectColonne);
});

sectionSideScroll = document.querySelectorAll('.grid-pointage');
sectionSideScroll.forEach(element => {
    element.addEventListener("wheel", scrollHoriz)
});

// eviter les méthodes aveugles dans les addeventlistener
// on ne peut pas s'en resservir pour les elements générés après
listeLignesPresta = document.querySelectorAll(".expand-line");
listeLignesPresta.forEach(LignePresta => {
    LignePresta.addEventListener("click", expand);
});

/* Mets à jour les pointage en base de données
   Gestion du + pour ajouter les prestations
   Fige les combobox après la saisie du 1er pointage
*/

var idUser = document.getElementById("IdUtilisateur").innerHTML;
var inputs = document.querySelectorAll(".casePointage");
oldValeur = 0;
// On ajoute un evenement sur toutes les cases de pointage qui se déclanche lorsque la valeur de la case change
inputs.forEach((element) => {
    element.addEventListener("change", changePointage);
    element.addEventListener("focus", saveOldValeur);
});

listePlus = document.querySelectorAll(".fa-plus");
listePlus.forEach(element => {
    //element.addEventListener("click", clicPlus);
    element.addEventListener("click",()=>{ 
        openModale(event);
        btnsModale();
    });
});

/*********************************PRESENTATION ******************************************/
/**
 * Fonction imposant le scroll horizontal au survol de la zone de pointage
 * @param {*} e Événement déclencheur
 */
function scrollHoriz(e) {
    sectionSideScroll = document.querySelectorAll('.grid-pointage');
    const race = 125;
    if (e.deltaY > 0) {
        sectionSideScroll.forEach(balise => {
            balise.scrollLeft += race;
        })
    }
    else {
        sectionSideScroll.forEach(balise => {
            balise.scrollLeft -= race;
        })
    }
    e.preventDefault();
}

/**
 * Fonction permettant de montrer ou cacher les détails d'une prestation
 * @param {*} e Événement déclencheur
 */
function expand(e) {
    // Pour éviter qu'il applique aussi le toggle à la div contenant le I
    if (e.target.nodeName == "I") {
        e.target.classList.toggle("fa-open");
        e.target.classList.toggle("fa-close");
    }
    ligne = e.target.parentNode.parentNode.parentNode;
    listeCol = ligne.querySelectorAll(".cellCachable");
    listeCol.forEach(cell => {
        cell.classList.toggle("noDisplay");
    });
}

/**
 * Fonction méttant à jour la feuille de style controllant la grid des pointages en fonction des jours du mois visualisé
 */
function setGridPointage() {
    // Récupération de la période actuelle (AAAA-MM)
    selectPeriode = document.querySelector("#periode");

    // Séparation de la période en "annee" et "mois"
    tabPeriode = selectPeriode.value.split('-');
    annee = tabPeriode[0];
    mois = tabPeriode[1];

    // Récupération du nombre de jour dans ce mois
    const getDays = (year, month) => {
        return new Date(year, month, 0).getDate();
    }
    const nbreJour = getDays(annee, mois);

    // Récupération de la feuille de style correspondante au pointage
    var feuilleStyle = document.querySelector('link[href*=pointage]').sheet.cssRules[0];

    // Sur cette dernière, récupérations des tailles attribués aux diverses colonnes
    tailleTotal = feuilleStyle.style.getPropertyValue('--width-col-total');
    taillePrct = feuilleStyle.style.getPropertyValue('--width-col-prct');
    tailleJo = feuilleStyle.style.getPropertyValue('--width-col-jo');
    tailleWe = feuilleStyle.style.getPropertyValue('--width-col-we');

    // Création du nouveau contenu du template de la grid
    theGridTemplateColumnsValue = tailleTotal + " " + taillePrct + " 0.1em ";
    for (let jour = 1; jour <= nbreJour; jour++) {
        jourActu = new Date(annee, mois - 1, jour);
        //SommeColonne(annee + "-" + mois + "-" + String(jour).padStart(2, '0'));
        if (jourActu.getDay() == 0 || jourActu.getDay() == 6) {
            theGridTemplateColumnsValue += tailleWe + " ";
        }
        else {
            theGridTemplateColumnsValue += tailleJo + " ";
        }
    }
    SommeColonne();
    // Injection dans le CSS
    feuilleStyle.style.setProperty('--grid-template-columns', theGridTemplateColumnsValue);
};

/**
 * Fonction changeant l'apparence de la colonne
 * @param {int} colonne 
 */
function FormatColonne(colonne) {
    // Récupération de toutes les cellules (inputs et autres) de la colonne/journée actuelle
    let cellsColonne = document.querySelectorAll("[data-date='" + colonne + "']");
    if (cellsColonne.length > 0) {
        total = cellsColonne[0].dataset.somme;
        // Gestion des classes en fonction du total de la colonne
        if (total == 1.00 && !cellsColonne[0].classList.contains("notApplicable")) {
            // La journée est complète et il n'y a rien à ajouter => la colonne passe au vert
            isOK = true;
            isWork = false;
            isWarning = false;
        } else if (total > 1.00) {
            // Il y a un problème sur la colonne et l'utilisateur doit corriger => la colonne passe au rouge
            isOK = false;
            isWork = false;
            isWarning = true;
        } else {
            // La colonne n'est pas terminé => reste ou passe en blanc
            isOK = false;
            isWork = true;
            isWarning = false;
        }

        // Application des classes pour chaque cellule de la colonne
        cellsColonne.forEach(cellule => {
            cellule.classList.toggle("jourOK", isOK);
            cellule.classList.toggle("work", isWork);
            cellule.classList.toggle("jourWarn", isWarning);
        })
    }
}

/**
 * Fonction gérant le fait de passer ou non la colonne en "absent"
 * @param {*} colonne Valeur de la colonne, de la forme "AAAA-MM-JJ"
 * @param {*} valeur Valeur de la cellule testé (cellule de la ligne des absences)
 */
function MarquageAbsent(colonne, valeur) {
    // Récupération de toutes les cellules de la colonne
    let inputsColonne = document.querySelectorAll("[data-date='" + colonne + "']");

    // Doit-on désactiver les inputs de la colonne (la journée est-elle marqué comme complètement "Absente")
    if (valeur == 1) {
        inputDisabled = true;
    }
    else {
        inputDisabled = false;
    }

    // Récupération de la cellule de la 1ère ligne de cette colonne
    let celAbsActu = document.querySelector("[data-date='" + colonne + "'][data-line='1']")
    // Changement de son apparence en fonction de sa valeur
    celAbsActu.classList.toggle("notApplicable", inputDisabled);
    // Pour chacune des autres cellules de la colonne
    inputsColonne.forEach(elt => {
        if (elt.getAttribute("data-line") != "1") {

            // Si la colonne est complétement absente et que la cellule n'était pas vide
            if (valeur == 1 && elt.value !== "") {
                // On retranche la valeur à la somme de la ligne
                cellTotalLigne = document.querySelector(".colTotal[data-line='" + elt.getAttribute("data-line") + "'");
                if (cellTotalLigne != null) {
                    cellTotalLigne.innerHTML=parseFloat(cellTotalLigne.innerHTML) - parseFloat(elt.value);
                }
                // On retranche la valeur à la somme de la colonne
                if(elt.hasAttribute("data-line")){
                    inputsColonne[0].dataset.somme = parseFloat(inputsColonne[0].dataset.somme)-parseFloat(elt.value);
                }
                // On "vide" la cellule
                elt.value = "";
                // Trigger de l'event "change" sur la cellule pour mise à jour de la base de donnée
                let changeCellEvent = new Event("change")
                elt.dispatchEvent(changeCellEvent);
            }

            // Désactivation (ou non) de l'input
            elt.disabled = inputDisabled;
            // Application (ou non) de la classe d'apparence pour une colonne "absente"
            elt.classList.toggle("notApplicable", inputDisabled);
        }
    });
}

/**
 * Fonction permettant de mettre un cadre vert autour de chaque cellule de la colonne actuelle
 * @param {*} e Événement déclencheur
 */
function SelectColonne(e) {
    // Récupération de la colonne actuelle
    let colonne = e.target.getAttribute("data-date");

    // Récupération de toutes les cellules de la colonne
    let inputsColonne = document.querySelectorAll("[data-date='" + colonne + "']");
    // Application de la classe à toutes les cellules
    inputsColonne.forEach(elt => {
        elt.classList.toggle("colSelected");
    });
}

/*********************************CALCUL **************************************************/
/**
 * Fonction gérant l'appel des diverses fonctions de modification d'apparence et de contenu des cellules
 * @param {*} e Événement déclencheur
 */
function ChangeCellule(cell) {
    // Récupérations des infos de la cellule
    //let cell = e.target;
    let ligne = cell.getAttribute("data-line");
    let colonne = cell.getAttribute("data-date");
    cell.value = preformatFloat(cell.value) == 0 ? "" : preformatFloat(cell.value);

    // Si le contenu de la cellule n'est pas valide, on l'efface
    if (isNaN(cell.value) || (cell.value < 0 || cell.value > 1)) {
        cell.value = oldValeur;
    }

    // Si l'on est sur la ligne des absences, on voit si la colonne entière doit être mise en "absent"
    if (ligne == 1) {
        MarquageAbsent(colonne, cell.value);
    }
    FormatColonne(colonne)
    // else {
    //     // Sinon, on calcul la somme des valeurs de la colonne
    //     SommeColonne(colonne);
    // }

    // Si l'on est pas sur la lignes des absences, on calcul le %GTA
    if (ligne != 1) {
        CalculPrctGTA();
    }
}

/**
 * Fonction calculant le total d'une journée au chargement de la page pour tous les jours
 *  
 */
function SommeColonne() {

    casesDate = document.querySelectorAll("div.grid-lineDouble")
    for (let i = 0; i < casesDate.length; i++) {
        const element = casesDate[i];
        colonne = element.dataset.date;

        // Initialisation du total à 0
        let total = 0;
        // Récupération de tous les inputs de la colonne/journée actuelle
        let inputsColonne = document.querySelectorAll("input[data-date='" + colonne + "']");
        // Boucle sur tous les éléments de cette liste
        for (let j = 0; j < inputsColonne.length; j++) {
            const cellule = inputsColonne[j];
            total += cellule.value == "" ? 0.00 : parseFloat(cellule.value);
        }
        // Mise à jour du total pour cette itération
        element.dataset.somme = parseFloat(total).toFixed(2);
        FormatColonne(colonne);
    };
    CalculPrctGTA();
}


/**
 * Fonction permettant de calculer les %GTA de toutes les lignes
 *
 */
function CalculPrctGTA() {
    // Récupération de la liste de tous les % des prestations
    let listPrct = document.querySelectorAll(".colPrctGTA");
    // Récupération de la liste de tous les totaux des prestations
    let listeTousTotaux = document.querySelectorAll(".colTotal");
    //Initialisation des variables
    let totalMois = 0;
    let prctActu = 0;
    for (let i = 1; i < listeTousTotaux.length; i++) {
        const element = listeTousTotaux[i];
        totalMois = parseFloat(totalMois) + parseFloat((element.innerHTML != "") ? element.innerHTML : 0);
    }
    for (let j = 1; j < listPrct.length; j++) {
        const element = listPrct[j];
        prctActu = ((parseFloat(listeTousTotaux[j].innerHTML) * 100.00) / parseFloat(totalMois)).toFixed(2);
        element.innerHTML = (isNaN(prctActu) ? 0 : prctActu) + "%";
    }
}

/**
 * Mise à jour des favoris dans la base de donnée
 * @param {*} e Événement déclencheur
 */
function UpdateFav(e) {
    let caseFav = e.target.parentNode.parentNode.parentNode;
    let idPreference = (caseFav.querySelector("[name='idPreference']") != null) ? caseFav.querySelector("[name='idPreference']").value : '';
    let idPrestation = caseFav.querySelector("[name='idPrestation']").value;
    let idUo = (caseFav.querySelector("[name='idUo']") != null) ? caseFav.querySelector("[name='idUo']").value : '';
    let idMotif = (caseFav.querySelector("[name='idMotif']") != null) ? caseFav.querySelector("[name='idMotif']").value : '';
    let idProjet = (caseFav.querySelector("[name='idProjet']") != null) ? caseFav.querySelector("[name='idProjet']").value : '';
    let idTypePrestation = caseFav.parentNode.querySelector("[name='idTypePrestation']").value;
    let idUtilisateur = document.querySelector("#IdUtilisateur").innerHTML;

    e.target.classList.toggle("favActive", idPreference == '');

    let req = new XMLHttpRequest();
    req.open("POST", "index.php?page=MAJPreferencesAPI", true);// Initialisation de la requête avec une methode POST et le chemin de la page de traitement
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // Preparation des arguments qui seront envoyé par POST à la page de traitement
    let args = "idUo=" + idUo + "&idMotif=" + idMotif + "&idProjet=" + idProjet + "&idPrestation=" + idPrestation + "&idTypePrestation=" + idTypePrestation + "&idUtilisateur=" + idUtilisateur;
    if (idPreference) args += "&idPreference=" + idPreference; // Si le favoris possède déjà un ID
    req.send(args);

    req.onreadystatechange = function (event) {   // Lorsque l'état de la requête change
        if (this.readyState === XMLHttpRequest.DONE) { // Si la requête a bien été executée
            if (this.status === 200) { // Si la requête est réussie
                if (this.responseText) { // Si la réponse n'est pas vide
                    let id = (this.responseText).replace(/"/g, ""); // Enlève les "" de l'id récupéré car reçu en JSON
                    caseFav.querySelector("[name='idPreference']").value = id; // Mise à jour de l'input
                    pointageSave();
                }
            }
        }
    };
}

/**
 * Traitement des pointages pour gérer les multiples ponctuations lors de la saisie
 * @param {*} float 
 * @returns
 */
function preformatFloat(float) {
    if (!float) {
        return 0;
    };

    let regFloat = [/,/g, /\./g];
    let char = [',', '.'];

    for (let i = 0; i < 2; i++) {
        if (float.match(regFloat[i]) != null) {
            if ((float.match(regFloat[i])).length >= 1) {
                let split = float.split(char[i]);
                if (split[1].includes(char[Math.abs(i - 1)]) || split[1] == "") {
                    float = split[0];
                } else {
                    float = split[0] + "." + split[1];
                }
            }
        }
    }
    return float;
};

function saveOldValeur(event) {
    oldValeur = event.target.value != "" ? event.target.value : 0;
}

function changePointage(event) {
    let pointage = event.target; // Case de pointage changée
    let idpointage = pointage.getAttribute('data-idpointage');// Id de le la case
    let ligne = pointage.dataset.line; // Dataset contenant le numero de la prestation
    let date = pointage.dataset.date; // Dataset contenant la date en format (YYYY-MM-DD)

    // Récupération des différents ID de la ligne
    let typePrestation = document.querySelector('input[data-line="' + ligne + '"][name="idTypePrestation"]').value;
    let uo = document.querySelector('input[data-line="' + ligne + '"][name="idUo"]').value;
    let motif = document.querySelector('input[data-line="' + ligne + '"][name="idMotif"]').value;
    let projet = document.querySelector('input[data-line="' + ligne + '"][name="idProjet"]').value;
    let prestation = document.querySelector('input[data-line="' + ligne + '"][name="idPrestation"]').value;

    let valeur = preformatFloat(pointage.value);
    if (valeur < 0 || valeur > 1) {
        valeur = oldValeur;
    }
    // mise à jour de la somme sur la ligne
    caseSomme = document.querySelector("div.colTotal[data-line='" + ligne + "']")
    somme = parseFloat(caseSomme.textContent)
    caseSomme.textContent = (somme + parseFloat(valeur) - parseFloat(oldValeur)).toFixed(2);
    // mise à jour de la somme sur la colonne
    caseSomme = document.querySelector("div.grid-lineDouble[data-date='" + date + "']");
    somme = parseFloat(caseSomme.dataset.somme);
    caseSomme.dataset.somme = (somme + parseFloat(valeur) - parseFloat(oldValeur)).toFixed(2);

    ChangeCellule(pointage)
    // Requête
    let req = new XMLHttpRequest();
    req.open("POST", "index.php?page=MAJPointageAPI", true); // Initialisation de la requête avec une methode POST et le chemin de la page de traitement
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // Preparation des arguments qui seront envoyé par POST à la page de traitement
    let args = "idUo=" + uo + "&idMotif=" + motif + "&idProjet=" + projet + "&idPrestation=" + prestation + "&idTypePrestation=" + typePrestation + "&datePointage=" + date + "&idUtilisateur=" + idUser + "&nbHeuresPointage=" + valeur;

    if (idpointage) args += "&idPointage=" + idpointage; // Si la case possède déjà un ID
    req.send(args);
    console.log(args);

    req.onreadystatechange = function (event) {   // Lorsque l'état de la requête change
        if (this.readyState === XMLHttpRequest.DONE) { // Si la requête a bien été executée
            if (this.status === 200) { // Si la requête est réussie
                if (this.responseText) { // Si la réponse n'est pas vide
                    console.log(this.responseText);
                    if (this.responseText == "Delete") {
                        // Si l'on vient de supprimer le pointage de la BdD, on enlève le data-idPointage
                        pointage.removeAttribute('data-idpointage');
                    }
                    else {
                        let id = (this.responseText).replace(/"/g, ""); // Enlève les "" de l'id récupéré car reçu en JSON
                        pointage.setAttribute("data-idpointage", id); // Change l'attribut ID de la case
                        pointageSave();
                    }
                }
            }
        }
    };
    // si c'est le 1er pointage d'une prestation
    // on transforme les select en input
    if (document.querySelector('select[data-line="' + ligne + '"][name="idPrestation"]') != undefined)
        SelectToInput("Prestation", ligne);
    SelectToInput("Motif", ligne);
    SelectToInput("Uo", ligne);
    SelectToInput("Projet", ligne);
}

function pointageSave() {
    save = document.querySelector(".trans")
    save.classList.remove("invisible");
    save.classList.add("visible");
    setTimeout(() => {
        save.classList.add("invisible");
        save.classList.remove("visible");
    }, 3000);
}
/**
 * Méthode qui permet d'ajouter une ligne lorsque l'on clique sur le plus à coté du type de Prestations
 * @param {*} event 
 */
// function clicPlus(event) {
//     plus = event.target;
//     idTypePrestation = plus.parentNode.getAttribute("data-idtypeprestation");
//     condition = {}
//     // on clone le template
//     temp = document.querySelector("#lignePresta");
//     contenu = temp.content.cloneNode(true);
//     // on insert avant le prochain type
//     plus.parentNode.parentNode.insertBefore(contenu, plus.parentNode.nextElementSibling.nextElementSibling);
//     nouvelleLigne = plus.parentNode.nextElementSibling.nextElementSibling

//     /**  on modifie l'élément insérer */
//     nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="idTypePrestation">', '<input name="idTypePrestation" type=hidden value="' + idTypePrestation + '"  dataline >');


//     // mis à jour liste presta
//     condition['idTypePrestation'] = idTypePrestation;
//     selectPresta = AppelAjax("View_TypePrestations", null, ["CodePrestation", "LibellePrestation"], "class=inputPointage dataline", true, condition);
//     nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replace('<input name="idPrestation">', selectPresta + '<input type=hidden name=idPrestation dataline >');

//     // mis à jour disabled dans motif/projet/uo
//     typePrestation = AppelAjax("TypePrestations", idTypePrestation, null, "", false, null)[0];
//     selectUo = (typePrestation.uoRequis == 1) ? AppelAjax("Uos", null, ["NumeroUo", "LibelleUo"], 'class="" dataline ', true, null) + '<input  class="inputPointage notApplicable" dataline  type="hidden" name="idUo" disabled>' : '<input class="inputPointage notApplicable" dataline  type="text" name="idUo" disabled>';
//     selectProjet = (typePrestation.projetRequis == 1) ? AppelAjax("Projets", null, ["CodeProjet"], 'class="" dataline ', true, null) + '<input class="inputPointage notApplicable" dataline  type="hidden" name="idProjet" disabled>' : '<input class="inputPointage notApplicable" dataline  type="text" name="idProjet" disabled>';
//     selectMotif = (typePrestation.motifRequis == 1) ? AppelAjax("Motifs", null, ["CodeMotif","LibelleMotif"], 'class="" dataline ', true, null) + '<input class="inputPointage notApplicable" dataline  type="hidden" name="idMotif" disabled>' : '<input class="inputPointage notApplicable" dataline  type="text" name="idMotif" disabled>';
//     nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="inputUo">', selectUo);
//     nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="inputProjet">', selectProjet);
//     nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="inputMotif">', selectMotif);

//     // trouver data-line
//     numPresta = (document.querySelector("#numPrestaMax").value) * 1 + 1
//     console.log(numPresta);
//     document.querySelector("#numPrestaMax").value = numPresta
//     nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('dataline=""', 'data-line="' + numPresta + '"');


//     /**  mettre les cases */
//     // on sélectionne une ligne de case de pointage et on la duplique
//     gridpointage = document.querySelectorAll(".grid-pointage")[1].cloneNode(true);
//     // on l'ajoute à la dom
//     plus.parentNode.parentNode.insertBefore(gridpointage, plus.parentNode.nextElementSibling.nextElementSibling.nextElementSibling);
//     nouvellecasePointage = plus.parentNode.nextElementSibling.nextElementSibling.nextElementSibling;

//     // on remet les pointages à "" et on met le bon data-line
//     //les inputs
//     for (let i = 3; i < nouvellecasePointage.children.length; i++) {
//         const element = nouvellecasePointage.children[i];
//         //element est une div. on modifie l'input à l'intérieur
//         if (element.children.length > 0) {
//             element.children[0].value = "";
//             element.children[0].setAttribute("data-line", numPresta);
//             element.children[0].setAttribute("data-idPointage", "");
//             // ajouter les evenements sur les cases
//             element.children[0].addEventListener("change", changePointage);
//             element.children[0].addEventListener('focus', SelectColonne);
//             element.children[0].addEventListener('blur', SelectColonne);
//             element.children[0].addEventListener("wheel", scrollHoriz);
//         }
//     }
//     //le total et le pourcentage
//     // nouvellecasePointage.children[0].innerHtml="";
//     nouvellecasePointage.children[0].setAttribute("data-line", numPresta);
//     // nouvellecasePointage.children[1].innerHtml="";
//     nouvellecasePointage.children[1].setAttribute("data-line", numPresta);
//     //Remise à zéro des colonnes Total et pourcentage
//     document.querySelector("div.colTotal[data-line='" + numPresta + "']").textContent = "0.00"
//     document.querySelector("div.colPrctGTA[data-line='" + numPresta + "']").textContent = "0%"

//     /* evenement*/
//     //on ajoute l'evenement pour expand
//     nouvelleLigne.querySelector(".expand-line").addEventListener("click", expand);
//     nouvelleLigne.querySelector(".expand-line").dispatchEvent(new Event("click"));
//     //on ajoute l'evenement pour favoris
//     nouvelleLigne.querySelector(".fa-fav").addEventListener("click", UpdateFav);
//     // on ajoute des evenements pour reporter les elements selectionner dans les combo dans les input correspondants
//     nouvelleLigne.querySelector('select[name="idPrestation"]').addEventListener("change", reportPrestation);
//     if (nouvelleLigne.querySelector('select[name="idMotif"]')) nouvelleLigne.querySelector('select[name="idMotif"]').addEventListener("change", reportSelect);
//     if (nouvelleLigne.querySelector('select[name="idProjet"]')) nouvelleLigne.querySelector('select[name="idProjet"]').addEventListener("change", reportSelect);
//     if (nouvelleLigne.querySelector('select[name="idUo"]')) nouvelleLigne.querySelector('select[name="idUo"]').addEventListener("change", reportSelect);

// }

/**
 * Méthode d'appel ajax synchrone
 * @param {*} table  // nom de la table pour la requete
 * @param {*} id // valeur de l'id soit à selectionner pour un select soit pour le where dans les listes
 * @param {*} colonne // colonnes à renvoyer tableau attendu
 * @param {*} attribut // attribut à ajouter sur le select
 * @param {*} select // boolean vaut vrai pour un select faux pour une liste
 * @param {*} condition // condition à ajouter sur le select
 * @returns 
 */
function AppelAjax(table, id, colonne, attribut, select, condition) {
    var req = new XMLHttpRequest();
    req.open('POST', 'index.php?page=ListePointageAPI', false); // false signifie appel synchrone
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    args = "table=" + table + "&id=" + id + "&colonne=" + JSON.stringify(colonne) + "&attribut=" + attribut + "&select=" + select + "&condition=" + JSON.stringify(condition);
    console.log(args);
    req.send(args);
    if (req.status === 200) {
        console.log(req.responseText);
        if (!select)
            return JSON.parse(req.responseText);
        return req.responseText;
    }
}

/**
 * Fonction qui attribue automatiquement les valeurs propres à la prestation
 *
 * @param   {*}  event  Événement déclencheur
 *
 */
// function reportPrestation(event) {
//     // Récupération de la Node correspondante à la ligne en cours
//     ligne = event.target.parentNode.parentNode;

//     // Report de l'idPrestation et du codePrestation dans tous les cas
//     ligne.querySelector('input[name="idPrestation"]').value = event.target.value;
//     ligne.querySelector('input[name="codePrestation"]').value = event.target.selectedOptions[0].label.substring(0, 4);

//     condition = {};
//     condition["idPrestation"] = event.target.value;
//     // Report du projet pour MNSP
//     projet = AppelAjax("View_Prestations", null, ["idProjet", "codeProjet", "libelleProjet"], null, false, condition);
//     if (projet != false && projet[0].idProjet!=null) {
//         ligne.querySelector('input[name="idProjet"]').value = projet[0].idProjet;
//         ligne.querySelector('select[name="idProjet"]').value = projet[0].idProjet;
//     }
// }

/**
 * Modifie la valeur de l'input de type hidden correspondant au select
 *
 * @param   {*}  event  Événement déclencheur
 *
 */
function reportSelect(event) {
    // Récupération du champs concerné (Motif, Projet ou Uo)
    type = event.target.name.substring(2);
    // Création de la condition pour la recherche de l'input
    elementCherche = 'input[name="id' + type + '"]';
    // Mise à jour de la valeur dans l'input
    ligne = event.target.parentNode.parentNode;
    ligne.querySelector(elementCherche).value = event.target.value;
}

/**
 * Fonction changeant un select d'une prestation en input de type text désactivé
 *
 * @param   {string}  type   De quel champs il s'agit
 * @param   {int}  ligne  La ligne où se trouve le select
 *
 */
function SelectToInput(type, ligne) {
    // Récupération du select voulu et attribution de classe
    condSource = 'select[data-line="' + ligne + '"][name="id' + type + '"]';
    classe = (type == "Prestation") ? "" : "inputPointage";
    source = document.querySelector(condSource);

    // Si le select existe
    if (source != null) {
        // le nouvel input aura pour valeur soit "" si le select est vide, soit le label de l'option choisie
        valeur = (source.value != "") ? source.selectedOptions[0].label : "";
        
        // Création de l'input text avec les paramètres prédéfinis
        cible = '<input class="' + classe + '" data-line="' + ligne + '" type="text" name="input' + type + '" value="' + valeur + '" disabled="" title="'+valeur+'"></input>';
        input = document.createElement("input");
        input.innerHTML = cible;
        source.parentNode.replaceChild(input.children[0], source);
    }

}