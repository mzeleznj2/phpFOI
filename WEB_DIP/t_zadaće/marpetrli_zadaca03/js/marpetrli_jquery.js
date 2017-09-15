
var porukeGreski;

function provjera(e) {
	porukeGreski = "";
	provjeraImena()
	provjeraPrezimena()
	provjeraKorIme()
	provjeraLozinke()
	provjeraPonLozinke();
	projveraDana()
	provjeraMjeseca()
	provjeraGodina()
	provjeraBroja() 
	provjeraEmail()
	provjeraLokacije()
	provjeraSlike()

	if (porukeGreski !== "") {
		$('#greske')[0].innerHTML = porukeGreski;
        e.preventDefault();
    }
}

function provjeraImena() {
	var elem = $('#ime');
	var oldText = porukeGreski;
	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Ime ne smije biti prazno!");
	}

	funkCS(elem, oldText, porukeGreski);
}

function provjeraPrezimena() {
	var elem = $('#prezime');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Prezime ne smije biti prazno!");
	}

	funkCS(elem, oldText, porukeGreski);
}
function provjeraKorIme() {
	var elem = $('#korisnicko_ime');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Korisničko ime ne smije biti prazno!");
	} else if (elem.val().length < 10) {
		porukeGreski += ("<br>" + "Korisničko ime mora imati najmanje 10 znakova!");
	} else if(elem.attr("type") != "text") {
		porukeGreski += ("<br>" + "Korisničko ime mora biti tipa text!");
	}
	
	regxKorIme(elem);
	funkCS(elem, oldText, porukeGreski);
}

function provjeraLozinke() {
	var elem = $('#lozinka');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Lozinka ne smije biti prazna!");
	} else if (elem.val().length < 8) {
		porukeGreski += ("<br>" + "Lozinka mora imati najmanje 8 znakova!");
	} else if(elem.attr("type") != "password") {
		porukeGreski += ("<br>" + "Lozinka nije tipa password!");
	}

	regxLozinka(elem);
	funkCS(elem, oldText, porukeGreski);
}

function provjeraPonLozinke() {
	var elem = $('#p_lozinka');
	var elem2 = $('#lozinka');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Ponovljena lozinka ne smije biti prazna!");
	} else if (elem.val() != elem2.val()) {
		porukeGreski += ("<br>" + "Lozinka i ponovljena lozinka nisu iste!");
	}

	funkCS(elem, oldText, porukeGreski);
}

function projveraDana() {
	var elem = $('#dan');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Dan ne može biti prazan!");
	} else if (elem.attr("type") != "number") {
		porukeGreski += ("<br>" + "Dan mora biti tipa number!");
	} else if(elem.val() < 1 || elem.val() > 31) {
		porukeGreski += ("<br>" + "Dan mora biti između 1 i 31!");
	}

	funkCS(elem, oldText, porukeGreski);
}

function provjeraMjeseca() {
	var elem = $('#mjesec');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Mjesec ne smije biti prazan!");
	}

	//Problemi

	funkCS(elem, oldText, porukeGreski);
}

function provjeraGodina() {
	var elem = $('#godina');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Godina ne može biti prazan!");
	} else if (elem.attr("type") != "number") {
		porukeGreski += ("<br>" + "Godina mora biti tipa number!");
	} else if(elem.val() < 1930 || elem.val() > 2015) {
		porukeGreski += ("<br>" + "Dan mora biti između 1930 i 2015!");
	}

	funkCS(elem, oldText, porukeGreski);
}

function provjeraBroja() {
	var elem = $('#broj');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Broj ne može biti prazan!");
	} else if (elem.attr("type") != "tel") {
		porukeGreski += ("<br>" + "Broj mora biti tipa tel!");
	} else if(elem.val() < 1930 || elem.val() > 2015) {
		porukeGreski += ("<br>" + "Dan mora biti između 1930 i 2015!");
	}

	regxBroj(elem);
	funkCS(elem, oldText, porukeGreski);
}

function provjeraEmail() {
	var elem = $('#email');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Email ne smije biti prazan!");
	} else if(elem.attr("type") != "text") {
		porukeGreski += ("<br>" + "Email mora biti tipa text!");
	}

	regxEmail(elem);
	funkCS(elem, oldText, porukeGreski);
}

function provjeraLokacije() {
	var elem = $('#lokacija');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Lokacija mora biti unesena!");
	} else if(elem.attr("type") != "testarea") {
		porukeGreski += ("<br>" + "Lokacija mora biti tipa textarea!");
	}

	if(lokProv(elem) == false)
		porukeGreski += ("<br>" + "Lokacija nije dobro unesena. Mora biti oblika \"broj;broj\"");

	funkCS(elem, oldText, porukeGreski);
}

function provjeraSlike() {
	var elem = $('#lokacija');
	var oldText = porukeGreski;

	if(elem.val() === "") {
		porukeGreski += ("<br>" + "Slika mora biti unesena!");
	};

	funkCS(elem, oldText, porukeGreski);
}

function regxKorIme(elem) {
	var prviChar = /^[a-z]/;
	var flag = prviChar.exec(elem.val());
	if(flag == null)
		porukeGreski += ("<br>" + "Prvi znak korisničkog imena mora biti malo slvo!");

	var oneCapital = /^(?=.*[A-Z])/;
	flag = oneCapital.exec(elem.val());
	if(flag == null)
		porukeGreski += ("<br>" + "Korisničko ime treba imati bar jedno veliko slovo!");

	var specCase = /^(?=(.*[_\-!#$?]){2,})/;
	flag = specCase.exec(elem.val());
	if(flag == null)
		porukeGreski += ("<br>" + "Korisničko ime treba imati bar dva specijalna znaka!");

}

function regxLozinka(elem) {
	var velikoIMalo = /^(?=.*[a-z])(?=.*[A-Z])/;
	var flag = velikoIMalo.exec(elem.val());
	if(flag == null)
		porukeGreski += ("<br>" + "Lozinka mora imati velika i mala slova!");

	var brojevi = /^(?=.*\d) /;
	flag = brojevi.exec(elem.val());
	if(flag == null)
		porukeGreski += ("<br>" + "Lozinka mora imati ber jedan broj!");

	var specCase = /^(?=(.*[!#$?]){1,})/;
	flag = specCase.exec(elem.val());
	if(flag == null)
		porukeGreski += ("<br>" + "Lozinka mora imati bar jedan specijalan znak!");

}

function regxBroj(elem) {
	var broj = /^\d{3}[ ]\d{7}$/;
	var flag = broj.exec(elem.val());
	if(flag == null)
		porukeGreski += ("<br>" + "Broj nije dobro unesen!");

}

function regxEmail(elem) {
	var email = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
	var flag = email.exec(elem.val());
	if(flag == null)
		porukeGreski += ("<br>" + "Email nije dobro unesen!");
	
}

function lokProv(elem) {
	var text = elem.val();
	var indx = text.indexOf(";")
	if(indx == -1 || indx < 1 || indx == (text.length-1))
		return false;

	var lat = text.substring(0, indx);
	var lon = text.substring(indx+1, text.length);

	if(isNaN(lat) || isNaN(lon))
		return false;

	if(lat < -90 || lat > 90)
		return false;
	if(lon < -180 || lon > 180)
		return false;

	return true;
}

function funkCS(elem, oldText, newText) {
	if(oldText != newText){
		elem.css({'border-color': 'red', "border-style": "solid", 'background-color': 'lightblue'});
	} else {
		elem.css({'border-color': 'green', "border-style": "solid", 'background-color': ''});
	}
}




$(document).ready(function () {
	$('input').focus(function () {
        $(this).addClass("jqFouks");
    });


    $('input').focusout(function () {
        $(this).removeClass("jqFouks");
    });

    $('input[type=submit]').click(function(e) {
    	provjera(e);

    });

});

