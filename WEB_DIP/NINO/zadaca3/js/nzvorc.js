
function ImePrezime(inputPolje){
    if(inputPolje.name === "Ime") inputPolje.className="input2";
    else inputPolje.className="input1";
    var element=inputPolje.value;
    if(element[0] !== element[0].toUpperCase()){
       var porukaGreske = document.getElementById("greske1").innerHTML;
       porukaGreske = "Greska: Element " + inputPolje.name + " nema prvo slovo veliko!!! <br />";
       document.getElementById("greske1").innerHTML = porukaGreske;
       return false;
    }
    else{
        var porukaGreske = document.getElementById("greske1").innerHTML;
        for (var i = 0; i < element.length; i++) {
            if(!/^[A-Za-z]+$/.test(element[i])){
                porukaGreske = " ";
                porukaGreske = porukaGreske + "Greska: Element " + inputPolje.name + " ima neke znakove koji nisu slova!!! <br />";
                document.getElementById("greske1").innerHTML = porukaGreske;
                return false;
            }
        }
        porukaGreske = " "; 
    }
    document.getElementById("greske1").innerHTML = porukaGreske;
    return true;
}

function fokusiran(element){
    element.className="fokus";
    return true;
 }

function fokusirann(element){
    element.className="fokuss";
    return true;
}

function odznaci(element){
    if(element.id==="e-mail" || element.id==="telefon" || element.id==="grad")element.className="input3";
    else element.className="input2";
    return true;
}

function odznacii(element){
    element.className="input1";
    return true;
}

function misgore(element){
    element.className="misgore";
    return true;
}

function misdole(element){
    element.className="misdole";
    return true;
}

function korIme(inputPolje){
    inputPolje.className="input2";
    var korisnicko=inputPolje.value;
    var porukaGreske = document.getElementById("greske3").innerHTML;
    if(korisnicko.length < 6){
        porukaGreske = "Greska: Korisnicko ime mora sadrzavati minimalno 6 znakova!!!";
        document.getElementById("greske3").innerHTML = porukaGreske;
         return false;
    }   
    porukaGreske = " ";
    document.getElementById("greske3").innerHTML = porukaGreske;
    return true;
}

function provjeraLozinke(inputPolje1, inputPolje2){
    inputPolje1.className="input2";
    inputPolje2.className="input2";
    var vrijednost1 = inputPolje1.value;
    var vrijednost2 = inputPolje2.value;
    var porukaGreske = document.getElementById("greske2").innerHTML;
    if(vrijednost2.length < 6){
         porukaGreske = "Greska: Lozinke mora sadrzavati minimalno 6 znakova!!!";
         document.getElementById("greske2").innerHTML = porukaGreske;
         return false;
    }
    if(vrijednost1.length !== vrijednost2.length){ 
         porukaGreske = "Greska: Lozinke nisu iste!!";
         document.getElementById("greske2").innerHTML = porukaGreske;
         return false;
    }
    for (var i = 0; i < vrijednost1.length; i++) {
        if(vrijednost1[i] !== vrijednost2[i]){
            porukaGreske = "Greska: Lozinke nisu iste!!";
            return false;
        }
    }
    porukaGreske = " ";
    document.getElementById("greske2").innerHTML = porukaGreske;
    return true;
}

function provjera(e){

    if(e.spol.options[0].selected) {
      var porukaGreske = document.getElementById("greske1").innerHTML;
      porukaGreske = "GRESKA: Niste odabrali spol";
      document.getElementById("greske1").innerHTML = porukaGreske;
      alert("Formular nije ispravno unjet provjeriti gornje greske!! Nije odabrat spol");
      e.spol.focus();
      return false;
    }
    
    if(!ImePrezime(e.ime)) {
      alert("Formular nije ispravno unjet provjeriti gornje greske!!");
      e.ime.focus();
      return false;
    }
    if(!ImePrezime(e.prezime)) {
      alert("Formular nije ispravno unjet provjeriti gornje greske!!");
      e.prezime.focus();
      return false;
    }
    if(!korIme(e.korisnickoIme)){
      alert("Formular nije ispravno unjet provjeriti gornje greske!!");
      e.korisnickoIme.focus();
      return false;
    }
    if(!provjeraLozinke(e.plozinka, e.lozinka)) {
      alert("Formular nije ispravno unjet provjeriti gornje greske!!");
      e.lozinka.focus();
      return false;
    }
    else return true;
}