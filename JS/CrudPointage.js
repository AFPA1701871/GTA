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

saveMessage()
function saveMessage(){
  let alert = document.querySelector('.alert')
  alert.classList.add('active')
  setTimeout(function(){
    alert.classList.remove('active')
  }, 1000)
}


function changePointage(event) {
  let pointage = event.target; // Case de pointage changée
  let idpointage = pointage.getAttribute('data-idpointage'); // Id de le la case
  let ligne = pointage.dataset.line; // Dataset contenant le typePrestation suivit de la prestation
  let lignes = ligne.split("-"); // Separation des deux valeurs du data-line
  let typePrestation = lignes[0]; // Prepière valeur du dataset
  let date = pointage.dataset.date; // Dataset contenant la date en format (YYYY-MM-DD)

  // Récupération des différents ID de la ligne
  let uo = document.querySelector('input[data-line="' + ligne + '"][name="idUo"]').value; 
  let motif = document.querySelector('input[data-line="' + ligne + '"][name="idMotif"]').value;
  let projet = document.querySelector('input[data-line="' + ligne + '"][name="idProjet"]').value;
  let prestation = document.querySelector('input[data-line="' + ligne + '"][name="idPrestation"]').value;

  // Requête
  let req = new XMLHttpRequest();
  // Initialisation de la requête avec une methode POST et le chemin de la page de traitement
  req.open("POST", "index.php?page=MAJPointageAPI", true);
  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  // Preparation des arguments qui seront envoyé par POST à la page de traitement
  let args = "idUO=" + uo + "&idMotif=" + motif + "&idProjet=" + projet + "&idPrestation=" + prestation + "&idTypePrestation=" + typePrestation + "&datePointage=" + date + "&idUtilisateur=" + idUser + "&nbHeuresPointage=" + pointage.value;

  if (idpointage) args += "&idPointage=" + idpointage; // Si la case possède déjà un ID
  req.send(args);


  req.onreadystatechange = function (event) {   // Lorsque l'état de la requête change
    if (this.readyState === XMLHttpRequest.DONE) { // Si la requête a bien été executée
      if (this.status === 200) { // Si la requête est réussie
        
        if (this.responseText) { // Si la réponse n'est pas vide
          let idpointage = (this.responseText).replace(/"/g, ""); // Enlève les "" de l'id récupéré car reçu en JSON
          pointage.setAttribute("data-idpointage", idpointage); // Change l'attribut ID de la case
        }
      }
    }
  };
}

function clicPlus(event)
{
  plus= event.target;
  // on clone le template
  temp = document.querySelector(".templatePresta");
  contenu = temp.content.cloneNode(true);
  // on insert avant le prochain type
    plus.parentNode.insertAdjacentElement("afterend",contenu);
  // on modifie l'élément insérer 
  
  // mis à jour data-line
  // mis à jour liste presta
  // mis à jour disabled dans motif/projet/uo
    grid.innerHTML = grid.innerHTML.replaceAll("IdTypePrestation", element.idTypePrestation);
                        
}