
function novaBoja_greska(naziv)
{
    var t = document.getElementById(naziv);
    t.className = 'crvena';
}

function novaBoja_ispravno(naziv)
{
    var t = document.getElementById(naziv);
    t.className = 'zelena';
}


function provjeriUnos(polje)
{
    var vrijednost = polje.value;
    if (vrijednost === "")
    {
        return false;
    }
    return true;
}





function kreirajDogadaj_prijava() {
    var formular = document.getElementById("form1");
    formular.addEventListener("submit", function (event) {
        var porukaPogreske = "";

        for (var i = 0; i < 3; i++)
        {
            novaBoja_ispravno(formular.elements[i].id);
        }

        for (var i = 0; i < formular.elements.length; i++) {
            if (formular.elements[i].type !== "submit") {
                var rezultat = provjeriUnos(formular.elements[i]);
                if (rezultat === false)
                {
                    porukaPogreske += "Greška: Niste unijeli vrijednost za polje " + formular.elements[i].name + "<br>";
                    novaBoja_greska(formular.elements[i].id);
                }
            }
        }



        var kor = document.getElementById("korisnickoime").type;
        if (kor !== "text")
        {
            porukaPogreske += "Greška: Polje 'Korisničko ime' nije tipa text" + "<br>";
            novaBoja_greska("korisnickoime");
        }

        var kor_ime = document.getElementById("korisnickoime").value;
        if (kor_ime.length < 10)
        {
            porukaPogreske += "Greška: 'Korisničko ime' ima manje od 10 znakova" + "<br>";
            novaBoja_greska("korisnickoime");
        }

        if (kor_ime.charCodeAt(0) < 97 || kor_ime.charCodeAt(0) > 122)
        {
            porukaPogreske += "Greška: Vrijednost polja 'Korisničko ime' mora početi malim slovom" + "<br>";
            novaBoja_greska("korisnickoime");
        }

        veliko_slovo = false;
        znakovi = ["_", "-", "!", "#", "$", "?"];
        posebni_znak = 0;
        for (i = 0; i < kor_ime.length; i++)
        {
            if (kor_ime.charAt(i) === kor_ime.charAt(i).toUpperCase() && (kor_ime.charCodeAt(i) > 64 && kor_ime.charCodeAt(i) < 91))
                veliko_slovo = true;
            for (j = 0; j < 6; j++)
            {
                if (kor_ime.charAt(i) === znakovi[j])
                    posebni_znak++;
            }
        }
        if (veliko_slovo === false)
        {
            porukaPogreske += "Greška: 'Korisničko ime' mora sadržavati barem jedno veliko slovo" + "<br>";
            novaBoja_greska("korisnickoime");
        }

        if (posebni_znak < 2)
        {
            porukaPogreske += "Greška: 'Korisničko ime' mora sadržavati barem dva posebna znaka (_, -, !, #, $ ili ?)" + "<br>";
            novaBoja_greska("korisnickoime");
        }


        var lozinka = document.getElementById("lozinka").type;
        if (lozinka !== "password")
        {
            porukaPogreske += "Greška: Polje 'Lozinka' nije tipa password" + "<br>";
            novaBoja_greska("lozinka");
        }

        var lozinka = document.getElementById("lozinka").value;
        if (lozinka.length < 8)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' ima manje od 8 znakova" + "<br>";
            novaBoja_greska("lozinka");
        }

        var veliko_slovo_lozinka = false;
        var malo_slovo_lozinka = false;
        var provjera_broj_lozinka = false;
        var posebni_znak_lozinka = 0;
        znakovi_lozinka = ["!", "#", "$", "?"];
        for (i = 0; i < lozinka.length; i++)
        {
            if (lozinka.charAt(i) === lozinka.charAt(i).toUpperCase() && (lozinka.charCodeAt(i) > 64 && lozinka.charCodeAt(i) < 91))
                veliko_slovo_lozinka = true;
            if (lozinka.charCodeAt(i) > 96 && lozinka.charCodeAt(i) < 123)
                malo_slovo_lozinka = true;
            if (isNaN(lozinka.charAt(i)) === false)
                provjera_broj_lozinka = true;
            for (j = 0; j < 4; j++)
            {
                if (lozinka.charAt(i) === znakovi_lozinka[j])
                    posebni_znak_lozinka++;
            }
        }
        if (veliko_slovo_lozinka === false)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' mora sadržavati velika slova" + "<br>";
            novaBoja_greska("lozinka");
        }
        if (malo_slovo_lozinka === false)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' mora sadržavati mala slova" + "<br>";
            novaBoja_greska("lozinka");
        }
        if (provjera_broj_lozinka === false)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' mora sadržavati brojeve" + "<br>";
            novaBoja_greska("lozinka");
        }
        if (posebni_znak_lozinka === 0)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' mora sadržavati specijalne znakove (!, #, $ ili ?)" + "<br>";
            novaBoja_greska("lozinka");
        }

        var zapamti_me;
        zapamti_me = document.getElementById("check").checked;
        if (zapamti_me === false)
        {
            porukaPogreske += "Greška: Niste unijeli vrijednost za polje zapamti_me" + "<br>";
            novaBoja_greska("label_zapamti_me");
        } else
        {
            novaBoja_ispravno("label_zapamti_me");
        }





        if (porukaPogreske !== "")
        {
            document.getElementById("greske_prijava").innerHTML = porukaPogreske;
            event.preventDefault();
        }

    }
    , false);
}





function kreirajDogadaj_registracija() {
    var formular = document.getElementById("form2");
    formular.addEventListener("submit", function (event) {
        var porukaPogreske = "";

        for (var i = 0; i < 17; i++)
        {
            novaBoja_ispravno(formular.elements[i].id);
        }

        for (var i = 0; i < formular.elements.length; i++) {
            if (formular.elements[i].type !== "submit") {
                var rezultat = provjeriUnos(formular.elements[i]);
                if (rezultat === false)
                {
                    porukaPogreske += "Greška: Niste unijeli vrijednost za polje " + formular.elements[i].name + "<br>";
                    novaBoja_greska(formular.elements[i].id);
                }
            }
        }


        var robot_varijabla;
        robot_varijabla = document.getElementById("robot").checked;
        if (robot_varijabla === false)
        {
            porukaPogreske += "Greška: Niste unijeli vrijednost za polje robot" + "<br>";
            novaBoja_greska("label_robot");
        } else
        {
            novaBoja_ispravno("label_robot");
        }

        var obavijest1 = document.getElementById("obavijesti1").checked;
        var obavijest2 = document.getElementById("obavijesti2").checked;
        if (obavijest1 === false && obavijest2 === false)
        {
            porukaPogreske += "Greška: Niste unijeli vrijednost za polje obavijesti" + "<br>";
            novaBoja_greska("label_obavijesti");
        } else
        {
            novaBoja_ispravno("label_obavijesti");
        }



        var kor = document.getElementById("korisnickoime").type;
        if (kor !== "text")
        {
            porukaPogreske += "Greška: Polje 'Korisničko ime' nije tipa text" + "<br>";
            novaBoja_greska("korisnickoime");
        }

        var kor_ime = document.getElementById("korisnickoime").value;
        if (kor_ime.length < 10)
        {
            porukaPogreske += "Greška: 'Korisničko ime' ima manje od 10 znakova" + "<br>";
            novaBoja_greska("korisnickoime");
        }

        if (kor_ime.charCodeAt(0) < 97 || kor_ime.charCodeAt(0) > 122)
        {
            porukaPogreske += "Greška: Vrijednost polja 'Korisničko ime' mora početi malim slovom" + "<br>";
            novaBoja_greska("korisnickoime");
        }

        veliko_slovo = false;
        znakovi = ["_", "-", "!", "#", "$", "?"];
        posebni_znak = 0;
        for (i = 0; i < kor_ime.length; i++)
        {
            if (kor_ime.charAt(i) === kor_ime.charAt(i).toUpperCase() && (kor_ime.charCodeAt(i) > 64 && kor_ime.charCodeAt(i) < 91))
                veliko_slovo = true;
            for (j = 0; j < 6; j++)
            {
                if (kor_ime.charAt(i) === znakovi[j])
                    posebni_znak++;
            }
        }
        if (veliko_slovo === false)
        {
            porukaPogreske += "Greška: 'Korisničko ime' mora sadržavati barem jedno veliko slovo" + "<br>";
            novaBoja_greska("korisnickoime");
        }

        if (posebni_znak < 2)
        {
            porukaPogreske += "Greška: 'Korisničko ime' mora sadržavati barem dva posebna znaka (_, -, !, #, $ ili ?)" + "<br>";
            novaBoja_greska("korisnickoime");
        }



        var lozinka = document.getElementById("lozinka1").type;
        if (lozinka !== "password")
        {
            porukaPogreske += "Greška: Polje 'Lozinka' nije tipa password" + "<br>";
            novaBoja_greska("lozinka1");
        }

        var lozinka2 = document.getElementById("lozinka2").type;
        if (lozinka2 !== "password")
        {
            porukaPogreske += "Greška: Polje 'Ponovljena lozinka' nije tipa password" + "<br>";
            novaBoja_greska("lozinka2");
        }

        var lozinka = document.getElementById("lozinka1").value;

        if (lozinka.length < 8)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' ima manje od 8 znakova" + "<br>";
            novaBoja_greska("lozinka1");
        }

        var veliko_slovo_lozinka = false;
        var malo_slovo_lozinka = false;
        var provjera_broj_lozinka = false;
        var posebni_znak_lozinka = 0;
        znakovi_lozinka = ["!", "#", "$", "?"];
        for (i = 0; i < lozinka.length; i++)
        {
            if (lozinka.charAt(i) === lozinka.charAt(i).toUpperCase() && (lozinka.charCodeAt(i) > 64 && lozinka.charCodeAt(i) < 91))
                veliko_slovo_lozinka = true;
            if (lozinka.charCodeAt(i) > 96 && lozinka.charCodeAt(i) < 123)
                malo_slovo_lozinka = true;
            if (isNaN(lozinka.charAt(i)) === false)
                provjera_broj_lozinka = true;
            for (j = 0; j < 4; j++)
            {
                if (lozinka.charAt(i) === znakovi_lozinka[j])
                    posebni_znak_lozinka++;
            }
        }
        if (veliko_slovo_lozinka === false)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' mora sadržavati velika slova" + "<br>";
            novaBoja_greska("lozinka1");
        }
        if (malo_slovo_lozinka === false)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' mora sadržavati mala slova" + "<br>";
            novaBoja_greska("lozinka1");
        }
        if (provjera_broj_lozinka === false)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' mora sadržavati brojeve" + "<br>";
            novaBoja_greska("lozinka1");
        }
        if (posebni_znak_lozinka === 0)
        {
            porukaPogreske += "Greška: Polje 'Lozinka' mora sadržavati specijalne znakove (!, #, $ ili ?)" + "<br>";
            novaBoja_greska("lozinka1");
        }



        var ponovljena_lozinka = document.getElementById("lozinka2").value;
        var jednakost = true;
        for (i = 0; i < lozinka.length; i++)
        {
            if (lozinka.charAt(i) !== ponovljena_lozinka.charAt(i))
                jednakost = false;
        }
        if (jednakost === false)
        {
            porukaPogreske += "Greška: Ponovljena lozinka krivo upisana " + "<br>";
            novaBoja_greska("lozinka2");
        }



        var dan = document.getElementById("rodendan").type;
        if (dan !== "number")
        {
            porukaPogreske += "Greška: Polje Datum rođenja nije tipa number" + "<br>";
            novaBoja_greska("rodendan");
        }

        var godina = document.getElementById("godina").type;
        if (godina !== "number")
        {
            porukaPogreske += "Greška: Polje Godina nije tipa number" + "<br>";
            novaBoja_greska("godina");
        }

        if (godina !== "number")
        {
            porukaPogreske += "Greška: Polje Godina nije tipa number" + "<br>";
            novaBoja_greska("godina");
        }

        var datum_rodenja = document.getElementById("rodendan").value;
        if (isNaN(datum_rodenja))
        {
            porukaPogreske += "Greška: Datum rođenja mora biti broj " + "<br>";
            novaBoja_greska("rodendan");
        }
        if (datum_rodenja < 1)
        {
            porukaPogreske += "Greška: Datum rođenja je manji od 1 " + "<br>";
            novaBoja_greska("rodendan");
        }

        var godina_rodenja = document.getElementById("godina").value;
        if (isNaN(godina_rodenja))
        {
            porukaPogreske += "Greška: Godina rođenja mora biti broj " + "<br>";
            novaBoja_greska("godina");
        }
        if ((godina_rodenja < 1931 || godina_rodenja > 2014))
        {
            porukaPogreske += "Greška: Godina rođenja mora biti u rasponu od 1930-2015 " + "<br>";
            novaBoja_greska("godina");
        }

        var mjesec_rodenja = document.getElementById("mjesec_rodenja").value;
        var mjesec = document.getElementById("mjesec");
        odabran_mjesec = false;
        for (i = 0; i < mjesec.options.length; i++)
        {
            if (mjesec.options[i].value === mjesec_rodenja)
                odabran_mjesec = true;
        }
        if (odabran_mjesec === false)
        {
            porukaPogreske += "Greška: Pogrešno unesen mjesec rođenja" + "<br>";
            novaBoja_greska("mjesec_rodenja");
        }



        var tel = document.getElementById("telefon").type;
        if (tel !== "tel")
        {
            porukaPogreske += "Greška: Polje Telefon nije tipa tel" + "<br>";
            novaBoja_greska("telefon");
        }

        var telefon = document.getElementById("telefon").value;
        var ispravan_unos = 0;
        var brojevi = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        for (i = 0; i < 11; i++)
        {
            for (j = 0; j < 10; j++)
            {
                if (telefon.charAt(i) === brojevi[j])
                    ispravan_unos++;
            }
        }
        if (telefon.charAt(3) !== " ")
            ispravan_unos = 0;
        if ((ispravan_unos !== 10) || (telefon.length !== 11))
        {
            porukaPogreske += "Greška: Pogrešno unesen telefonski broj" + "<br>";
            novaBoja_greska("telefon");
        }



        var email = document.getElementById("email").type;
        if (email !== "email")
        {
            porukaPogreske += "Greška: Polje Email nije tipa email" + "<br>";
            novaBoja_greska("email");
        }

        var email = document.getElementById("email").value;
        var brojac_at = 0;
        var brojac_tocka = 0;
        var brojac_tocka_nakon_at = 0;
        var pamti_at = 0;
        var pamti_tocka = 0;
        for (i = 0; i < (email.length); i++)
        {
            if (email.charAt(i) === "@")
            {
                brojac_at++;
                pamti_at = i + 1;
            }
            if (email.charAt(i) === ".")
            {
                brojac_tocka++;
                pamti_tocka = i + 1;
                if (brojac_at !== 0)
                    brojac_tocka_nakon_at++;
            }
        }
        if ((email.charAt(0) === "@") || (email.charAt(0) === ".") || (email.charAt(pamti_at) === ".") || (email.charAt(pamti_tocka) === ""))
            brojac_at = 0;
        if (brojac_at !== 1 || brojac_tocka < 1 || brojac_tocka_nakon_at > 1 || brojac_tocka_nakon_at === 0)
        {
            porukaPogreske += "Greška: Pogrešno unesen email" + "<br>";
            novaBoja_greska("email");
        }



        var lokacija = document.getElementById("lokacija").type;
        if (lokacija !== "textarea")
        {
            porukaPogreske += "Greška: Polje 'Lokacija' nije tipa textarea" + "<br>";
            novaBoja_greska("lokacija");
        }

        var lokacija = document.getElementById("lokacija").value;
        var brojac_tocka = 0;
        var brojac_tocka_zarez = 0;
        var pozicija_tocka_zarez = 0;
        var greska_slovo = 0;
        for (i = 0; i < lokacija.length; i++)
        {
            if (lokacija.charAt(i) === ".")
                brojac_tocka++;
            if (lokacija.charAt(i) === ";")
                brojac_tocka_zarez++;
            if (lokacija.charAt(i) === ";" && brojac_tocka === 1)
                pozicija_tocka_zarez = i;
            if (lokacija.charAt(i) === " ")
            {
                porukaPogreske += "Greška: Polje 'Lokacija' ne smije sadržavati razmak" + "<br>";
                novaBoja_greska("lokacija");
            }
            if ((lokacija.charAt(i) < '0' || lokacija.charAt(i) > '9') && lokacija.charAt(i) !== ";" && lokacija.charAt(i) !== "." && lokacija.charAt(i) !== " ")
            {
                greska_slovo++;
            }
        }

        if (greska_slovo !== 0)
        {
            porukaPogreske += "Greška: Polje 'Lokacija' smije sadržavati samo brojeve" + "<br>";
            novaBoja_greska("lokacija");
        }
        if (brojac_tocka !== 2)
        {
            porukaPogreske += "Greška: U polju 'Lokacija' moraju biti dva decimalna broja" + "<br>";
            novaBoja_greska("lokacija");
        }
        if (brojac_tocka_zarez !== 1)
        {
            porukaPogreske += "Greška: U polju 'Lokacija' decimalni brojevi moraju biti odvojeni jednim znakom ';' " + "<br>";
            novaBoja_greska("lokacija");
        }
        if (pozicija_tocka_zarez === 0 && brojac_tocka_zarez === 1)
        {
            porukaPogreske += "Greška: U polju 'Lokacija' pogrešna pozicija znaka ';' " + "<br>";
            novaBoja_greska("lokacija");
        }


        if (porukaPogreske !== "")
        {
            document.getElementById("greske_registracija").innerHTML = porukaPogreske;
            event.preventDefault();
        }


    }
    , false);

}