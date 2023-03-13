window.addEventListener("load", setGridPointage);

listeStarFav = document.querySelectorAll(".fa-fav");
listeStarFav.forEach(etoile => {
    etoile.addEventListener("click", UpdateFav);
});

listeCases = document.querySelectorAll('.casePointage');
listeCases.forEach(caseJour => {
    caseJour.addEventListener('change', ChangeCellule);
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
    listeCol = ligne.querySelectorAll(".colCachable");
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
        SommeColonne(annee + "-" + mois + "-" + String(jour).padStart(2, '0'));
        if (jourActu.getDay() == 0 || jourActu.getDay() == 6) {
            theGridTemplateColumnsValue += tailleWe + " ";
        }
        else {
            theGridTemplateColumnsValue += tailleJo + " ";
        }
    }

    // Injection dans le CSS
    feuilleStyle.style.setProperty('--grid-template-columns', theGridTemplateColumnsValue);
};

/**
 * Fonction gérant l'appel des diverses fonctions de modification d'apparence et de contenu des cellules
 * @param {*} e Événement déclencheur
 */
function ChangeCellule(e) {
    // Récupérations des infos de la cellule
    let cell = e.target;
    let ligne = cell.getAttribute("data-line");
    let colonne = cell.getAttribute("data-date");
    cell.value = preformatFloat(cell.value);

    // Si le contenu de la cellule n'est pas valide, on l'efface
    if (isNaN(cell.value) || (cell.value < 0 || cell.value > 1)) {
        cell.value = "";
    }

    // Si l'on est sur la ligne des absences, on voit si la colonne entière doit être mise en "absent"
    if (ligne == 1) {
        MarquageAbsent(colonne, cell.value);
    }
    else {
        // Sinon, on calcul la somme des valeurs de la colonne
        SommeColonne(colonne);
    }

    // On calcul la somme des valeurs de la ligne
    SommeLigne(ligne);

    // Si l'on est pas sur la lignes des absences, on calcul le %GTA
    if (ligne != 1) {
        CalculPrctGTA(ligne);
    }
}

/**
 * Fonction calculant la somme des valeurs des cellules de la ligne
 * @param {*} ligne 
 */
function SommeLigne(ligne) {
    // Initialisation du total à 0
    let total = 0;

    // Récupération de toutes les cases de pointages de la ligne
    let casesLigne = document.querySelectorAll("input.casePointage[data-line='" + ligne + "']");

    // Pour chacune de ces cases
    casesLigne.forEach(inputCase => {
        if (inputCase.value != "") {
            // Si la case n'est pas vide, on ajoute sa valuer
            ajoutLigne = inputCase.value;
        } else {
            // Sinon, on ajoute 0
            ajoutLigne = 0;
        }
        // Mise à jour du total pour cette itération
        total = (parseFloat(total) + parseFloat(ajoutLigne)).toFixed(2);
    })

    // On récupére la cellule correspondante au "Total" pour cette ligne
    let caseTotal = document.querySelector("div.colTotal[data-line='" + ligne + "']");
    // Et on la rempli avec le total calculé
    caseTotal.innerHTML = total;
}

/**
 * Fonction calculant le total d'une journée et changeant l'apparence de cette dernière en conséquence
 * @param {int} colonne 
 */
function SommeColonne(colonne) {
    // Initialisation du total à 0
    let total = 0;
    // Récupération de tous les inputs de la colonne/journée actuelle
    let inputsColonne = document.querySelectorAll("input[data-date='" + colonne + "']");
    // Boucle sur tous les éléments de cette liste
    inputsColonne.forEach(cellule => {
        // Gestion des champs nulls et des cas où la journée est entièrement "absent"
        if (cellule.value == "" || (cellule.getAttribute("data-line") == 1 && cellule.value == 1)) {
            ajoutColonne = 0;
        }
        // Autres cas
        else {
            ajoutColonne = cellule.value;
        }

        // Calcul de la somme des jours sur le mois pour la prestation actuelle
        SommeLigne(cellule.getAttribute("data-line"));

        // Calcul du %GTA seulement sur les lignes autres que la ligne des absences
        if (cellule.getAttribute("data-line") != 1) {
            CalculPrctGTA(cellule.getAttribute("data-line"));
        }

        // Mise à jour du total pour cette itération
        total = (parseFloat(total) + parseFloat(ajoutColonne)).toFixed(2);
    })

    // Récupération de toutes les cellules (inputs et autres) de la colonne/journée actuelle
    let cellsColonne = document.querySelectorAll("[data-date='" + colonne + "']");

    // Gestion des classes en fonction du total de la colonne
    if (total == 1.00) {
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
    //console.log(cellsColonne)

    // Application des classes pour chaque cellule de la colonne
    cellsColonne.forEach(cellule => {
        cellule.classList.toggle("jourOK", isOK);
        cellule.classList.toggle("work", isWork);
        cellule.classList.toggle("jourWarn", isWarning);
    })
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
        if (elt.nodeName == "DIV") {
            elt.classList.toggle("cellBottom");
        }
    });

}

/**
 * Fonction permettant de calculer le %GTA de la ligne
 * @param {int} ligne Ligne pour laquelle calculer le %GTA
 */
function CalculPrctGTA(ligne) {
    // Récupération de la cellule dans laquelle mettre le résultat
    let cellCible = document.querySelector(".colPrctGTA[data-line='" + ligne + "']");
    // Récupération de la liste de toutes les cellules de pointage du mois
    let listeTousInputs = document.querySelectorAll(".casePointage");
    // Récupération du total de la ligne actuelle
    let totalLigne = document.querySelector(".colTotal[data-line='" + ligne + "']").innerHTML;
    //Initialisation des variables
    let totalMois = 0;
    let totalPrctGTA = 0;
    let ajout;
    // Pour chacunes des cellules de pointage du mois en cours
    listeTousInputs.forEach(cellActu => {
        // Si l'on est pas sur la ligne des absences, que la cellule n'est pas vide ni désactivée
        if (cellActu.getAttribute("data-line") != "1" && cellActu.value != "" && !cellActu.disabled) {
            // On prend sa valeur
            ajout = cellActu.value;
        } else {
            // Sinon on prend 0
            ajout = 0;
        }
        // Mise à jour du totalMois pour cette itération
        totalMois = (parseFloat(totalMois) + parseFloat(ajout)).toFixed(2);
    })

    // Calcul du %GTA
    totalPrctGTA = ((parseFloat(totalLigne) / parseFloat(totalMois)) * 100).toFixed(1);
    // En cas de problème, mise à 0 de la valeur
    if (isNaN(totalPrctGTA)) {
        totalPrctGTA = 0;
    }
    // Affichage du résultat à la bonne place
    cellCible.innerHTML = totalPrctGTA + "%";
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
                }

                ///////////////////////////////////////////////////////////
                //Ajouter Message indiquant la sauvegarde de l'état des préférences ?
                ///////////////////////////////////////////////////////////
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
        return '';
    };

    //Présence de plusieurs virgules
    if (float.match(/,/g) != null) {
        if ((float.match(/,/g)).length > 1) {
            let splitC = float.split(",");
            if (splitC[1].includes(".") || splitC[1] == "") {
                float = splitC[0];
            } else {
                float = splitC[0] + "." + splitC[1];
            }
        };
    };

    //Présence de plusieurs points
    if ((float.match(/\./g)) != null) {
        if ((float.match(/\./g)).length > 1) {
            let splitFS = float.split(".");
            if (splitFS[1].includes(",") || splitFS[1] == "") {
                float = splitFS[0];
            } else {
                float = splitFS[0] + "." + splitFS[1];
            }
        };
    };

    //Index de la première virgule
    const posC = float.indexOf(',');

    if (posC === -1) {
        //Pas de virgule trouvée, traite comme un float
        return float;
    };

    //Index du premier point
    const posFS = float.indexOf('.');

    if (posFS === -1) {
        //Utilise des virgules et pas des points - on les inverse (ex. 1,23 --> 1.23)
        return float.replace(/\,/g, '.');
    };


    //Utilise des virgules et des points - On s'assure que l'ordre est correct on retire les points de séparation des milliers
    return ((posC < posFS) ? (float.replace(/\,/g, '')) : (float.replace(/\./g, '').replace(',', '.')));
};

