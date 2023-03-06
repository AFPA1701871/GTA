window.addEventListener("load", setGridPointage);
listeLignesPresta = document.querySelectorAll(".expand-line");

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
listeLignesPresta.forEach(LignePresta => {
    LignePresta.addEventListener("click", expand);
});


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


function setGridPointage() {
    selectPeriode = document.querySelector("#periode");
    tabPeriode = selectPeriode.value.split('-');
    annee = tabPeriode[0];
    mois = tabPeriode[1];
    // selectAnnee.addEventListener("change", setGridPointage);
    // selectMois.addEventListener("change", setGridPointage);
    var feuilleStyle = document.querySelector('link[href*=pointage]').sheet.cssRules[0];
    const getDays = (year, month) => {
        return new Date(year, month, 0).getDate();
    }
    const nbreJour = getDays(annee, mois);
    tailleTotal = feuilleStyle.style.getPropertyValue('--width-col-total');
    taillePrct = feuilleStyle.style.getPropertyValue('--width-col-prct');
    tailleJo = feuilleStyle.style.getPropertyValue('--width-col-jo');
    tailleWe = feuilleStyle.style.getPropertyValue('--width-col-we');
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
    feuilleStyle.style.setProperty('--grid-template-columns', theGridTemplateColumnsValue);
};

function ChangeCellule(e) {
    let cell = e.target;
    let ligne = cell.getAttribute("data-line");
    let colonne = cell.getAttribute("data-date");
    cell.value = preformatFloat(cell.value);
    if (isNaN(cell.value) || (cell.value < 0 || cell.value > 1)) {
        cell.value = "";
    }
    if (ligne == 1) {
        MarquageAbsent(colonne, cell.value);
    }
    else {
        SommeColonne(colonne);
    }
    SommeLigne(ligne);
    if (ligne != 1) {
        CalculPrctGTA(ligne);
    }
}

function SommeLigne(ligne) {
    let total = 0;
    // let ligne = e.target.getAttribute("data-line");
    let casesLigne = document.querySelectorAll("input.casePointage[data-line='" + ligne + "']");
    casesLigne.forEach(inputCase => {
        if (inputCase.value != "") {
            ajoutLigne = inputCase.value;
        } else {
            ajoutLigne = 0;
        }
        total = (parseFloat(total) + parseFloat(ajoutLigne)).toFixed(2);
    })
    let caseTotal = document.querySelector("div.colTotal[data-line='" + ligne + "']");
    caseTotal.innerHTML = total;
}

function SommeColonne(colonne) {
    let total = 0;
    let inputsColonne = document.querySelectorAll("input[data-date='" + colonne + "']");
    inputsColonne.forEach(cellule => {
        if (cellule.value == "" || (cellule.getAttribute("data-line") == 1 && cellule.value == 1)) {
            ajoutColonne = 0;
        }
        else {
            ajoutColonne = cellule.value;
        }
        
        // if (cellule.getAttribute("data-line") != 1) {
        //     ajoutColonne = cellule.value;
        // } else {
        //     ajoutColonne = 0;
        // }
        SommeLigne(cellule.getAttribute("data-line"));
        if (cellule.getAttribute("data-line") != 1) {
            CalculPrctGTA(cellule.getAttribute("data-line"));
        }
        total = (parseFloat(total) + parseFloat(ajoutColonne)).toFixed(2);
    })

    let inputAbsJour = document.querySelector("input[data-date='" + colonne + "'][data-line='1']");
    let valueAbsJour=(inputAbsJour!=null)?inputAbsJour.value:0;
    //console.log(valueAbsJour);
    //  if (valueAbsJour != 1) {
        let cellsColonne = document.querySelectorAll("[data-date='" + colonne + "']");

        if (total == 1.00) {
            isOK = true;
            isWork = false;
            isWarning = false;
        } else if (total > 1.00) {
            isOK = false;
            isWork = false;
            isWarning = true;
        } else {
            isOK = false;
            isWork = true;
            isWarning = false;
        }
        //console.log(cellsColonne)
        cellsColonne.forEach(cellule => {
            cellule.classList.toggle("jourOK", isOK);
            cellule.classList.toggle("work", isWork);
            cellule.classList.toggle("jourWarn", isWarning);
        })
    //  }
}

function MarquageAbsent(colonne, valeur) {
    let inputsColonne = document.querySelectorAll("[data-date='" + colonne + "']");
    if (valeur == 1) {
        inputDisabled = true;
    }
    else {
        inputDisabled = false;
    }
    let celAbsActu = document.querySelector("[data-date='" + colonne + "'][data-line='1']")
    celAbsActu.classList.toggle("notApplicable", inputDisabled);
    inputsColonne.forEach(elt => {
        if (elt.getAttribute("data-line") != "1") {            
            elt.value =(valeur==1)?"":elt.value;
            let changeCellEvent= new Event("change")
            elt.dispatchEvent(changeCellEvent);
            elt.disabled = inputDisabled;
            elt.classList.toggle("notApplicable", inputDisabled);
        }
        elt.classList.remove("jourOK");
    });
}

function SelectColonne(e) {
    let colonne = e.target.getAttribute("data-date");
    let inputsColonne = document.querySelectorAll("[data-date='" + colonne + "']");
    inputsColonne.forEach(elt => {
        elt.classList.toggle("colSelected");
        if (elt.nodeName == "DIV") {
            elt.classList.toggle("cellBottom");
        }
    });

}

function CalculPrctGTA(ligne) {
    let cellCible = document.querySelector(".colPrctGTA[data-line='" + ligne + "']");
    let listeTousInputs = document.querySelectorAll(".casePointage");
    let totalLigne = document.querySelector(".colTotal[data-line='" + ligne + "']").innerHTML;
    let totalMois = 0;
    let totalPrctGTA = 0;
    let ajout;
    listeTousInputs.forEach(cellActu => {
        if (cellActu.getAttribute("data-line") != "1" && cellActu.value != "" && !cellActu.disabled) {
            ajout = cellActu.value;
        } else {
            ajout = 0;
        }
        totalMois = (parseFloat(totalMois) + parseFloat(ajout)).toFixed(2);
    })

    totalPrctGTA = ((parseFloat(totalLigne) / parseFloat(totalMois)) * 100).toFixed(1);
    if (isNaN(totalPrctGTA)) {
        totalPrctGTA = 0;
    }
    cellCible.innerHTML = totalPrctGTA + "%";
}

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
                //Ajouter Message indiquant la sauvegarde de l'état des préférences
                ///////////////////////////////////////////////////////////
            }
        }
    };
}

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

