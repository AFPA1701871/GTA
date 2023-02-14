/***********************BACK TO TOP ************************/

window.addEventListener("scroll",scrollFunction);
btnBTT = document.getElementById("backToTop");
btnBTT.addEventListener("click",topFunction);

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

checkbox.addEventListener('change', ()=>{
  document.body.classList.toggle('dark');
})