
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