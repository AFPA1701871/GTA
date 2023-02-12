
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


document.querySelector('#btnMasque').addEventListener('click', function (e) {

    var btn = e.target;
    btn.classList.toggle("fa-expand");
    btn.classList.toggle("fa-contract");
    colonneCachable = document.querySelectorAll('.colCachable');
    colonneCachable.forEach(celCache => {
        celCache.classList.toggle('noDisplay');
    });
});

listeLignesPresta = document.querySelectorAll("expand-line");
console.log(listeLignesPresta);
// Array.from(listeLignesPresta).forEach(LignePresta => {
//     LignePresta.addEventListener("click", function (e) {
//         ligne = e.target.parentNode;
//         console.log(ligne.getElementsByClassName("colCachable"))
//         listeCol = ligne.querySelectorAll("colCachable");
//         console.log(ligne);
//         console.log(ligne.querySelectorAll("colCachable"));
//         listeCol.forEach(cell => {
//             cell.classList.toggle("noDisplay");
//         });

//     });
// })


window.addEventListener("load", function setGridPointage(mois, annee) {
    var feuilleStyle;
    var indexStyle = 0;
    listeStyle = document.styleSheets;
    console.log(listeStyle);
    // listeStyle.forEach(element => {
    //     lien=element.href.split('/');
    //     if(lien[lien.length-1]=="pointage.css"){
    //         feuilleStyle=document.styleSheets[indexStyle];
    //         indexStyle++;
    //     }
    // });
    // nbreJour=new Date(mois-1, annee, 0).getDate();
    // tailleTotal=rootEl.style.getPropertyValue('--width-col-total');
    // taillePrct=rootEl.style.getPropertyValue('--width-col-prct');
    // tailleJo=rootEl.style.getPropertyValue('--width-col-jo');
    // tailleWe=rootEl.style.getPropertyValue('--width-col-we');
    // theGridTemplateColumnsValue=tailleTotal+" "+taillePrct+" 0.1fr ";
    // for (let jour = 1; jour <=nbreJour; jour++) {
    //     jourActu=new Date(annee, mois-1, jour);
    //     if(jourActu.getDay()==0||jourActu.getDay()==6){
    //         theGridTemplateColumnsValue+=tailleWe+" ";
    //     }
    //     else{
    //         theGridTemplateColumnsValue+=tailleJo+" ";
    //     }
    // }
    console.log(feuilleStyle);
    // rootEl.style.setProperty('--grid-template-columns', theGridTemplateColumnsValue);
});