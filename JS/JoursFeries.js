var save = document.querySelector('#ajoutJoursFeries');
var input = save.previousElementSibling;

save.addEventListener('click', ajoutJoursFeries);

function ajoutJoursFeries()
{
    save = document.querySelector('#ajoutJoursFeries');
    input = save.previousElementSibling;

    var requ = new XMLHttpRequest();
    requ.open('POST', 'index.php?page=MAJJoursFeriesAPI', true);
    requ.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    args = 'AnneeJoursFeries=' + input.value;
    requ.send(args);
    console.log(requ);

    requ.onreadystatechange = function (event) {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                window.location = 'index.php?page=ListeFermetures';
            }
        }
    }
}