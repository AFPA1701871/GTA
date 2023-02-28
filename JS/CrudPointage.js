var idUser = document.getElementById("IdUtilisateur").innerHTML;
var inputs = document.querySelectorAll(".case");

// On ajoute un evenement sur toutes les cases de pointage qui se déclanche lorsque la valeur de la case change
inputs.forEach((element) => {
  element.addEventListener("change", changePointage);
});

listePlus = document.querySelectorAll(".fa-plus");
listePlus.forEach(element => {
  element.addEventListener("click", clicPlus);
});


function changePointage(event) {
  let pointage = event.target; // Case de pointage changée
  let idpointage = pointage.getAttribute('data-idpointage');// Id de le la case
  let ligne = pointage.dataset.line; // Dataset contenant le numero de la prestation
  let date = pointage.dataset.date; // Dataset contenant la date en format (YYYY-MM-DD)

  // Récupération des différents ID de la ligne
  let typePrestation = document.querySelector('input[data-line="' + ligne + '"][name="idTypePrestation"]').value;
  let uo = document.querySelector('input[data-line="' + ligne + '"][name="idUo"]').value;
  let motif = document.querySelector('input[data-line="' + ligne + '"][name="idMotif"]').value;
  let projet = document.querySelector('input[data-line="' + ligne + '"][name="idProjet"]').value;
  let prestation = document.querySelector('input[data-line="' + ligne + '"][name="idPrestation"]').value;

  let valeur=preformatFloat(pointage.value);
  if(valeur<0 || valeur>1){
    valeur=0;
  }

  // Requête
  let req = new XMLHttpRequest();
  req.open("POST", "index.php?page=MAJPointageAPI", true); // Initialisation de la requête avec une methode POST et le chemin de la page de traitement
  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  // Preparation des arguments qui seront envoyé par POST à la page de traitement
  let args = "idUo=" + uo + "&idMotif=" + motif + "&idProjet=" + projet + "&idPrestation=" + prestation + "&idTypePrestation=" + typePrestation + "&datePointage=" + date + "&idUtilisateur=" + idUser + "&nbHeuresPointage=" + valeur;

  if (idpointage) args += "&idPointage=" + idpointage; // Si la case possède déjà un ID
  req.send(args);
  console.log(args);

  req.onreadystatechange = function (event) {   // Lorsque l'état de la requête change
    if (this.readyState === XMLHttpRequest.DONE) { // Si la requête a bien été executée
      if (this.status === 200) { // Si la requête est réussie
        if (this.responseText) { // Si la réponse n'est pas vide
          console.log(this.responseText);
          let id = (this.responseText).replace(/"/g, ""); // Enlève les "" de l'id récupéré car reçu en JSON
          pointage.setAttribute("data-idpointage", idpointage); // Change l'attribut ID de la case

        }
      }
    }
  };
  // si c'est le 1er pointage d'une prestation
  // on transforme les select en input
  if (document.querySelector('select[data-line="' + ligne + '"][name="idPrestation"]') != undefined)
    SelectToInput("Prestation", ligne);
  SelectToInput("Motif", ligne);
  SelectToInput("Uo", ligne);
  SelectToInput("Projet", ligne);
}

/**
 * Méthode qui permet d'ajouter une ligne lorsque l'on clique sur le plus à coté du type de Prestations
 * @param {*} event 
 */
function clicPlus(event) {
  plus = event.target;
  idTypePrestation = plus.parentNode.getAttribute("data-idtypeprestation");
  condition = {}
  // on clone le template
  temp = document.querySelector("#lignePresta");
  contenu = temp.content.cloneNode(true);
  // on insert avant le prochain type
  plus.parentNode.parentNode.insertBefore(contenu, plus.parentNode.nextElementSibling.nextElementSibling);
  nouvelleLigne = plus.parentNode.nextElementSibling.nextElementSibling

  /**  on modifie l'élément insérer */
  nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="idTypePrestation">', '<input name="idTypePrestation" type=hidden value="' + idTypePrestation + '"  dataline >');


  // mis à jour liste presta
  condition['idTypePrestation'] = idTypePrestation;
  selectPresta = AppelAjax("View_TypePrestations", null, ["CodePrestation", "LibellePrestation"], "class=inputPointage dataline", true, condition);
  nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replace('<input name="idPrestation">', selectPresta + '<input type=hidden name=idPrestation dataline >');

  // mis à jour disabled dans motif/projet/uo
  typePrestation = AppelAjax("TypePrestations", idTypePrestation, null, "", false, null)[0];
  selectUo = (typePrestation.uoRequis == 1) ? AppelAjax("Uos", null, ["NumeroUo", "LibelleUo"], 'class="" dataline ', true, null) + '<input  class="inputPointage notApplicable" dataline  type="hidden" name="idUo" disabled>' : '<input class="inputPointage notApplicable" dataline  type="text" name="idUo" disabled>';
  selectProjet = (typePrestation.projetRequis == 1) ? AppelAjax("Projets", null, ["CodeProjet"], 'class="" dataline ', true, null) + '<input class="inputPointage notApplicable" dataline  type="hidden" name="idProjet" disabled>' : '<input class="inputPointage notApplicable" dataline  type="text" name="idProjet" disabled>';
  selectMotif = (typePrestation.motifRequis == 1) ? AppelAjax("Motifs", null, ["CodeMotif"], 'class="" dataline ', true, null) + '<input class="inputPointage notApplicable" dataline  type="hidden" name="idMotif" disabled>' : '<input class="inputPointage notApplicable" dataline  type="text" name="idMotif" disabled>';
  nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="inputUo">', selectUo);
  nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="inputProjet">', selectProjet);
  nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('<input name="inputMotif">', selectMotif);

  // trouver data-line
  numPresta = (document.querySelector("#numPrestaMax").value) * 1 + 1
  console.log(numPresta);
  document.querySelector("#numPrestaMax").value = numPresta
  nouvelleLigne.innerHTML = nouvelleLigne.innerHTML.replaceAll('dataline=""', 'data-line="' + numPresta + '"');


  /**  mettre les cases */
  // on sélectionne une ligne de case de pointage et on la duplique
  gridpointage = document.querySelectorAll(".grid-pointage")[1].cloneNode(true);
  // on l'ajoute à la dom
  plus.parentNode.parentNode.insertBefore(gridpointage, plus.parentNode.nextElementSibling.nextElementSibling.nextElementSibling);
  nouvellecasePointage = plus.parentNode.nextElementSibling.nextElementSibling.nextElementSibling;

  // on remet les pointages à "" et on met le bon data-line
  //les inputs
  for (let i = 3; i < nouvellecasePointage.children.length; i++) {
    const element = nouvellecasePointage.children[i];
    //element est une div. on modifie l'input à l'intérieur
    if (element.children.length > 0) {
      element.children[0].value = "";
      element.children[0].setAttribute("data-line", numPresta);
      element.children[0].setAttribute("data-idPointage", "");
      // ajouter les evenements sur les cases
      element.children[0].addEventListener("change", changePointage);
      element.children[0].addEventListener('change', ChangeCellule);
      element.children[0].addEventListener('focus', SelectColonne);
      element.children[0].addEventListener('blur', SelectColonne);
      element.children[0].addEventListener("wheel", scrollHoriz);
    }
    //le total et le pourcentage
    // nouvellecasePointage.children[0].innerHtml="";
    nouvellecasePointage.children[0].setAttribute("data-line", numPresta);
    // nouvellecasePointage.children[1].innerHtml="";
    nouvellecasePointage.children[1].setAttribute("data-line", numPresta);
    //Remise à zéro des colonnes Total et pourcentage
    SommeLigne(numPresta);
    CalculPrctGTA(numPresta);

    /* evenement*/
    //on ajoute l'evenement pour expand
    nouvelleLigne.querySelector(".expand-line").addEventListener("click", expand);
    nouvelleLigne.querySelector(".expand-line").dispatchEvent(new Event("click"));
    //on ajoute l'evenement pour favoris
    nouvelleLigne.querySelector(".fa-fav").addEventListener("click", UpdateFav);
    // on ajoute des evenements pour reporter les elements selectionner dans les combo dans les input correspondants
    nouvelleLigne.querySelector('select[name="idPrestation"]').addEventListener("change", reportPrestation);
    if (nouvelleLigne.querySelector('select[name="idMotif"]')) nouvelleLigne.querySelector('select[name="idMotif"]').addEventListener("change", reportSelect);
    if (nouvelleLigne.querySelector('select[name="idProjet"]')) nouvelleLigne.querySelector('select[name="idProjet"]').addEventListener("change", reportSelect);
    if (nouvelleLigne.querySelector('select[name="idUo"]')) nouvelleLigne.querySelector('select[name="idUo"]').addEventListener("change", reportSelect);
  }
}
/**
 * Méthode d'appel ajax synchrone
 * @param {*} table  // nom de la table pour la requete
 * @param {*} id // valeur de l'id soit à selectionner pour un select soit pour le where dans les listes
 * @param {*} colonne // colonnes à renvoyer tableau attendu
 * @param {*} attribut // attribut à ajouter sur le select
 * @param {*} select // boolean vaut vrai pour un select faux pour une liste
 * @returns 
 */
function AppelAjax(table, id, colonne, attribut, select, condition) {
  var req = new XMLHttpRequest();
  req.open('POST', 'index.php?page=ListePointageAPI', false); // false signifie appel synchrone
  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  args = "table=" + table + "&id=" + id + "&colonne=" + JSON.stringify(colonne) + "&attribut=" + attribut + "&select=" + select + "&condition=" + JSON.stringify(condition);
  console.log(args);
  req.send(args);
  if (req.status === 200) {
    console.log(req.responseText);
    if (!select)
      return JSON.parse(req.responseText);
    return req.responseText;
  }
}

function reportPrestation(event) {
  ligne = event.target.parentNode.parentNode
  ligne.querySelector('input[name="idPrestation"]').value = event.target.value
  ligne.querySelector('input[name="codePrestation"]').value = event.target.selectedOptions[0].label.substring(0, 4)
  condition = {}
  condition["idPrestation"] = event.target.value
  // report du projet pour MNSP
  projet = AppelAjax("View_Prestations", null, ["idProjet", "codeProjet", "libelleProjet"], null, false, condition)
  if (projet != false) {
    ligne.querySelector('input[name="idProjet"]').value = projet[0].idProjet
    ligne.querySelector('select[name="idProjet"]').value = projet[0].idProjet
  }
}

function reportSelect(event) {
  type = event.target.name.substring(2);
  elementCherche = 'input[name="id' + type + '"]'
  ligne = event.target.parentNode.parentNode
  ligne.querySelector(elementCherche).value = event.target.value
}

function SelectToInput(type, ligne) {
  condSource = 'select[data-line="' + ligne + '"][name="id' + type + '"]'
  classe = (type == "Prestation") ? "" : "inputPointage"
  source = document.querySelector(condSource);
  if (source != null) {
    valeur = (source.value != "") ? source.selectedOptions[0].label : "";
    cible = '<input class="' + classe + '" data-line="' + ligne + '" type="text" name="input' + type + '" value="' + valeur + '" disabled="" title=""></input>';
    input = document.createElement("input")
    input.innerHTML = cible
    source.parentNode.replaceChild(input.children[0], source)
  }

}