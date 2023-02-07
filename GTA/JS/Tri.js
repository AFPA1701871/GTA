// Programme qui permet la gestion des tris dans une liste présentée sous forme de grid
//On récupère les entêtes de liste
entetes = document.querySelectorAll(".labelListe");
// On ajoute les flèches de tri
entetes.forEach(element => {
    fleches = document.createElement("i");
    fleches.classList.add("fa-solid");
    fleches.classList.add("fa-sort");
    fleches.classList.add("estompe");
    fleches.addEventListener("click", ClickFleche);
    element.appendChild(fleches);
    //<i class="fa-solid fa-arrow-down-a-z estompe"><i class="fa-thin fa-1 fa-xs"></i></i>
});
// gestion des tris
var tris = [];
var nbTris = 0;


function ClickFleche(event) {
    fleche = event.target
    if (fleche.classList.contains("fa-thin") ) // si on clique sur le numero de tris, on remonte vers la fleche
        fleche=fleche.parentNode;
    if (fleche.classList.contains("fa-sort")) {
        if (nbTris==0) tris=[];
        fleche.classList.add("fa-arrow-down-a-z");
        fleche.classList.remove("fa-sort");
        fleche.classList.remove("estompe");
        tris.push(new Array(fleche.parentNode.dataset.name, "az"));
        nbTris++;
        numero = document.createElement("i");
        numero.classList.add("fa-thin");
        numero.classList.add("fa-" + nbTris);
        numero.classList.add("fa-xs");
        fleche.appendChild(numero);
    }
    else if (fleche.classList.contains("fa-arrow-down-a-z")) {
        fleche.classList.add("fa-arrow-down-z-a");
        fleche.classList.remove("fa-arrow-down-a-z");
        position = tris.findIndex(element => element[0] == fleche.parentNode.dataset.name);
        tris[position][1] = "za";
    }
    else if (fleche.classList.contains("fa-arrow-down-z-a")) {
        fleche.classList.remove("fa-arrow-down-z-a");
        fleche.classList.add("fa-sort");
        fleche.classList.add("estompe");
        fleche.removeChild(fleche.firstChild);
        position = tris.findIndex(element => element[0] == fleche.parentNode.dataset.name);
        tris.splice(position, 1);
        nbTris--;
    }
    CreerStringTris();
    AfficherPage(pageActive,false);
}
function CreerStringTris() {
    stringTri = "";
    for (let i = 0; i < tris.length; i++) {
        stringTri += tris[i][0] + " ";
        if (tris[i][1] == "za")
            stringTri += "desc ";
        stringTri +=", ";
    }
    if (stringTri.length >2 ) stringTri=stringTri.substring(0,stringTri.length-2);
    console.log(stringTri);
    return stringTri;
}