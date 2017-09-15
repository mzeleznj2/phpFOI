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



    function ispisiGreske() {
        // brise html unutar div greske taga
        greske.innerHTML = "";

        // oznacuje da greske ne postoje
        postojeGreske = false;

        for (i in poruke) {
            // ako postoje greske u "poruke" variabli; ispisuje greske
            if( poruke[i][0] !== null ) {

                // ubacuje html greske
                greske.innerHTML += "<div>" + poruke[i][0] + "</div>";

                // ako postoji label element
                if( poruke[i][1] !== null ) {
                    // dodaje klasu "greske" label tagu
                    poruke[i][1].getElementsByTagName("label")[0].classList.add("greska");
                }
                // oznacuje da greske postoje
                postojeGreske = true;

            // ako ne postoje greske u "poruke" variabli; brise greske
            } else {
                // brise klasu "greske" label tagu
                poruke[i][1].getElementsByTagName("label")[0].classList.remove("greska");
            }
        }

        // resetira poruke gresaka
        poruke = [];
    }



    // dodaj listener za osvjezi gumbic
    osvjezi.addEventListener("click", function(e) {
        // osvjezava(refresh) stranicu
        location.reload();
    });



    // dodaj listener za ime proizvoda
    document.getElementById("proizvod-input").addEventListener("keyup", function(e) {
        // ako proizvod ima prvo pocetno slovo
        if( document.getElementById("proizvod-input").value.charAt(0) !== document.getElementById("proizvod-input").value.charAt(0).toUpperCase() ) {
            poruke[2] = ['Ime proizvoda mora početi s velikim početnim slovom!', proizvod];

            // ako proizvod ima 5 ili vise znakova
        } else if( document.getElementById("proizvod-input").value.length < 5 ) {
            poruke[3]  = ['Ime proizvoda mora sadržavat barem 5 znakova!', proizvod];

        } else {
            poruke[2] = [null, proizvod];
            poruke[3] = [null, proizvod];
        }

        // ispisi greske
        ispisiGreske();
    });



    // dodaj listener za formu
    forma.addEventListener("submit", function (e) {
        // onemougcimo opcenitu akciju za prosljedivanje forme
        e.preventDefault();

        // provjerava ako je proslo 5 minuta od otvaranja stranice
        if( new Date().getTime() > vrijemePocetka.getTime() + (5 * 60 * 1000) ) {

            // iskljuci(disable) sva polja
            document.getElementById("proizvod-input").setAttribute("disabled", "disabled");
            document.getElementById("opis-input").setAttribute("disabled", "disabled");
            document.getElementById("datum-input").setAttribute("disabled", "disabled");
            document.getElementById("vrijeme-input").setAttribute("disabled", "disabled");
            document.getElementById("kolicina-input").setAttribute("disabled", "disabled");
            document.getElementById("tezina-input").setAttribute("disabled", "disabled");
            document.getElementById("kategorija-input").setAttribute("disabled", "disabled");
            document.getElementById("submit1").setAttribute("disabled", "disabled");
            document.getElementById("reset1").setAttribute("disabled", "disabled");

            // prikazi osvjezi gumbic
            document.getElementById("osvjezi").style.display = "inline-block";

            // dodaj poruku greske
            poruke[0] = ["Vrijeme je isteklo. Osvježite stranicu!", null];

            // ispisi greske
            ispisiGreske();

            // daljnji kod se ne izvrsava; potrebno je osvjezit stranicu
            return;
        }


        /*
         * provjerava dali su svi podaci ispravno uneseni
         */

        /*
         * Ime proizvoda
         */

        // ako je proizvod prazan
        if( document.getElementById("proizvod-input").value == "" ) {
            poruke[0] = ["Ime proizvoda ne smije biti prazno!", proizvod];

        // ako proizvod ima prvo pocetno slovo
        } else if( document.getElementById("proizvod-input").value.charAt(0) !== document.getElementById("proizvod-input").value.charAt(0).toUpperCase() ) {
            poruke[1] = ['Ime proizvoda mora početi s velikim početnim slovom!', proizvod];

        // ako proizvod ima 5 ili vise znakova
        } else if( document.getElementById("proizvod-input").value.length < 5 ) {
            poruke[2]  = ['Ime proizvoda mora sadržavat barem 5 znakova!', proizvod];

        // ako proizvod ima (){}'!#“\/ znakove
        } else if( /["(){}'#\\/]/.test(document.getElementById("proizvod-input").value) ) {
            poruke[3] = ["U imenu proizvoda se ne smiju nalazit znakovi: (){}'!#\“\/", proizvod];

        } else {
            poruke[0] = [null, proizvod];
            poruke[1] = [null, proizvod];
            poruke[2] = [null, proizvod];
            poruke[3] = [null, proizvod];
        }


        /*
         * Opis proizvoda
         */

        // potrebno za provjeru 3 recenice i pocetno veliko slovo recenice
        opisSplit = document.getElementById("opis-input").value.split(".");
        opisGreska = false;
        for( i = 0; i < opisSplit.length - 1; i++ ) {
            if( !/([A-Z0-9])|([ A-Z0-9])$/.test(opisSplit[i]) ) {
                opisGreska = true;
            }
        }

        // ako je opis prazan
        if( document.getElementById("opis-input").value == "" ) {
            poruke[4] = ["Opis ne smije biti prazan!", opis];

        // ako opis ima (){}'!#“\/ znakove
        } else if( /["(){}'#\\/]/.test(document.getElementById("opis-input").value) ) {
            poruke[5] = ["U opisu se ne smiju nalazit znakovi: (){}'!#\“\/", opis];

        // ako opis ima 3 tocke(recenice)
        } else if( opisSplit.length < 4 ) {
            poruke[6] = ["Trebaju biti minmalno tri rečenice u opisu proizvoda!", opis];

        // ako opis ima svaku recenicu s velikim pocetnim slovom
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

        // potrebno pretvoit EU standard u US standard datuma kako bi se mogle koristit usporedbe
        euDatum = document.getElementById("datum-input").value.split('.').reverse().join('-');
        usDatum = new Date(euDatum);

        // ako je datum prazan
        if( document.getElementById("datum-input").value == "" ) {
            poruke[8] = ["Datum ne smije biti prazan!", datum];

         // ako je datum tipa tekst
        } else if( document.getElementById("datum-input").getAttribute("type") !== "text" ) {
            poruke[9] = ["Datum mora biti tipa tekst!", datum];

         // ako je datum ispravno upisan
        } else if( !/^(\d{2})(\.)(\d{2})(\.)(\d{4})$/.test(document.getElementById("datum-input").value) ) {
            poruke[10] = ["Datum mora biti formata: dd.mm.gggg", datum]

        // ako je datum manji ili jednak danasnjem danu
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

        // ako je vrijeme prazno
        if( document.getElementById("vrijeme-input").value == "" ) {
            poruke[12] = ["Vrijeme ne smije biti prazno!", vrijeme];
        } else {
            poruke[12] = [null, vrijeme];
        }


        /*
         * Kolicina proizvoda
         */

        // ako je kolicina prazna
        if( document.getElementById("kolicina-input").value == "" ) {
            poruke[13] = ["Količina ne smije biti prazna!", kolicina];
        } else {
            poruke[13] = [null, kolicina];
        }


        /*
         * Tezina proizvoda
         */

        // ako je tezina 0(nula)
        if( document.getElementById("tezina-input").value == "0"  ) {
            poruke[14] = ["Težina ne smije biti 0(nula)!", tezina];
        } else {
            poruke[14] = [null, tezina];
        }


        /*
         * Kategorija proizvoda
         */

        // ako je oznacena bar jedna opcija za kategoriju
        if( document.getElementById("kategorija-input").value == "" ) {
            poruke[15] = ["Morate odabrati barem jednu kategoriju!", kategorija];
        } else {
            poruke[15] = [null, kategorija];
        }

        /* ZAVRSENE SVE PROVJERE */


        // ispisi sve greske
        ispisiGreske();

        // ako ne postoje greske pokreni formu
        if(!postojeGreske) {
            this.submit();
        }
    });
}