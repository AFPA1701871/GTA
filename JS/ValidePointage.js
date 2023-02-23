btnValide = document.querySelector("#valide");
btnValide.addEventListener("click",valider);
btnRetour = document.querySelector("#retour");
btnRetour.addEventListener("click",retour);


function valider(event)
{
    idUtilisateur = document.querySelector("#idUtilisateur").getAttribute("data-value");
    periode = document.querySelector("#idPeriode").getAttribute("data-value");
    let req = new XMLHttpRequest();
  req.open("POST", "index.php?page=ValidePointageAPI", true); 
  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  args="idUtilisateur=" + idUtilisateur + "&periode=" + periode + "&statut=" + event.target.textContent.substring(1,2);
  req.send(args);
  console.log(args);
  req.onreadystatechange = function (event) {   // Lorsque l'état de la requête change
    if (this.readyState === XMLHttpRequest.DONE) { // Si la requête a bien été executée
      if (this.status === 200) { // Si la requête est réussie
        if (this.responseText) { // Si la réponse n'est pas vide
          console.log(this.responseText);
          window.history.back()
        }}}}
}
function retour()
{
  window.history.back()
}