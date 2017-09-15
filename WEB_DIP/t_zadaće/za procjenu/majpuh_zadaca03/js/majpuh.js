
function kreirajNoviPr() {
    var forma = document.getElementById("novi_proizvod");
    var greske = document.getElementById("greske");
    var timer = null;
    
    
    var time = new Date();
    var minutes = time.getMinutes();
   
    

    forma.addEventListener("submit", function (event) {
        greske.innerHTML = "";
        if (!provjeriNaziv() || !provjeriOpis() || !provjeriDatum() || !provjeriKategorije()
                || !provjeriKol() || !provjeriVrijeme())
            event.preventDefault();


        if (minutes > 300000) {

            document.getElementById("nazivPr").disabled = true;
            document.getElementById("opisPr").disabled = true;
            document.getElementById("datumPr").disabled = true;
            document.getElementById("vrijemePr").disabled = true;
            document.getElementById("kolicinaPr").disabled = true;
            document.getElementById("tezina").disabled = true;
            document.getElementById("knjige").disabled = true;
            document.getElementById("instrumenti").disabled = true;
            document.getElementById("ostalo").disabled = true;
            document.getElementById("posalji").disabled = true;
            document.getElementById("resetiraj").disabled = true;
            document.getElementById("osvjezi").style.display = 'inline';
            
           clearTimeout(timer);
        }


        document.getElementById("osvjezi").addEventListener("click", function (event) {
            window.location.reload();
        }, false);
    }, false);

}

function provjeriUnos(naziv) {
    var uzorak = new RegExp(/[(){}'!#\/\"]/);
    var ok = uzorak.test(naziv.value);
    if (!ok)
    {
        return true;
    } else {
        return false;
    }
}

function provjeriNaziv() {
    var naziv = document.getElementById("nazivPr");
    var duljina = naziv.value.length;
    var greske = document.getElementById("greske");
    var usklicnikGreske = document.getElementById("nazivGreske");
    greske.innerHTML = "";

    var pocetnoSlovo = new RegExp("^[A-Z]");
    var prvo = pocetnoSlovo.test(naziv.value);

    if (provjeriUnos(naziv) === false) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "U nazivu postoje nedopusteni znakovi!";
        return false;
    }
    if (duljina < 5) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "U nazivu nema minimalni broj znakova!";
        return false;
    } else if (prvo === false) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "Početno slovo naziva nije veliko!";
        return false;
    } else {
        usklicnikGreske.className = "usklicnik";
        return true;
    }
}

document.getElementById("nazivPr").addEventListener("keydown", provjeriNaziv(), false);

function provjeriOpis() {
    var nazivOpis = document.getElementById("opisPr");
    var greske = document.getElementById("greske");
    var usklicnikGreske = document.getElementById("opisGreske");

    var unos = nazivOpis.value.split(".");
    var minRecenica = new RegExp("^[A-Z](\w*\s*){1,}\.");

    var x = 0;
    for (var i = 0; i < unos.length - 1; i++) {
        var valja = minRecenica.test(unos[i].trim());
        if (valja)
            x++;
    }

    if (provjeriUnos(nazivOpis) === false) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "U opisu postoje nedopusteni znakovi!";
        return false;
    }

    if (x < 3) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "U opisu nema minimalan broj recenica!";
        return false;
    } else {
        usklicnikGreske.className = "usklicnik";
        return true;
    }
}

function provjeriKategorije() {
    var knjige = document.getElementById("knjige");
    var instrumenti = document.getElementById("instrumenti");
    var ostalo = document.getElementById("ostalo");
    var greske = document.getElementById("greske");
    var usklicnikGreske = document.getElementById("kategorijeGreske");

    if (knjige.checked === false && instrumenti.checked === false && ostalo.checked === false) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "Obavezno oznaciti kategoriju! ";
        return false;
    } else {
        usklicnikGreske.className = "usklicnik";
        return true;
    }
}

function provjeriDatum() {
    var datum = document.getElementById("datumPr");
    var greske = document.getElementById("greske");
    var usklicnikGreske = document.getElementById("datumGreske");

    var datumFormat = new RegExp(/(\d{2}\.){2}\d{4}/);
    var valja = datumFormat.test(datum.value);

    var danas = new Date();
    var dan = danas.getDate();
    var mj = danas.getMonth() + 1;
    var god = danas.getFullYear();
    if (dan < 10) {
        dan = '0' + dan;
    }
    if (mj < 10) {
        mj = '0' + mj;
    }
    var podijeliDatum = datum.value.split(".");

    if (provjeriUnos(datum) === false) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "U opisu postoje nedopusteni znakovi!";
        return false;
    }

    if (valja === false) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "Datum nije u dobrom formatu!";
        return false;
    } else if ((podijeliDatum[2] === god && podijeliDatum[1] === mj && podijeliDatum[0] >= dan)
            || (podijeliDatum[2] === god && podijeliDatum[1] > mj)
            || podijeliDatum[2] > god) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "Datum mora biti manji od trenutnog!";
        return false;
    } else {
        usklicnikGreske.className = "usklicnik";
        return true;
    }
}

function provjeriVrijeme() {
    var vrijeme = document.getElementById("vrijemePr");
    var greske = document.getElementById("greske");
    var usklicnikGreske = document.getElementById("vrijemeGreske");

    if (vrijeme.value === "") {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "Obavezan unos vremena!";
        return false;
    } else if (provjeriUnos(vrijeme) === false) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "U polju vrijeme postoje nedopusteni znakovi!";
        return false;
    } else {
        usklicnikGreske.className = "usklicnik";
        return true;
    }
}

function provjeriKol() {
    var kolicina = document.getElementById("kolicinaPr");
    var greske = document.getElementById("greske");
    var usklicnikGreske = document.getElementById("kolGreske");

    if (kolicina.value === "") {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "Obavezan unos kolicine!";
        return false;
    }
    if (provjeriUnos(kolicina) === false) {
        usklicnikGreske.className = "usklicnikIma";
        greske.innerHTML += "U polju kolicina postoje nedopusteni znakovi!";
        return false;
    } else {
        usklicnikGreske.className = "usklicnik";
        return true;
    }
}
