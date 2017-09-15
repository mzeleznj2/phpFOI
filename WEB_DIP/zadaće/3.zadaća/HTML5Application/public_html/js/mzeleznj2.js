window.onload = function() {
    var greske = document.getElementById("greske");
    var forma = document.getElementById("form1");
    var proizvod = document.getElementById("proizvod");
    var opis = document.getElementById("opis");
    var datum = document.getElementById("datum");
    var vrijeme = document.getElementById("vrijeme");
    var kolicina = document.getElementById("kolicina");
    var tezina = document.getElementById("tezina");
    var kategorija = document.getElementById("kategorija");
    var vrijemePocetka = new Date();
    var postojeGreske = false;
    var poruke = [];
    var osvjezi = document.getElementById("osvjezi");


    function ispisiGreske() {
        greske.innerHTML = "";

        postojeGreske = false;

        for (i in poruke) {
            if( poruke[i][0] !== null ) {

                greske.innerHTML += "<div>" + poruke[i][0] + "</div>";

                if( poruke[i][1] !== null ) {                   
                    poruke[i][1].getElementsByTagName("label")[0].classList.add("greska");
                }               
                postojeGreske = true;
           
            } else {               
                poruke[i][1].getElementsByTagName("label")[0].classList.remove("greska");
            }
        }
   
        poruke = [];
    }

    osvjezi.addEventListener("click", function(e) {      
        location.reload();
    });


    document.getElementById("proizvod-input").addEventListener("keyup", function(e) {  
        if( document.getElementById("proizvod-input").value.charAt(0) !== document.getElementById("proizvod-input").value.charAt(0).toUpperCase() ) {
            poruke[2] = ['Ime proizvoda mora početi s velikim početnim slovom!', proizvod];

        } else if( document.getElementById("proizvod-input").value.length < 5 ) {
            poruke[3]  = ['Ime proizvoda mora sadržavat barem 5 znakova!', proizvod];

        } else {
            poruke[2] = [null, proizvod];
            poruke[3] = [null, proizvod];
        }

        ispisiGreske();
    });


    forma.addEventListener("submit", function (e) {
        e.preventDefault();
      
        if( new Date().getTime() > vrijemePocetka.getTime() + (5 * 60 * 1000) ) {

            document.getElementById("proizvod-input").setAttribute("disabled", "disabled");
            document.getElementById("opis-input").setAttribute("disabled", "disabled");
            document.getElementById("datum-input").setAttribute("disabled", "disabled");
            document.getElementById("vrijeme-input").setAttribute("disabled", "disabled");
            document.getElementById("kolicina-input").setAttribute("disabled", "disabled");
            document.getElementById("tezina-input").setAttribute("disabled", "disabled");
            document.getElementById("kategorija-input").setAttribute("disabled", "disabled");
            document.getElementById("submit1").setAttribute("disabled", "disabled");
            document.getElementById("reset1").setAttribute("disabled", "disabled");

            document.getElementById("osvjezi").style.display = "inline-block";
   
            poruke[0] = ["Vrijeme je isteklo. Osvježite stranicu!", null];

            ispisiGreske();

            return;
        }

        //PROIZVOD
       
        if( document.getElementById("proizvod-input").value === "" ) {
            poruke[0] = ["Ime proizvoda ne smije biti prazno!", proizvod];

        } else if( document.getElementById("proizvod-input").value.charAt(0) !== document.getElementById("proizvod-input").value.charAt(0).toUpperCase() ) {
            poruke[1] = ['Ime proizvoda mora početi s velikim početnim slovom!', proizvod];

        } else if( document.getElementById("proizvod-input").value.length < 5 ) {
            poruke[2]  = ['Ime proizvoda mora sadržavat barem 5 znakova!', proizvod];

        } else if( /["(){}'#\\/]/.test(document.getElementById("proizvod-input").value) ) {
            poruke[3] = ["U imenu proizvoda se ne smiju nalazit znakovi: (){}'!#\“\/", proizvod];

        } else {
            poruke[0] = [null, proizvod];
            poruke[1] = [null, proizvod];
            poruke[2] = [null, proizvod];
            poruke[3] = [null, proizvod];
        }

       /*
        *   OPIS
        */
      
        opisSplit = document.getElementById("opis-input").value.split(".");
        opisGreska = false;
        for( i = 0; i < opisSplit.length - 1; i++ ) {
            if( !/([A-Z0-9])|([ A-Z0-9])$/.test(opisSplit[i]) ) {
                opisGreska = true;
            }
        }
       
        if( document.getElementById("opis-input").value === "" ) {
            poruke[4] = ["Opis ne smije biti prazan!", opis];

        } else if( /["(){}'#\\/]/.test(document.getElementById("opis-input").value) ) {
            poruke[5] = ["U opisu se ne smiju nalazit znakovi: (){}'!#\“\/", opis];

        } else if( opisSplit.length < 4 ) {
            poruke[6] = ["Trebaju biti minmalno tri rečenice u opisu proizvoda!", opis];

        } else if( opisGreska ) {
            poruke[7] = ["Početak rečenice mora imati veliko početno slovo u opisu proizvoda!", opis];

        } else {
            poruke[4] = [null, opis];
            poruke[5] =  [null, opis];
            poruke[6] = [null, opis];
            poruke[7] = [null, opis];
        }

        /*
         * Datum proizvodnje
         */
     
        euDatum = document.getElementById("datum-input").value.split('.').reverse().join('-');
        usDatum = new Date(euDatum);
     
        if( document.getElementById("datum-input").value === "" ) {
            poruke[8] = ["Datum ne smije biti prazan!", datum];
     
        } else if( document.getElementById("datum-input").getAttribute("type") !== "text" ) {
            poruke[9] = ["Datum mora biti tipa tekst!", datum];

        } else if( !/^(\d{2})(\.)(\d{2})(\.)(\d{4})\.$/.test(document.getElementById("datum-input").value) ) {
            poruke[10] = ["Datum mora biti formata: dd.mm.gggg", datum];
        
        } else if( usDatum > new Date() ) {
            poruke[11] = ["Datum mora biti manji ili jednak od trenutnog datuma!", datum];

        } else {
            poruke[8] = [null, datum];
            poruke[9] = [null, datum];
            poruke[10] = [null, datum];
            poruke[11] = [null, datum];
        }

        /*
         * Vrijeme proizvodnje
         */

        if( document.getElementById("vrijeme-input").value === "" ) {
            poruke[12] = ["Vrijeme ne smije biti prazno!", vrijeme];
        } else {
            poruke[12] = [null, vrijeme];
        }

        /*
         * Kolicina proizvoda
         */

        // ako je kolicina prazna
        if( document.getElementById("kolicina-input").value === "" ) {
            poruke[13] = ["Količina ne smije biti prazna!", kolicina];
        } else {
            poruke[13] = [null, kolicina];
        }

        /*
         * Tezina proizvoda
         */

        if( document.getElementById("tezina-input").value === "0"  ) {
            poruke[14] = ["Težina ne smije biti 0(nula)!", tezina];
        } else {
            poruke[14] = [null, tezina];
        }

        /*
         * Kategorija proizvoda
         */

        if( document.getElementById("kategorija-input").value === "" ) {
            poruke[15] = ["Morate odabrati barem jednu kategoriju!", kategorija];
        } else {
            poruke[15] = [null, kategorija];
        }

        ispisiGreske();
    
        if(!postojeGreske) {
            this.submit();
        }
    });
};