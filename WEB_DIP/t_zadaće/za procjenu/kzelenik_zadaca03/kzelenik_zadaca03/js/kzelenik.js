function unos(event) {
    var naziv = document.Form1.nazivp.value;
    var opis = document.Form1.opisp.value;
	var datum = document.Form1.datump.value;
	var vrijeme = document.Form1.vrijemep.value;
	var kolicina = document.Form1.kolicinap.value;
	var tezina = document.Form1.tezinap.value;

    if (naziv === "") {
        greskaUnosa("Naziv", "!   Morate unijeti sve podatke za Naziv!");
        event.preventDefault();
        return false;
	}
	else
	{
		greskaUnosa("Naziv", "");
	}
	if(opis === "")
	{
		greskaUnosa("Opis", "!   Morate unijeti sve podatke za Opis!");
		event.preventDefault();
        return false;
	}
	else
	{
		greskaUnosa("Opis", "");
	}
	if( datum === "")
	{
		greskaUnosa("Datum", "!   Morate unijeti sve podatke za Datum!");
		event.preventDefault();
        return false;
	}
	else
	{
		greskaUnosa("Datum", "");
	}
	if( vrijeme === "")
	{
		greskaUnosa("Vrijeme", "!   Morate unijeti sve podatke za Vrijeme!");
		event.preventDefault();
        return false;
	}
	else
	{
		greskaUnosa("Vrijeme", "");
	}
	if(kolicina === "" )
	{
		greskaUnosa("Kolicina", "!   Morate unijeti sve podatke za Kolicinu!");
		event.preventDefault();
        return false;
	}
	else
	{
		greskaUnosa("Kolicina", "");
	}
	if(tezina === "" )
	{
		greskaUnosa("Tezina", "!   Morate unijeti sve podatke za Tezinu!");
		event.preventDefault();
        return false;
	}
	else
	{
		greskaUnosa("Tezina", "");
	}
}
window.addEventListener("submit", unos);

function greskaUnosa(name, desi)
{
	var n = document.getElementById("naz");
	var o = document.getElementById("opi");
	var d = document.getElementById("dat");
	var v = document.getElementById("vri");
	var k = document.getElementById("kol");
	var t = document.getElementById("tez");
	var ka = document.getElementById("kat");
	if(name === "Naziv")
	{
		n.innerHTML = desi;
		n.setAttribute("style", "visibility: visible; color: red;");
		
	}
	if(name === "Opis")
	{
		o.innerHTML = desi;
		o.setAttribute("style", "visibility: visible; color: red;");
	}
	if(name === "Datum")
	{
		d.innerHTML = desi;
		d.ClassName = "naz";
		d.setAttribute("style", "visibility: visible; color: red;");
	}
	if(name === "Vrijeme")
	{
		v.innerHTML = desi;
		v.ClassName = "naz";
		v.setAttribute("style", "visibility: visible; color: red;");
	}
	if(name === "Kolicina")
	{
		k.innerHTML = desi;
		k.ClassName = "naz";
		k.setAttribute("style", "visibility: visible; color: red;");
	}
	if(name === "Tezina")
	{
		t.innerHTML = desi;
		t.ClassName = "naz";
		t.setAttribute("style", "visibility: visible; color: red;");
	}
	if(name === "Kategorija")
	{
		ka.innerHTML = desi;
		ka.ClassName = "kat";
		ka.setAttribute("style", "visibility: visible; color: red;");
	}
}

function kreirajDogadaj()
{
	var formular = document.getElementById("Form1");
    var korIme = document.getElementById("nazivp");
    var greske = document.getElementById("greske");
	var nazivv = document.getElementById("naz");
    //korIme.readOnly = true;
    //korIme.disabled = true;

    korIme.addEventListener("keydown", function (event) {
        var naziv = korIme.value;
		var len = korIme.length;
        if (naziv[0] == naziv[0].toUpperCase() && naziv.length > 3) {
			greske.innerHTML = "";
			korIme.removeAttribute("style", "background: red;");
			korIme.setAttribute("style", "background: green;");
			nazivv.innerHTML = "";
        } else {
            greske.innerHTML = "Prvo slovo nije veliko";
            korIme.className = "greske";
            korIme.setAttribute("style", "background: red;");
			greskaUnosa("Naziv","!   Prvo slovo mora biti veliko, i duljina mora biti 5 znakova!");
			}
    }, false);
    //console.log(formular);
    /*formular.addEventListener("submit", function (event) {
        for (var i = 0; i < formular.length; i++) {
            if (formular[i].type == "text")
                formular[i].disabled = true;
        }
        event.preventDefault();
    }, false);*/
}

function zakljucaj()
{
	setTimeout(zak,300000);
}

function zak()
{
    
	var nazivp = document.getElementById("nazivp");
	var opisp = document.getElementById("opisp");
	var datump = document.getElementById("datump");
	var vrijemep = document.getElementById("vrijemep");
	var kolicinap = document.getElementById("kolicinap");
	var tezinap = document.getElementById("tezinap");
	var res = document.getElementById("reset");
	var eh = document.getElementById("ehh");
	nazivp.readOnly = true;
    nazivp.disabled = true;
	opisp.readOnly = true;
    opisp.disabled = true;
	datump.readOnly = true;
    datump.disabled = true;
	vrijemep.readOnly = true;
    vrijemep.disabled = true;
	kolicinap.readOnly = true;
    kolicinap.disabled = true;
	tezinap.readOnly = true;
    tezinap.disabled = true;
	res.setAttribute("style", "visibility: visible;");
	eh.setAttribute("style", "visibility: visible;");
}

function provjera(event){
	var nazivp = document.Form1.nazivp.value;
    var opisp = document.Form1.opisp.value;
	var datump = document.Form1.datump.value;
	var vrijemep = document.Form1.vrijemep.value;
	var kolicinap = document.Form1.kolicinap.value;
	var tezinap = document.Form1.tezinap.value;
	for (var i = 0; i < nazivp.length; i++) {
        if (nazivp.charAt(i) === "(" || nazivp.charAt(i) === ")" || nazivp.charAt(i) === "{" || nazivp.charAt(i) === "}" || nazivp.charAt(i) === "'" || nazivp.charAt(i) === "!"|| nazivp.charAt(i) === "#" || nazivp.charAt(i) === "\"" || nazivp.charAt(i) === "/"|| nazivp.charAt(i) === "\\")
        {
            greskaUnosa("Naziv", "!   Naziv ima nedozvoljene znakove  ( ) { } ' ! # “ \ /");
			event.preventDefault();
			return false;
        }
		else
		{
			greskaUnosa("Naziv", "");
		}
    }
	for (var i = 0; i < opisp.length; i++) {
        if (opisp.charAt(i) === "(" || opisp.charAt(i) === ")" || opisp.charAt(i) === "{" || opisp.charAt(i) === "}" || opisp.charAt(i) === "'" || opisp.charAt(i) === "!"|| opisp.charAt(i) === "#" || opisp.charAt(i) === "\"" || opisp.charAt(i) === "/"|| opisp.charAt(i) === "\\")
        {
            greskaUnosa("Opis", "!   Osips ima nedozvoljene znakove  ( ) { } ' ! # “ \ /");
			event.preventDefault();
			return false;
        }
		else
		{
			greskaUnosa("Opis", "");
		}
    }
	for (var i = 0; i < datump.length; i++) {
        if (datump.charAt(i) === "(" || datump.charAt(i) === ")" || datump.charAt(i) === "{" || datump.charAt(i) === "}" || datump.charAt(i) === "'" || datump.charAt(i) === "!"|| datump.charAt(i) === "#" || datump.charAt(i) === "\"" || datump.charAt(i) === "/"|| datump.charAt(i) === "\\")
        {
            greskaUnosa("Datum", "!   Datum ima nedozvoljene znakove  ( ) { } ' ! # “ \ /");
			event.preventDefault();
			return false;
        }
		else
		{
			greskaUnosa("Datum", "");
		}
    }
	for (var i = 0; i < vrijemep.length; i++) {
        if (vrijemep.charAt(i) === "(" || vrijemep.charAt(i) === ")" || vrijemep.charAt(i) === "{" || vrijemep.charAt(i) === "}" || vrijemep.charAt(i) === "'" || vrijemep.charAt(i) === "!"|| vrijemep.charAt(i) === "#" || vrijemep.charAt(i) === "\"" || vrijemep.charAt(i) === "/"|| vrijemep.charAt(i) === "\\")
        {
            greskaUnosa("Vrijeme", "!   Vrijeme ima nedozvoljene znakove  ( ) { } ' ! # “ \ /");
			event.preventDefault();
			return false;
        }
		else
		{
			greskaUnosa("Vrijeme", "");
		}
    }
	for (var i = 0; i < kolicinap.length; i++) {
        if (kolicinap.charAt(i) === "(" || kolicinap.charAt(i) === ")" || kolicinap.charAt(i) === "{" || kolicinap.charAt(i) === "}" || kolicinap.charAt(i) === "'" || kolicinap.charAt(i) === "!"|| kolicinap.charAt(i) === "#" || kolicinap.charAt(i) === "\"" || kolicinap.charAt(i) === "/"|| kolicinap.charAt(i) === "\\")
        {
            greskaUnosa("Kolicina", "!   Kolicina ima nedozvoljene znakove  ( ) { } ' ! # “ \ /");
			event.preventDefault();
			return false;
        }
		else
		{
			greskaUnosa("Kolicina", "");
		}
    }
	for (var i = 0; i < tezinap.length; i++) {
        if (tezinap.charAt(i) === "(" || tezinap.charAt(i) === ")" || tezinap.charAt(i) === "{" || tezinap.charAt(i) === "}" || tezinap.charAt(i) === "'" || tezinap.charAt(i) === "!"|| tezinap.charAt(i) === "#" || tezinap.charAt(i) === "\"" || tezinap.charAt(i) === "/"|| tezinap.charAt(i) === "\\")
        {
            greskaUnosa("Tezina", "!   Tezina ima nedozvoljene znakove  ( ) { } ' ! # “ \ /");
			event.preventDefault();
			return false;
        }
		else
		{
			greskaUnosa("Tezina", "");
		}
    }
	
	//Provjera funkcije
	
}
window.addEventListener("submit", provjera);


function rec (event)
{
	var opisi = document.Form1.opisp.value;
	var brojac = 0;
	for(var i = 0; i < opisi.length; i++) {
		if (opisi.charAt(i) === opisi.charAt(i).toUpperCase()) 
		{
			for(var j = i; j<opisi.length; j++) {
				if(opisi.charAt(j) === ".")
				{
					brojac++;
					i = j;
				}
			}
		}
	}
	
	if(brojac < 3)
	{
		greskaUnosa("Opis", "!   Opis mora sadržavati barem 3 rečenice!");
		event.preventDefault();
		return false;
	}
}
window.addEventListener("submit", rec);

function pregledDatuma(event)
{
	var dat = document.Form1.datump.value;
	var dateParts = dat.split(".");
	var datum = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
	var dan = datum.getDate();
	var	mjes = datum.getMonth()+1;
	var god = datum.getFullYear();
	var danas = new Date();
	var dann = danas.getDate();
	var mjess = danas.getMonth()+1;
	if(typeof dat === "string")
	{
		if( datum.getDate() > dann){
			if(god >= danas.getFullYear())
			{
				greskaUnosa("Datum", "!   Neispravan Datum!");
				event.preventDefault();
				return false;
			}
		}
		if( datum.getMonth()+1 > mjess)
		{
			if(god >= danas.getFullYear())
			{
				greskaUnosa("Datum", "!   Neispravan Datum!");
				event.preventDefault();
				return false;
			}
		}
		if( datum.getFullYear() > danas.getFullYear() )
		{
			greskaUnosa("Datum", "!   Neispravan Datum!");
			event.preventDefault();
			return false;
		}
	}
	else
	{
		greskaUnosa("Datum", "!   Neispravan Datum!");
		event.preventDefault();
		return false;
	}
}
window.addEventListener("submit", pregledDatuma);

function pregledKategorije(event)
{
	var kategorija = document.getElementById("kategorijap").value;
	var vrijeme = document.getElementById("vrijemep").value;
	var kolicina = document.getElementById("kolicinap").value;
	var tezina = document.getElementById("tezinap").value;
	if(kategorija === "")
	{
		greskaUnosa("Kategorija", "!   Kategorija ne smije biti prazna!");
		event.preventDefault();
		return false;
	}
	else
	{
		greskaUnosa("Kategorija", "");
	}
	if(isNaN(vrijeme))
	{
		greskaUnosa("Vrijeme", "!   Vrijeme ne smije biti slovo!");
		event.preventDefault();
		return false;
	}
	if(isNaN(kolicina))
	{
		greskaUnosa("Kolicina", "!   Kolicina ne smije biti slovo!");
		event.preventDefault();
		return false;
	}
	if(isNaN(tezina))
	{
		greskaUnosa("Tezina", "!   Tezina ne smije biti slovo!");
		event.preventDefault();
		return false;
	}
}
window.addEventListener("submit", pregledKategorije);

function mO1() 
{
	var tekst = document.getElementById("manemoj");
	var slika = document.getElementById("slika1");
	var width = slika.clientWidth;
	var altq = slika.getAttribute("alt");
	var height = slika.clientHeight;
	tekst.innerHTML = "Sirina: " + width + " Visina: " + height + " Tekst: " + altq;
}
function mO2() 
{
	var tekst = document.getElementById("manemoj");
	var slika = document.getElementById("slika2");
	var width = slika.clientWidth;
	var altq = slika.getAttribute("alt");
	var height = slika.clientHeight;
	tekst.innerHTML = "Sirina: " + width + " Visina: " + height + " Tekst: " + altq;
}
function mO3() 
{
	var tekst = document.getElementById("manemoj");
	var slika = document.getElementById("slika3");
	var width = slika.clientWidth;
	var altq = slika.getAttribute("alt");
	var height = slika.clientHeight;
	tekst.innerHTML = "Sirina: " + width + " Visina: " + height + " Tekst: " + altq;
}

