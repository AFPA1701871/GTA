/***********************BACK TO TOP ************************/

window.addEventListener("scroll", scrollFunction);
btnBTT = document.getElementById("backToTop");
btnBTT.addEventListener("click", topFunction);

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    btnBTT.style.display = "block";
  } else {
    btnBTT.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

/***********************darkmode ************************/
const checkbox = document.getElementById('checkbox');
if (sessionStorage.getItem('darkmode') === 'true') {
  checkbox.checked = true
  document.body.classList.add('dark');
} else {
  checkbox.checked = false
  document.body.classList.remove('dark');
}

checkbox.addEventListener('change', () => {
  document.body.classList.toggle('dark');
  if (checkbox.checked) {
    sessionStorage.setItem("darkmode", "true");
  } else {
    sessionStorage.setItem("darkmode", "false");
  }
})

// 
/* gestion combo periode */
comboPeriode = document.querySelector("#periode");
if (comboPeriode != null) {
  comboPeriode.addEventListener("change", function (event) {
    url = new URL(window.location.href);
    idUser = url.searchParams.get('idUtilisateur')
    if (idUser == null)
      window.location.href = "index.php?page=" + url.searchParams.get('page') + "&periode=" + event.target.value;
    else
      window.location.href = "index.php?page=" + url.searchParams.get('page') + "&idUtilisateur=" + idUser + "&periode=" + event.target.value;
  })
}

comboUser = document.querySelector("#idUser");
if(comboUser!=null){
  comboUser.addEventListener("change", changePageSynthese);
}
function changePageSynthese(){
  url = new URL(window.location.href);
  if (comboUser.value!="" && comboUser.value!=url.searchParams.get('idUtilisateur'))
  {
    idUser = comboUser.value;
  }
  else{
    idUser = url.searchParams.get('idUtilisateur');
  }
  window.location.href = "index.php?page=" + url.searchParams.get('page') + "&idUtilisateur=" + idUser + "&periode=" + comboPeriode.value;
}

/**************************************************************************/
/* Script pour affichage des totaux en titre de colonne dans TbAssistante */
/**************************************************************************/

if(window.location.href.indexOf("TbAssistante")>-1){
  let titreSaisis = document.querySelector('[id="titreSaisis"]');
  let titreValides = document.querySelector('[id="titreValides"]');
  let titreReportes = document.querySelector('[id="titreReportes"]');
  let totalAgents = document.querySelector('input[name="totalAgents"]').value;
  let totalSaisis = document.querySelector('input[name="totalRemplis"]').value;
  let totalValides = document.querySelector('input[name="totalValides"]').value;
  let totalReportes = document.querySelector('input[name="totalReportes"]').value;
  titreSaisis.innerHTML+="<br />"+totalSaisis+"/"+totalAgents;
  titreValides.innerHTML+="<br />"+totalValides+"/"+totalAgents;
  titreReportes.innerHTML+="<br />"+totalReportes+"/"+totalAgents;
}