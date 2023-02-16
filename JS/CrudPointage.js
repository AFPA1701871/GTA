var idUser = document.getElementById("IdUtilisateur").innerHTML;
var inputs = document.querySelectorAll(".case");

// On ajoute un evenement sur toutes les cases de pointage qui se déclanche lorsque la valeur de la case change
inputs.forEach((element) => {
  element.addEventListener("change", changePointage);
});

function changePointage(event) {
  let pointage = event.target; // Case de pointage changée
  let idPointage = pointage.id; // Id de le la case
  let ligne = pointage.dataset.line; // Dataset contenant le typePrestation suivit de la prestation
  let lignes = ligne.split("-"); // Separation des deux valeurs du data-line
  let typePrestation = lignes[0]; // Prepière valeur du dataset
  let date = pointage.dataset.date; // Dataset contenant la date en format (YYYY-MM-DD)

  // Récupération des ID de la ligne
  let uo = document.querySelector('input[data-line="' + ligne + '"][name="idUo"]').value; 
  let motif = document.querySelector('input[data-line="' + ligne + '"][name="idMotif"]').value;
  let projet = document.querySelector('input[data-line="' + ligne + '"][name="idProjet"]').value;
  let prestation = document.querySelector('input[data-line="' + ligne + '"][name="idPrestation"]').value;
console.log("uo ", uo, "motif ", motif, "projet ", projet, "prestation ", prestation);
  let req = new XMLHttpRequest();
  req.open("POST", "index.php?page=MAJPointageAPI", true); // Initialisation de la requête avec une methode POST et le chemin de la page de traitement
  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  // Preparation des arguments qui seront envoyé par POST à la page de traitement
  let args = "idUO=" + uo + "&idMotif=" + motif + "&idProjet=" + projet + "&idPrestation=" + prestation + "&idTypePrestation=" + typePrestation + "&datePointage=" + date + "&idUtilisateur=" + idUser + "&nbHeuresPointage=" + pointage.value;

  if (idPointage) args += "&idPointage=" + idPointage; // Si la case possède déjà un ID
  req.send(args);


  req.onreadystatechange = function (event) {   // Lorsque l'état de la requête change
    if (this.readyState === XMLHttpRequest.DONE) { // Si la requête a bien été executée
      if (this.status === 200) { // Si la requête est réussie
        if (this.responseText) { // Si la réponse n'est pas vide
          let id = (this.responseText).replace(/"/g, ""); // Enlève les "" de l'id récupéré car reçu en JSON
          pointage.setAttribute("id", id); // Change l'attribut ID de la case
        }
      }
    }
  };
}