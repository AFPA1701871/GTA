
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
        listeInput = document.querySelectorAll(".grid-pointage input[data-line='" + ligneActu + "']");
        listeInput.forEach(cell3 => {
            cell3.parentNode.classList.toggle("grid-lineDouble");
            cell3.parentNode.classList.toggle("grid-lineQuad");
        })
    });
})


window.addEventListener("load", setGridPointage);
function setGridPointage() {
    selectPeriode = document.querySelector("#periode");
    tabPeriode=selectPeriode.value.split('-');
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
        if (jourActu.getDay() == 0 || jourActu.getDay() == 6) {
            theGridTemplateColumnsValue += tailleWe + " ";
        }
        else {
            theGridTemplateColumnsValue += tailleJo + " ";
        }
    }
    feuilleStyle.style.setProperty('--grid-template-columns', theGridTemplateColumnsValue);
};

listeCases = document.querySelectorAll('.casePointage');
listeCases.forEach(caseJour => {
    caseJour.addEventListener('change', ChangeCellule);
    caseJour.addEventListener('focus', SelectColonne);
    caseJour.addEventListener('blur', SelectColonne);
}
)
function ChangeCellule(e) {
    let cell = e.target;
    let ligne=cell.getAttribute("data-line");
    let colonne=cell.getAttribute("data-date");
    if (isNaN(parseFloat(cell.value))||(parseFloat(cell.value) < 0 || parseFloat(cell.value) > 1)) {
        cell.value = "";
    }
    if (cell.getAttribute("data-line") == "0-1") {
        MarquageAbsent(colonne, cell.value);
    }
    else {
        SommeColonne(colonne);
    }
    SommeLigne(ligne);
}

function SommeLigne(ligne) {
    // let total = 0;
    // let ligne = e.target.getAttribute("data-line");
    let casesLigne = document.querySelectorAll("input.casePointage[data-line='" + ligne + "']");
    casesLigne.forEach(inputCase => {
        if (inputCase.value != "") {
            ajout = inputCase.value;
        } else {
            ajout = 0;
        }
        total = (parseFloat(total) + parseFloat(ajout)).toFixed(2);
    })
    let caseTotal = document.querySelector("div.colTotal[data-line='" + ligne + "']");
    caseTotal.innerHTML = total;
}

function SommeColonne(colonne) {
    let total = 0;
    let inputsColonne = document.querySelectorAll("input[data-date='" + colonne + "']");
    inputsColonne.forEach(cellule => {
        if (e.target.getAttribute("data-line") != "0-1" && cellule.value != "") {
            ajout = cellule.value;
        } else {
            ajout = 0;
        }
        total = (parseFloat(total) + parseFloat(ajout)).toFixed(2);
    })
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
    cellsColonne.forEach(cellule => {
        cellule.classList.toggle("jourOK", isOK);
        cellule.classList.toggle("work", isWork);
        cellule.classList.toggle("jourWarn", isWarning);
    })
}

function MarquageAbsent(colonne, valeur) {
    let inputsColonne = document.querySelectorAll("[data-date='" + colonne + "']");
    if (valeur == 1) {
        inputDisabled = true;
    }
    else {
        inputDisabled = false;
    }
    e.target.classList.toggle("notApplicable", inputDisabled);
    inputsColonne.forEach(elt => {
        if (elt.getAttribute("data-line") != "0-1") {
            elt.value = "";
            elt.disabled = inputDisabled;
            elt.classList.toggle("notApplicable", inputDisabled);
        }
    });
}

function SelectColonne(e){
    let colonne = e.target.getAttribute("data-date");
    let inputsColonne = document.querySelectorAll("[data-date='" + colonne + "']");
    console.log(inputsColonne);
    inputsColonne.forEach(elt => {
        elt.classList.toggle("colSelected");
        if(elt.nodeName=="DIV")
        {
            elt.classList.toggle("cellBottom");
        }
    });

}

function CalculPrctGTA(e){
    let ligne=e.target.getAttribute("data-line");
    let cellCible=document.querySelector(".colPrctGTA[data-line='"+ligne+"']");
    let listeTousInputs=document.querySelectorAll(".inputPointage");
    let listeInputsPresta=document.querySelectorAll(".inputPointage[data-line='"+ligne+"']");
    let totalLigne=0;
    let totalMois=0;
    let ajout;
    listeInputsPresta.forEach(cellLigne=>{
        if(cellLigne.value!=""){
            ajout=cellLigne.value;
        }else{
            ajout=0;
        }
        totalLigne=(parseFloat(totalLigne) + parseFloat(ajout)).toFixed(2);
    })


}