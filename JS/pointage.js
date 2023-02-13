
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
    selectAnnee.addEventListener("change", setGridPointage);
    annee = selectAnnee.value;
    selectMois = document.querySelector("#moisVisionne");
    selectMois.addEventListener("change", setGridPointage);
    mois = selectMois.value;
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

