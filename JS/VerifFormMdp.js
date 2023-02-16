
/**
 * Change le type de l'input mot de passe
 * @param {boolean} flag 
 */

function affichePassWord(input) {
    inp = input.parentNode.parentNode.querySelector("input");
    console.log(inp.type)
    if (inp.type == "password"){
        inp.type = "text"
    }else if(inp.type == "text"){
        console.log('txt')
        inp.type = "password";
    }
}


/**
 * Annule l'action associé à la touche ou au clic
 * @param {*} event 
 */
function annule(event) {
    event.preventDefault();
}


function checkAllValidity(){
    valider.disabled=false;
    //console.log(tabErreur);
    for (var key in tabErreur) {
        if (tabErreur[key]==0)
        valider.disabled =true;
    }
}

url = window.location.search;

if (url.indexOf("Change") > 0) {
    change = true;
    tabErreur={
        "mdp":0,
        "confirmer":0,
        "email":1
    }
} else {
    change = false;
    tabErreur={
        "mdp":0,
        "email":0,
        "confirmer":1
    }
}
var mdp = document.querySelector('#mdpUser');
var confirmer = document.querySelector('#confirmation');
var email = document.querySelector('#email');
var valider = document.querySelector('#submit');
var erreur = document.querySelector('.erreur');


//gestion de l'oeil dans le mot de passe
var listeOeil = document.getElementsByClassName("oeil");
for (let i = 0; i < listeOeil.length; i++) {
    // on affiche un petit oeil qui permet de voir de mot de passe 
    // listeOeil[i].addEventListener("mousedown", function () {
    //     affichePassWord(listeOeil[i],true);
    // });
    // listeOeil[i].addEventListener("mouseup", function () {
    //     affichePassWord(listeOeil[i],false);
    // });
    //console.log(listeOeil[i]);
    listeOeil[i].addEventListener("click", function () {
        // console.log('click')
        affichePassWord(listeOeil[i]);
    });

}

if (change) { 
    //empecher copier dans champ mdp et confirm/empecher coller dans champ confirm
    mdp.addEventListener('contextmenu', annule);
    confirmer.addEventListener('contextmenu', annule);
    confirmer.addEventListener("paste", annule);
    // affichage de l'aide à la saisie du mot de passe 
    // c'est la 2eme fois que l'on pose un listener sur input de mot de passe, les 2 fonctions vont s'executer l'une derrière l'autre 
    mdp.addEventListener("input", function (event) {
        let aideMdp = document.getElementsByClassName("aideMdp")[0];
        aideMdp.style.display = "flex";
        let lesImages = aideMdp.getElementsByTagName("i");
        let lesCheck = ["([a-zA-Z0-9!@#\$%\^&\*+]{8,})", "(?=.*[A-Z])", "(?=.*[a-z])", "(?=.*[0-9])", "(?=.*[!@#\$%\^&\*+])"];
        for (let i = 0; i < lesCheck.length; i++) {
            if (RegExp(lesCheck[i]).test(mdp.value)) {
                //la condition est vérifiée, on met la coche verte correspondente
                lesImages[i].classList = "fas fa-check-circle fa-green";
            } else {
                lesImages[i].classList = "fas fa-times-circle fa-red";
            }
        }
    });

    //suppression de l'aide mot de passe quand on quitte le champ
    mdp.addEventListener("blur", function (event) {
        document.getElementsByClassName("aideMdp")[0].style.display = "none";
    });

    //gestion particulière de la confirmation de mot de passe

    confirmer.addEventListener("input", function (event) {
        if (confirmer.value != mdp.value) {
            tabErreur["confirmer"] = 0;
        } else {
            isValid = confirmer.checkValidity();
            if (!isValid && confirmer.value == "") {
                tabErreur["confirmer"] = 0;
            }
            else{
                tabErreur["confirmer"] = 1;
            }
            checkAllValidity();
        }
    });
    mdp.addEventListener("input",function (e){
        isValid = mdp.checkValidity();
        if (!isValid || mdp.value == "") {
            tabErreur["mdp"] = 0;
        }
        else{
            tabErreur["mdp"] = 1;
        }
        checkAllValidity();
    });
}
else {
    email.addEventListener("input",function (e){
        isValid = email.checkValidity();
        if (!isValid && email.value == "") {
            tabErreur["email"] = 0;
        }
        else{
            tabErreur["email"] = 1;
        }
        checkAllValidity();
    });
    mdp.addEventListener("input",function (e){
        isValid = mdp.checkValidity();
        if (!isValid && mdp.value == "") {
            tabErreur["mdp"] = 0;
        }
        else{
            tabErreur["mdp"] = 1;
        }
        checkAllValidity();
    });
}