// Programme qui permet la gestion de la pagination dans une liste présentée sous forme de grid
nbEltParPage = document.querySelector(".NbEltParPage").innerHTML;
pagination = document.querySelector(".pagination");
grid = document.querySelectorAll(".grid-contenu")[0];
divNbEnreg = document.getElementById("nbEnregs");
var requ = new XMLHttpRequest();
var nbEnreg = 0
pageActive = 1
var arrayConditions = {};
filtreEnCours = false;
AfficherPage(1, true);

function GestionBouton(index) {
    pagination.innerHTML = ""
    nbPages = Math.trunc(nbEnreg / nbEltParPage) + 1
    if (nbPages > 50) {
        nbEltParPage = 200
        nbPages = Math.trunc(nbEnreg / nbEltParPage) + 1
    }
    divNbEnreg.innerHTML = nbEnreg;
    dernierBouton = nbPages.toString();
    AddBouton("<");
    for (let i = 0; i < nbPages; i++) {
        AddBouton(i + 1);
    }
    AddBouton(">");
    ActiveBouton("<", false);
    FocusBouton(index, true);
    if (nbPages == 1) ActiveBouton(">", false);
}
function AddBouton(index) {
    btn = document.createElement("Button");
    btn.name = index;
    btn.innerHTML = index;
    btn.addEventListener("click", ClickBouton);
    pagination.appendChild(btn);
}
function ActiveBouton(index, flag) {
    document.getElementsByName(index)[0].disabled = !flag;
}
function FocusBouton(index, flag) {
    if (flag) {
        document.getElementsByName(index)[0].classList.add("bgc5");
        pageActive = index;
    }
    else
        document.getElementsByName(index)[0].classList.remove("bgc5");
}
function ClickBouton(event) {
    boutonClique = event.target;
    switch (boutonClique.name) {
        case "<":
            index = pageActive * 1 - 1;
            break;
        case ">":
            index = pageActive * 1 + 1;
            break;
        case dernierBouton:
            index = nbPages;
            break;
        default:
            index = boutonClique.name;
            break;
    }
    AfficherPage(index, false);
    ActiveBouton("<", true);
    ActiveBouton(">", true);
    if (index == 1) ActiveBouton("<", false);
    if (index == nbPages) ActiveBouton(">", false);
}
function AfficherPage(index, filtre) {
    // FocusBouton(pageActive, false);
    // FocusBouton(index, true);
    pageActive = index;
    grid.innerHTML = "";
    idEntite = document.querySelector("#idEntite").value;
    if ( idEntite!=0) arrayConditions.idEntite =idEntite;
    var requ2 = new XMLHttpRequest();
    requ2.open('POST', 'index.php?page=ListeAPI', true);
    requ2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // if (filtreEnCours)
    // {
    //     offset =null;// un filtre annule l'offset et la pageActive
    //     pageActive=1;
    // }
    // else
    offset = (pageActive - 1) * nbEltParPage + "," + nbEltParPage;
    args = ("table=" + classe + "&conditions=" + JSON.stringify(arrayConditions) + "&orderBy=" + CreerStringTris() + "&limit=" + offset + "&selection=" + JSON.stringify(selection));
    console.log(args);
    requ2.send(args);
    filtreEnCours = false;
    requ2.onreadystatechange = function (event) {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                console.log(this.responseText);
                reponse = JSON.parse(this.responseText);
                contenu = "";
                nbEnreg = reponse.compte;
                liste = reponse.liste
                // Condition en fonction des pages
                /*exemple */
                if (page == "ListeTypePrestations") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdTypePrestation", element.idTypePrestation);
                        grid.innerHTML = grid.innerHTML.replaceAll("NumeroTypePrestation", element.numeroTypePrestation);
                        grid.innerHTML = grid.innerHTML.replaceAll("LibelleTypePrestation", element.libelleTypePrestation);
                        motif = element.motifRequis == 1 ? "<i class=\"fas fa-check\"></i>" : "";
                        grid.innerHTML = grid.innerHTML.replaceAll("MotifRequis", motif);
                        uo = element.uoRequis == 1 ? "<i class=\"fas fa-check\"></i>" : "";
                        grid.innerHTML = grid.innerHTML.replaceAll("UoRequis", uo);
                        projet = element.projetRequis == 1 ? "<i class=\"fas fa-check\"></i>" : "";
                        grid.innerHTML = grid.innerHTML.replaceAll("ProjetRequis", projet);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListeActivites") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdActivite", element.idActivite);
                        grid.innerHTML = grid.innerHTML.replaceAll("LibelleActivite", element.libelleActivite);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListeEntites") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdEntite", element.idEntite);
                        grid.innerHTML = grid.innerHTML.replaceAll("LibelleEntite", element.libelleEntite);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListeCentres") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdCentre", element.idCentre);
                        grid.innerHTML = grid.innerHTML.replaceAll("NumeroCentre", element.numeroCentre);
                        grid.innerHTML = grid.innerHTML.replaceAll("NomCentre", element.nomCentre);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListeConversions") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdConversion", element.idConversion);
                        grid.innerHTML = grid.innerHTML.replaceAll("NbHeureConversion", element.nbHeureConversion);
                        grid.innerHTML = grid.innerHTML.replaceAll("CoeffConversion", (element.coeffConversion == null ? '' : element.coeffConversion));
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListeFermetures") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdFermeture", element.idFermeture);
                        grid.innerHTML = grid.innerHTML.replaceAll("DateFermeture", new Date(element.dateFermeture).toLocaleDateString('fr-FR', { year: 'numeric', month: '2-digit', day: '2-digit' }));
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListeMotifs") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdMotif", element.idMotif);
                        grid.innerHTML = grid.innerHTML.replaceAll("CodeMotif", element.codeMotif);
                        grid.innerHTML = grid.innerHTML.replaceAll("LibelleMotif", element.libelleMotif);
                        grid.innerHTML = grid.innerHTML.replaceAll("NumeroTypePrestation", element.numeroTypePrestation);
                        grid.innerHTML = grid.innerHTML.replaceAll("LibelleTypePrestation", element.libelleTypePrestation);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListePrestations") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdPrestation", element.idPrestation);
                        grid.innerHTML = grid.innerHTML.replaceAll("CodePrestation", element.codePrestation);
                        grid.innerHTML = grid.innerHTML.replaceAll("LibellePrestation", element.libellePrestation == null ? '' : element.libellePrestation);
                        grid.innerHTML = grid.innerHTML.replaceAll("LibelleActivite", element.libelleActivite);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListeProjets") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdProjet", element.idProjet);
                        grid.innerHTML = grid.innerHTML.replaceAll("CodeProjet", element.codeProjet);
                        grid.innerHTML = grid.innerHTML.replaceAll("LibelleProjet", element.libelleProjet);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListeUos") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdUo", element.idUo);
                        grid.innerHTML = grid.innerHTML.replaceAll("NumeroUo", element.numeroUo);
                        grid.innerHTML = grid.innerHTML.replaceAll("LibelleUo", element.libelleUo == null ? '' : element.libelleUo);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                } else if (page == "ListeUtilisateurs") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("IdUtilisateur", element.idUtilisateur);
                        grid.innerHTML = grid.innerHTML.replaceAll("NomUtilisateur", element.nomUtilisateur);
                        grid.innerHTML = grid.innerHTML.replaceAll("MatriculeUtilisateur", element.matriculeUtilisateur);
                        grid.innerHTML = grid.innerHTML.replaceAll("NomManager", element.nomManager == null ? '' : element.nomManager);
                        actif = element.actif == 1 ? '<i class="fas fa-check"></i>' : "";
                        grid.innerHTML = grid.innerHTML.replaceAll("Actif", actif);
                        grid.innerHTML = grid.innerHTML.replaceAll("NumeroUo", element.numeroUo == null ? '' : element.numeroUo);
                        grid.innerHTML = grid.innerHTML.replaceAll("NomRole", element.nomRole);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                }else if (page == "ListeLogs") {
                    temp = document.getElementsByTagName("template")[0];
                    pair = 0;
                    if (CreerStringTris()=="") 
                    liste.sort(function(a, b)
                    {
                        if ( a.prisEnCompte == b.prisEnCompte)
                        return new Date(a.dateModifiee) - new Date(b.dateModifiee)
                        return a.prisEnCompte -b.prisEnCompte
                    })
                    
                    liste.forEach(element => {
                        pyjama = (++pair % 2 == 0) ? " bgc" : "";
                        contenu = temp.content.cloneNode(true);
                        grid.appendChild(contenu);
                        grid.innerHTML = grid.innerHTML.replaceAll("ActionLog", element.actionLog);
                        newDate = new Date(element.dateModifiee)
                        grid.innerHTML = grid.innerHTML.replaceAll("DateModifiee", newDate.toLocaleDateString('fr-FR', {  year: 'numeric', month: 'short', day: 'numeric' }));
                        prisEnCompte = element.prisEnCompte == 1 ? '<i class="fas fa-check"></i>' : "";
                        grid.innerHTML = grid.innerHTML.replaceAll("PrisEnCompte", prisEnCompte);
                        grid.innerHTML = grid.innerHTML.replaceAll("DateLog", (new Date(element.dateLog)).toLocaleString('fr-FR', { timeZone: 'UTC' }));
                        grid.innerHTML = grid.innerHTML.replaceAll("UserLog", element.userLog);
                        grid.innerHTML = grid.innerHTML.replaceAll("pyjama", pyjama);
                    });
                }


                // grid.innerHTML = contenu;
                if (filtre) {
                    pageActive = 1
                    GestionBouton(1);
                }
                else {
                    pageActive = index
                    GestionBouton(index);
                }
            } else {
                console.log("Status de la réponse: %d (%s)", this.status, this.statusText);
            }
        }
    };
}