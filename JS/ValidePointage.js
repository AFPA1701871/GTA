btnValide = document.querySelector("#valide");
if (btnValide != null) {
  btnValide.addEventListener("click", valider);
}
btnRetour = document.querySelector("#retour");
if (btnRetour != null) {
  btnRetour.addEventListener("click", retour);
}

/**
 * Fonction permettant de valider un pointage ou d'indiquer qu'il a été repporté sur SIRH
 *
 * @param   {*}  event  Événement déclencheur
 *
 */
function valider(event) {
  // ID du salarié concerné par la synthèse
  idUtilisateur = document.querySelector("#idUtilisateur").getAttribute("data-value");
  // Période visionée
  periode = document.querySelector("#idPeriode").getAttribute("data-value");

  // Requête AJAX de validation/ReportSIRH
  let req = new XMLHttpRequest();
  req.open("POST", "index.php?page=ValidePointageAPI", true);
  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  /**
   * statut:
   *    - "V" pour "Valider" dans le cas d'un manager validant le pointage d'une personne sous sa tutelle
   *    - "R" pour "Reporter dans SIRH" dans le cas d'une assistante
   */
  args = "idUtilisateur=" + idUtilisateur + "&periode=" + periode + "&statut=" + event.target.textContent.substring(1, 2);
  //console.log(args);
  req.send(args);
  req.onreadystatechange = function (event) {   // Lorsque l'état de la requête change
    if (this.readyState === XMLHttpRequest.DONE) { // Si la requête a bien été executée
      if (this.status === 200) { // Si la requête est réussie
        if (this.responseText) { // Si la réponse n'est pas vide
          //console.log(this.responseText);
          if (this.responseText == "Back") {
            // Retour après validation par Manager
            window.history.back();
          }
          if (this.responseText == "Reload"){
            // Rechargement de la page après report SIRH
            window.location.reload(true);
          } 
        }
      }
    }
  }
}

/**
 * Retour sur la page précédente
 *
 */
function retour() {
  let idManager=document.querySelector('input[name="retourManager"]').value;
  let periode = document.querySelector("#idPeriode").getAttribute("data-value");
  window.location.href= "index.php?page=TbManager&idUtilisateur="+idManager+"&periode=" + periode;
}