
const sectionSideScroll = document.querySelectorAll('.grid-pointage');
sectionSideScroll.forEach(element => {
    element.addEventListener("wheel", function (e) {
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
    })
})

listeLignesPresta = document.querySelectorAll(".expand-line");
listeLignesPresta.forEach(LignePresta => {
    LignePresta.addEventListener("click", function (e) {
        e.target.classList.toggle("fa-open");
        e.target.classList.toggle("fa-close");
        ligne = e.target.parentNode.parentNode.parentNode;
        listeCol = ligne.querySelectorAll(".colCachable");
        listeCol.forEach(cell => {
            cell.classList.toggle("noDisplay");
        });
        ligneActu = ligne.getAttribute("data-Line");
        selectLine = document.querySelectorAll("div[data-line='" + ligneActu + "']");
        selectLine.forEach(cell2 => {
            cell2.classList.toggle("grid-lineDouble");
            cell2.classList.toggle("grid-lineQuad");
        })
    });
})


window.addEventListener("load", setGridPointage);
function setGridPointage() {
    selectAnnee = document.querySelector("#anneeVisionne");
    selectMois = document.querySelector("#moisVisionne");
    annee = selectAnnee.value;
    mois = selectMois.value;
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
        if (jourActu.getDay() == 0 || jourActu.getDay() == 6) {
            theGridTemplateColumnsValue += tailleWe + " ";
        }
        else {
            theGridTemplateColumnsValue += tailleJo + " ";
        }
    }
    feuilleStyle.style.setProperty('--grid-template-columns', theGridTemplateColumnsValue);
    divPointage = document.querySelector(".grid-pointage.pointMove");
    barresTitre = divPointage.querySelectorAll(".titreTypePrestation");
    classe = "grid-columns-span-" + (nbreJour + 3);
    barresTitre.forEach(barre => {
        switch (nbreJour) {
            case 28:
                barre.classList.add("grid-columns-span-31");
                barre.classList.remove("grid-columns-span-32");
                barre.classList.remove("grid-columns-span-33");
                barre.classList.remove("grid-columns-span-34");
                break;
            case 29:
                barre.classList.add("grid-columns-span-32");
                barre.classList.remove("grid-columns-span-31");
                barre.classList.remove("grid-columns-span-33");
                barre.classList.remove("grid-columns-span-34");
                break;
            case 30:
                barre.classList.add("grid-columns-span-33");
                barre.classList.remove("grid-columns-span-31");
                barre.classList.remove("grid-columns-span-32");
                barre.classList.remove("grid-columns-span-34");
                break;
            case 31:
                barre.classList.add("grid-columns-span-34");
                barre.classList.remove("grid-columns-span-31");
                barre.classList.remove("grid-columns-span-32");
                barre.classList.remove("grid-columns-span-33");
                break;
            default:
                break;
        }
    })

};

listeCases = document.querySelectorAll('.casePointage');
listeCases.forEach(caseJour => {
    caseJour.addEventListener('change', ChangeCellule)
}
)
function ChangeCellule(e) {
    ligne = e.target.getAttribute("data-line");
    casesLigne = document.querySelectorAll("input.casePointage[data-line='" + ligne + "']");
    if (e.target.getAttribute("data-line") == "0-1") {
        MarquageAbsent(e, e.target.value);
    }
    else {
        SommeColonne(e);
    }
    SommeLigne(e);
}

function SommeLigne(e) {
    total = 0;
    casesLigne.forEach(inputCase => {
        if (inputCase.value != "") {
            ajout = inputCase.value;
        } else {
            ajout = 0;
        }
        total = (parseFloat(total) + parseFloat(ajout)).toFixed(2);
    })
    ligne = e.target.getAttribute("data-line");
    caseTotal = document.querySelector("div.colTotal[data-line='" + ligne + "']");
    caseTotal.innerHTML = total;
}

function SommeColonne(e) {
    total = 0;
    colonne = e.target.getAttribute("data-date");
    inputsColonne = document.querySelectorAll("[data-date='" + colonne + "']");
    inputsColonne.forEach(cellule => {
        if (e.target.getAttribute("data-line") != "0-1" && cellule.value != "") {
            ajout = cellule.value;
        } else {
            ajout = 0;
        }
        total = (parseFloat(total) + parseFloat(ajout)).toFixed(2);
    })
    console.log(total);
    if (total == 1.00) {
        inputsColonne.forEach(cellule => {
            console.log("ok");
            cellule.parentNode.classList.add("jourOK");
        })
    }
}

function MarquageAbsent(e, valeur) {
    colonne = e.target.getAttribute("data-date");
    inputsColonne = document.querySelectorAll("[data-date='" + colonne + "']");
    if (valeur == 1) {
        inputDisabled = true;
        if (!(e.target.classList.contains("notApplicable"))) {
            e.target.classList.add("notApplicable");
        }
    }
    else {
        inputDisabled = false;
        if ((e.target.classList.contains("notApplicable"))) {
            e.target.classList.remove("notApplicable");
        }
    }
    inputsColonne.forEach(elt => {
        if (elt.getAttribute("data-line") != "0-1") {
            elt.value = "";
            elt.disabled = inputDisabled;
        }
    })
}