
const sectionSideScroll = document.querySelectorAll('.grid-pointage');
sectionSideScroll.forEach(element =>{
    element.addEventListener("wheel",function (e) {    
        const race = 125;
        if (e.deltaY > 0) {
            sectionSideScroll.forEach(balise => {
                balise.scrollLeft += race;
            })
        }
        else{
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
    var mainGrid = document.querySelector(".mainGrid");
    mainGrid.classList.toggle("grid-col2-extend");
    mainGrid.classList.toggle("grid-col2-reduct");
    colspans = mainGrid.querySelectorAll('.fullLine');
    colspans.forEach(line => {
        line.classList.toggle('grid-columns-span-5');
        line.classList.toggle('grid-columns-span-2');
    })
    grid = mainGrid.querySelectorAll('.grid-presta');
    grid.forEach(subGrid=>{
        subGrid.classList.toggle("grid-5-extend");
        subGrid.classList.toggle("grid-5-reduct");
    });    
    colonneCachable = document.querySelectorAll('.colCachable');
    colonneCachable.forEach(celCache => {
        celCache.classList.toggle('noDisplay');
    });
});

window.addEventListener("load", function setGridPointage(mois, annee){
    var feuilleStyle;
    var indexStyle=0;
    listeStyle=document.styleSheets;
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