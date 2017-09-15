/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


poruka = "";
var ime_provjera = false, prezime_provjera = false, kor_provjera = false, sifra_provjera = false, potvrda_sifra_provjera = false, dan_provjera = false, mjesec_provjera = false, godina_provjera = false, mobitel_provjera = false, email_provjera = false, lokacija_provjera = false, robot_provjera = false, korisnicko_provjera = false, lozinka_provjera = false;
if (document.title === "Registracija") {

    document.getElementById("registracija").addEventListener("submit", function (event) {
        var ime = document.getElementById("ime").value;
        var prezime = document.getElementById("prezime").value;
        var korisnicko = document.getElementById("username").value;
        var sifra = document.getElementById("password").value;
        var sifra2 = document.getElementById("password2").value;
        var dan = document.getElementById("dan").value;
        var mjesec = document.getElementById("mjesec").value;
        var godina = document.getElementById("godina").value;
        var mobitel = document.getElementById("mobitel").value;
        var email = document.getElementById("email").value;
        var lokacija = document.getElementById("lokacija").value;

        document.getElementById("greske").innerHTML = poruka;
        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }


        if (ime.length === 0 || prezime.length === 0 || korisnicko.length === 0 || sifra.length === 0 || sifra2.length === 0 || dan.length === 0 || mjesec.length === 0 || godina.length === 0 || mobitel.length === 0 || email.length === 0 || lokacija.length === 0 || robot_provjera === false)
        {
            poruka = document.getElementById("greske").innerHTML;
            poruka += "Neki od elemenata nisu uneseni!<br>";
            document.getElementById("greske").innerHTML = poruka;
            event.preventDefault();
        }
        if (ime_provjera === false || prezime_provjera === false || kor_provjera === false || sifra_provjera === false || potvrda_sifra_provjera === false || dan_provjera === false || mjesec_provjera === false || godina_provjera === false || mobitel_provjera === false || email_provjera === false || lokacija_provjera === false || robot_provjera === false)
        {
            poruka = document.getElementById("greske").innerHTML;
            poruka += "Nisu sva pravila u unosu zadovoljena!<br>";
            document.getElementById("greske").innerHTML = poruka;
            event.preventDefault();
        }
    }, false);

    document.getElementById("ime").addEventListener("blur", function () {
        ime_provjera = false;
        var ime = document.getElementById("ime").value;
        var stanje = document.getElementById("ime");
        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }

        if (ime.length !== 0)
        {
            stanje.className = "ispravno";
            ime_provjera = true;
        } else {
            if (ime.length === 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Morate unijeti vrijednost u polje ime!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
        }
    }, false);

    document.getElementById("prezime").addEventListener("blur", function () {
        prezime_provjera = false;
        var prezime = document.getElementById("prezime").value;
        var stanje = document.getElementById("prezime");
        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }

        if (prezime.length !== 0)
        {
            stanje.className = "ispravno";
            prezime_provjera = true;
        } else {
            if (prezime.length === 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Morate unijeti vrijednost u polje prezime!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
        }
    }, false);

    document.getElementById("username").addEventListener("blur", function () {
        kor_provjera = false;
        var korisnicko = document.getElementById("username").value;
        var stanje = document.getElementById("username");
        var tip = document.getElementById("username").type;


        var pz = "_-!#$?";
        var velikaSlova = "ABCDEFGHIJKLMNOPQRSTUVWYZ";

        document.getElementById("greske").innerHTML = poruka;
        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }

        var praznoMjesto = 0;
        for (i = 0; i < korisnicko.length; i++)
        {
            if (korisnicko[i] === " ")
            {
                praznoMjesto++;
            }
        }

        var brojVelikih = 0;
        for (i = 0; i < korisnicko.length; i++)
            for (j = 0; j < velikaSlova.length; j++)
            {
                if (korisnicko[i] === velikaSlova[j])
                    brojVelikih++;
            }

        var brojPosebnih = 0;
        for (i = 0; i < korisnicko.length; i++)
            for (j = 0; j < pz.length; j++)
            {
                if (korisnicko[i] === pz[j])
                    brojPosebnih++;
            }
        if (korisnicko.length >= 10 && korisnicko[0] === korisnicko[0].toLowerCase() && praznoMjesto === 0 && brojVelikih >= 1 && brojPosebnih >= 2)
        {
            stanje.className = "ispravno";
            kor_provjera = true;
        } else
        {
            if (tip !== "text")
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Korisnicko ime mora biti tipa text!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (korisnicko.length < 10)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Korisnicko ime mora imati minimalno 10 znakova!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }

            if (korisnicko[0] !== korisnicko[0].toLowerCase())
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Korisnicko ime mora početi s malim slovom!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }

            if (brojVelikih < 1)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Korisnicko ime mora imati jedno veliko slovo!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }

            if (brojPosebnih < 2)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Korisnicko ime mora imati dva posebna znaka(!,#,$,?)!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (praznoMjesto > 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Korisničko ime ne smije sadržavati praznine !<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
        }
    }, false);

    document.getElementById("password").addEventListener("blur", function () {
        sifra_provjera = false;
        var sifra = document.getElementById("password").value;
        var stanje = document.getElementById("password");
        var tip = document.getElementById("password").type;

        var pz = "_-!#$?";
        var velikaSlova = "ABCDEFGHIJKLMNOPQRSTUVWYZ";
        var malaSlova = "abcdefghijklmnopqrstuvwyz";
        document.getElementById("greske").innerHTML = poruka;
        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }

        var praznoMjesto = 0;
        for (i = 0; i < sifra.length; i++)
        {
            if (sifra[i] === " ")
            {
                praznoMjesto++;
            }
        }

        var brojVelikih = 0;
        for (i = 0; i < sifra.length; i++)
            for (j = 0; j < velikaSlova.length; j++)
            {
                if (sifra[i] === velikaSlova[j])
                    brojVelikih++;
            }
        var brojMalih = 0;
        for (i = 0; i < sifra.length; i++)
            for (j = 0; j < malaSlova.length; j++)
            {
                if (sifra[i] === malaSlova[j])
                    brojMalih++;
            }
        var brojPosebnih = 0;
        for (i = 0; i < sifra.length; i++)
            for (j = 0; j < pz.length; j++)
            {
                if (sifra[i] === pz[j])
                    brojPosebnih++;
            }
        if (sifra.length >= 8 && praznoMjesto === 0 && brojVelikih >= 1 && brojPosebnih >= 2)
        {
            stanje.className = "ispravno";
            sifra_provjera = true;
        } else
        {
            if (tip !== "password")
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Korisnicko ime mora biti tipa text!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (sifra.length < 8)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Lozinka  mora imati minimalno 8 znakova!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }

            if (brojVelikih < 1)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Lozinka mora imati barem jedno veliko slovo!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }

            if (brojMalih < 1)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Lozinka mora imati barem jedno malo slovo!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }

            if (brojPosebnih < 2)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Lozinka mora imati barem dva posebna znaka(!,#,$,?)!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (praznoMjesto > 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Lozinka ne smije sadržavati praznine !<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
        }
    }, false);

    document.getElementById("password2").addEventListener("blur", function () {
        potvrda_sifra_provjera = false;
        var sifra = document.getElementById("password").value;
        var sifra2 = document.getElementById("password2").value;
        var stanje = document.getElementById("password2");

        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }

        if (sifra2 === sifra && sifra2.length !== 0)
        {
            stanje.className = "ispravno";
            potvrda_sifra_provjera = true;
        } else {
            if (sifra2 !== sifra)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Lozinke moraju biti jednake!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (sifra2.length === 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Potvrda lozinke nije unesena!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
        }
    }, false);

    document.getElementById("dan").addEventListener("blur", function () {
        dan_provjera = false;
        var dan = document.getElementById("dan").value;
        var tip = document.getElementById("dan").type;
        var stanje = document.getElementById("dan");

        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }

        if (tip === "number" && dan > 0 && dan < 31)
        {
            stanje.className = "ispravno";
            dan_provjera = true;
        } else
        {
            if (tip !== "number")
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Dan mora biti tipa number!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (dan < 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Dan mora biti pozitivan!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (dan > 31)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Dan ne moze biti veci od 31!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (dan.length === 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Unesite vrijednost u dan!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
        }
    }, false);

    document.getElementById("mjesec").addEventListener("blur", function () {
        mjesec_provjera = false;
        var stanje = document.getElementById("mjesec");
        var mjesec = document.getElementById("mjesec").value;
        var tip = document.getElementById("Mjeseci").tagName;
        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }
        if (tip === "DATALIST" && mjesec.length !== 0)
        {
            stanje.className = "ispravno";
            mjesec_provjera = true;
        } else
        {
            if (tip !== "DATALIST")
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Mjesec mora biti tipa number!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (mjesec.length === 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Odaberite vrijednost u mjesec!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
        }
    }, false);

    document.getElementById("godina").addEventListener("blur", function () {
        godina_provjera = false;
        var stanje = document.getElementById("godina");
        var godina = document.getElementById("godina").value;
        var tip = document.getElementById("godina").type;

        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }

        if (tip === "number" && godina > 1930 && godina < 2016)
        {
            stanje.className = "ispravno";
            godina_provjera = true;
        } else {
            if (tip !== "number")
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Godina mora biti tipa number!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (godina < 1931)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Godina mora biti veća od 1930!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (godina > 2015)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Godina mora biti manja od 2015!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
        }
    }, false);


    document.getElementById("mobitel").addEventListener("blur", function () {
        mobitel_provjera = false;
        var stanje = document.getElementById("mobitel");
        var mobitel = document.getElementById("mobitel").value;
        var tip = document.getElementById("mobitel").type;

        var nijeBroj = 0;
        var greske = document.getElementById("greske2").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske2").innerHTML = greske;
        }
        if (tip === "tel" && mobitel[3] === " " && mobitel.length === 11 && mobitel[4] !== " " && mobitel[5] !== " " && mobitel[6] !== " " && mobitel[7] !== " " && mobitel[8] !== " " && mobitel[9] !== " " && mobitel[10] !== " " && mobitel[11] !== " " && nijeBroj===0)
        {
            stanje.className = "ispravno";
            mobitel_provjera = true;
        } else {
            if (mobitel.length > 11)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske2").innerHTML;
                poruka += "Prevelik broj unesenih znakova!<br>";
                document.getElementById("greske2").innerHTML = poruka;
            }
            if (mobitel[3] !== " ")
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske2").innerHTML;
                poruka += " Razmak mora biti nakon prva tri broja!<br>";
                document.getElementById("greske2").innerHTML = poruka;

            }
            for (i = 0; i < 3; i++) {
                if (isNaN(mobitel[i]) || mobitel[i] === " ")
                {
                    nijeBroj++;
                }
            }
            for (i = 4; i < 11; i++) {
                if (isNaN(mobitel[i]) || mobitel[i] === " ")
                {
                    nijeBroj++;
                }
            }
            if (nijeBroj !== 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske2").innerHTML;
                poruka += "Svi elementi moraju biti brojevi!<br>";
                document.getElementById("greske2").innerHTML = poruka;
                return false;
            }
        }
    }, false);

    document.getElementById("email").addEventListener("blur", function () {
        email_provjera = false;
        var stanje = document.getElementById("email");
        var email = document.getElementById("email").value;
        var tip = document.getElementById("email").type;

        var at = 0;
        var tocka = 0;
        var indeksAt;
        var indeksTocka;
        var prazanZnak = 0;
        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }
        for (i = 0; i < email.length; i++)
        {
            if (email[i] === "@")
            {
                at++;
                indeksAt = i;
            }
            if (email[i] === ".")
            {
                tocka++;
                indeksTocka = i;
            }
            if (email[i] === " ")
            {
                prazanZnak++;
            }
        }
        if (at === 1 && tocka === 1 && indeksTocka > indeksAt && indeksTocka !== indeksAt + 1 && prazanZnak === 0)
        {
            stanje.className = "ispravno";
            email_provjera = true;
        } else
        {

            if (at !== 1 || tocka !== 1) {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Email mora sadrzavati tocno jedan '@' i '.'!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }

            if (indeksTocka === indeksAt + 1)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += " '@' i '.' ne smiju biti jedno do drugog!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (indeksTocka < indeksAt)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += " Znak '.' ne smije biti ispred znaka '@' !<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (prazanZnak > 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += " Email ne smije sadržavati praznine!<br>";
                document.getElementById("greske").innerHTML = poruka;
            }
        }
    }, false);

    document.getElementById("robot").addEventListener("blur", function () {
        robot_provjera = false;
        var robot = document.getElementById("robot").checked;

        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }
        if (robot === true)
        {
            robot_provjera = true;
        }


    }, false);
    document.getElementById("lokacija").addEventListener("blur", function () {
        lokacija_provjera = false;
        var stanje = document.getElementById("lokacija");
        var lokacija = document.getElementById("lokacija").value;
        var tip = document.getElementById("lokacija").type;

        var dopusteniZnakovi = "123456789.;";
        var latitudeZnakovi = 0;
        var latitudeTocka = 0;
        var longitudeZnakovi = 0;
        var longitudeTocka = 0;
        var greske = document.getElementById("greske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("greske").innerHTML = greske;
        }
        indeks = lokacija.indexOf(";");
        var latitude = lokacija.substring(0, indeks);
        var longitude = lokacija.substring(indeks + 1, lokacija.length);

        var brojac = 0;
        for (i = 0; i < lokacija.length; i++) {
            if (lokacija[i] === ";")
            {
                brojac++;
            }
        }
        for (i = 0; i < latitude.length; i++) {
            if (latitude[i] === ".")
            {
                latitudeTocka++;
            }
        }
        for (i = 0; i < longitude.length; i++) {
            if (longitude[i] === ".")
            {
                longitudeTocka++;
            }
        }
        for (i = 0; i < latitude.length; i++)
            for (j = 0; j < dopusteniZnakovi.length; j++)
            {
                if (latitude[i] === dopusteniZnakovi[j])
                    latitudeZnakovi++;
            }
        for (i = 0; i < longitude.length; i++)
            for (j = 0; j < dopusteniZnakovi.length; j++)
            {
                if (longitude[i] === dopusteniZnakovi[j])
                    longitudeZnakovi++;
            }



        if (tip === "textarea" && brojac === 1 && indeks !== 0 && indeks !== lokacija.length - 1 && latitudeZnakovi === latitude.length && longitudeZnakovi === longitude.length && latitudeTocka <= 1 && longitudeTocka <= 1)
        {
            stanje.className = "ispravno";
            lokacija_provjera = true;
        } else {
            if (brojac !== 1)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Krivi format unosa kordinata<br>";
                document.getElementById("greske").innerHTML = poruka;
            }

            if (indeks === 0 || indeks === (lokacija.length) - 1 && lokacija[0] === ";")
            {

                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Znak ';' ne smije biti na početku ili na kraju <br>";
                document.getElementById("greske").innerHTML = poruka;
            }

            if (latitudeZnakovi !== latitude.length || longitudeZnakovi !== longitude.length)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Duljina i širina moraju biti brojevi <br>";
                document.getElementById("greske").innerHTML = poruka;
            }
            if (latitudeTocka > 1 || longitudeTocka > 1)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("greske").innerHTML;
                poruka += "Smije biti maksimalno jedna točka u duljini i širini ';'<br>";
                document.getElementById("greske").innerHTML = poruka;
            }

        }
    }, false);
}
if (document.title === "Prijava")
{
    document.getElementById("signup").addEventListener("submit", function (event) {
        var korisnicko = document.getElementById("ime").value;
        var sifra = document.getElementById("sifra").value;


        document.getElementById("pogreske").innerHTML = poruka;
        var greske = document.getElementById("pogreske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("pogreske").innerHTML = greske;
        }


        if (korisnicko.length === 0 || sifra.length === 0)
        {
            poruka = document.getElementById("pogreske").innerHTML;
            poruka += "Nisu unesena sva polja!<br>";
            document.getElementById("pogreske").innerHTML = poruka;
            event.preventDefault();
        }
        if (korisnicko_provjera === false || lozinka_provjera === false)
        {
            poruka = document.getElementById("pogreske").innerHTML;
            poruka += "Nisu sva pravila u unosu zadovoljena!<br>";
            document.getElementById("pogreske").innerHTML = poruka;
            event.preventDefault();
        }
    }, false);


    document.getElementById("ime").addEventListener("blur", function () {
        korisnicko_provjera = false;
        var korisnicko = document.getElementById("ime").value;
        var stanje = document.getElementById("ime");
        var tip = document.getElementById("ime").type;


        var pz = "_-!#$?";
        var velikaSlova = "ABCDEFGHIJKLMNOPQRSTUVWYZ";
        var praznoMjesto = 0;

        document.getElementById("pogreske").innerHTML = poruka;
        var greske = document.getElementById("pogreske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("pogreske").innerHTML = greske;
        }
        for (i = 0; i < korisnicko.length; i++)
        {
            if (korisnicko[i] === " ")
            {
                praznoMjesto++;
            }
        }
        var brojVelikih = 0;
        for (i = 0; i < korisnicko.length; i++)
            for (j = 0; j < velikaSlova.length; j++)
            {
                if (korisnicko[i] === velikaSlova[j])
                    brojVelikih++;
            }
        var brojPosebnih = 0;
        for (i = 0; i < korisnicko.length; i++)
            for (j = 0; j < pz.length; j++)
            {
                if (korisnicko[i] === pz[j])
                    brojPosebnih++;
            }
        if (korisnicko.length >= 10 && korisnicko[0] === korisnicko[0].toLowerCase() && praznoMjesto === 0 && brojVelikih >= 1 && brojPosebnih >= 2)
        {
            stanje.className = "ispravno";
            korisnicko_provjera = true;

        } else
        {
            if (tip !== "text")
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka = tip;
                poruka += "Korisnicko ime mora biti tipa text!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }
            if (korisnicko.length < 10)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Korisnicko ime mora imati minimalno 10 znakova!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }

            if (korisnicko[0] !== korisnicko[0].toLowerCase())
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Korisnicko ime mora početi s malim slovom!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }

            if (brojVelikih < 1)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Korisnicko ime mora imati jedno veliko slovo!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }

            if (brojPosebnih < 2)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Korisnicko ime mora imati dva posebna znaka(!,#,$,?)!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }
            if (praznoMjesto > 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Korisničko ime ne smije sadržavati praznine !<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }
        }
    }, false);

    document.getElementById("sifra").addEventListener("blur", function () {
        lozinka_provjera = false;
        var sifra = document.getElementById("sifra").value;
        var stanje = document.getElementById("sifra");
        var tip = document.getElementById("sifra").type;

        var pz = "_-!#$?";
        var velikaSlova = "ABCDEFGHIJKLMNOPQRSTUVWYZ";
        var malaSlova = "abcdefghijklmnopqrstuvwyz";
        document.getElementById("pogreske").innerHTML = poruka;
        var greske = document.getElementById("pogreske").innerHTML;
        if (greske.indexOf(poruka) !== -1)
        {
            greske = greske.replace(poruka, "");
            document.getElementById("pogreske").innerHTML = greske;
        }

        var praznoMjesto = 0;
        for (i = 0; i < sifra.length; i++)
        {
            if (sifra[i] === " ")
            {
                praznoMjesto++;
            }
        }

        var brojVelikih = 0;
        for (i = 0; i < sifra.length; i++)
            for (j = 0; j < velikaSlova.length; j++)
            {
                if (sifra[i] === velikaSlova[j])
                    brojVelikih++;
            }
        var brojMalih = 0;
        for (i = 0; i < sifra.length; i++)
            for (j = 0; j < malaSlova.length; j++)
            {
                if (sifra[i] === malaSlova[j])
                    brojMalih++;
            }
        var brojPosebnih = 0;
        for (i = 0; i < sifra.length; i++)
            for (j = 0; j < pz.length; j++)
            {
                if (sifra[i] === pz[j])
                    brojPosebnih++;
            }
        if (sifra.length >= 8 && praznoMjesto === 0 && brojVelikih >= 1 && brojPosebnih >= 2)
        {
            stanje.className = "ispravno";
            lozinka_provjera = true;
        } else
        {
            if (tip !== "password")
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Korisnicko ime mora biti tipa text!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }
            if (sifra.length < 8)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Lozinka  mora imati minimalno 8 znakova!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }

            if (brojVelikih < 1)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Lozinka mora imati barem jedno veliko slovo!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }

            if (brojMalih < 1)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Lozinka mora imati barem jedno malo slovo!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }

            if (brojPosebnih < 2)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Lozinka mora imati barem dva posebna znaka(!,#,$,?)!<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }
            if (praznoMjesto > 0)
            {
                stanje.className = "neispravno";
                poruka = document.getElementById("pogreske").innerHTML;
                poruka += "Lozinka ne smije sadržavati praznine !<br>";
                document.getElementById("pogreske").innerHTML = poruka;
            }
        }
    }, false);
}