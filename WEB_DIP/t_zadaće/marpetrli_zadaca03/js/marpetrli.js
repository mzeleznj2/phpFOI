var readyStateCheckInterval = setInterval(function() {
    if (document.readyState === "complete") {
        clearInterval(readyStateCheckInterval);
        init();
    }
}, 10);

function init() {
	var regForm = document.getElementById("regForm");
	if(regForm)
		regForm.addEventListener("submit", function(event) {
			validate(event);
		});

	var priForm = document.getElementById("pri");
	if(priForm)
		priForm.addEventListener("submit", function(event) {
			priValidate(event);
		});
}

var countnewT = 0;
function validate(e) {
	var form = document.getElementById("regForm");
	var formCvor = document.getElementsByTagName('form')[0];
	while(countnewT != 0) {
		formCvor.removeChild(formCvor.lastChild);
		--countnewT;
	}

	for(var i = 0; i < form.length; ++i) {
		//Provjera da li je sve unešeno
		var elem = form[i];
		var erroro = 0;

		if(elem.type === "submit") {
			continue;
		}
		
		chStyle(elem, 0);
		

		if(elem.id === "ime") {
			var newTxt = document.createElement('label');
			var val = elem.value;
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Ime ne smije biti prazno!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}

		else if(elem.id === "prezime") {
			var newTxt = document.createElement('label');
			var val = elem.value;
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Prezime ne smije biti prazno!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}

		//Provjera da li je korisnicko ime dobro napisano
		else if(elem.id === "korisnicko_ime") {
			var newTxt = document.createElement('label');
			var val = elem.value;
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Korisničko ime ne smije biti prazno!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(val.length < 10 ) {
				newTxt.innerHTML = "<br>" + "Korisničko ime mora bar 10 znakova!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if (elem.type != "text") {
				newTxt.innerHTML = "<br>" + "Korisničko ime mora biti tipa text!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(val[0] == val[0].toUpperCase()) {
				newTxt.innerHTML = "<br>" + "Prvi znak korisničko imena mora biti mal slovo!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(val == val.toLowerCase()) {
				newTxt.innerHTML = "<br>" + "Korisničko ime mora sadržavati bar jedno veliko slovo!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(!checkIfSC(val, 2)) {
				newTxt.innerHTML = "<br>" + "Korisničko ime mora sadržavati bar dva posebna znaka!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}


		//Provjera da li je lozinka dobro napisana
		else if(elem.id === "lozinka") {
			var newTxt = document.createElement('label');
			var val = elem.value;
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Lozinka ne smije biti prazno!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(val.length < 8) {
				newTxt.innerHTML = "<br>" + "Lonzika mora imati 8 ili više znakova!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if (elem.type != "password") {
				newTxt.innerHTML = "<br>" + "Lonzika mora biti tipa password";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if (val == val.toLowerCase() || val == val.toUpperCase()) {
				newTxt.innerHTML = "<br>" + "Lonzika mora imati velika i mala slova!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(!checkIfNum(val)) {
				newTxt.innerHTML = "<br>" + "Lonzika mora sadržavati bar jedan broj!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(!checkIfSC(val, 1)) {
				newTxt.innerHTML = "<br>" + "Lonzika mora sadržavati bar jedan poseban znak!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}

		//Provjera da li je potvrđujuća lozinka jednaka lozinci
		else if(elem.id === "p_lozinka") {
			var val1 = document.getElementById("lozinka").value;
			var val2 = elem.value
			var newTxt = document.createElement('label');
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Ponovljena lozinka ne smije biti prazna!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(val1 != val2) {
				newTxt.innerHTML = "<br>" + "Ponovljena lozinka nije ista kao i lozinka!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro
			}
		}

		//Provjera dana rođenja
		else if(elem.id === "dan") {
			var newTxt = document.createElement('label');
			var val = elem.value;
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Dan ne smije biti prazan!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(elem.type != "number") {
				newTxt.innerHTML = "<br>" + "Dan mora biti tipa number!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if( val < 1 || val > 31) {
				newTxt.innerHTML = "<br>" + "Dan je roj između 1 i 31!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}

		//Provjera mjeseca rođenja
		else if(elem.id === "mjesec") {
			var newTxt = document.createElement('label');
			var val = elem.value;
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Mjesec ne smije biti prazan!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}else if (tagN[0].id != "mjeseci") {
				newTxt.innerHTML = "<br>" + "Mjesec mora biti tipa datalist!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}

		//Provjera godine rođenja
		else if(elem.id === "godina") {
			var newTxt = document.createElement('label');
			var val = elem.value;
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Godina ne smije biti prazna!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(elem.type != "number") {
				newTxt.innerHTML = "<br>" + "Godina mora biti tipa number!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(val < 1930  || val > 2015) {
				newTxt.innerHTML = "<br>" + "Godina mora biti između 1930 i 2015!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}

		//Provjera telefona
		else if(elem.id === "broj") {
			var val = elem.value;
			var newTxt = document.createElement('label');
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Broj ne smije biti prazan!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(!checkPhone(val)) {
				newTxt.innerHTML = "<br>" + "Broj nije ispravno unesen!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}

		//Provjera email adrese
		else if(elem.id === "email") {
			var val = elem.value;
			var newTxt = document.createElement('label');
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Email ne smije biti prazan!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(!checkEmail(val)) {
				newTxt.innerHTML = "<br>" + "Email adresa nije ispravno unesena!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}

		//Provjera lokacije
		else if(elem.id === "lokacija") {
			var val = elem.value;
			var newTxt = document.createElement('label');
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Lokacija je smije biti prazna!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(elem.type != "textarea") {
				newTxt.innerHTML = "<br>" + "Lokacija nije tipa textarea!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			} else if(!checkLocation(val)) {
				newTxt.innerHTML = "<br>" + "Lokacija nije ispravno unesena!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		} 

		else if (elem.id === "slika") {
			var newTxt = document.createElement('label');
			var val = elem.value;
			if(val == "") {
				newTxt.innerHTML = "<br>" + "Slika ne smije biti prazno!";   
				document.getElementsByTagName('form')[0].appendChild(newTxt);
				++countnewT;
				++erroro;
			}
		}

		else {
			if(elem.tagName == "INPUT" || elem.tagName == "TEXTAREA" && elem.id != "posalji") {
				if(elem.value == "") {
					var newTxt = document.createElement('label');
					newTxt.innerHTML = "<br>" + elem.id + " ne smije biti prazno!";   
					document.getElementsByTagName('form')[0].appendChild(newTxt);
					++countnewT;
					++erroro;
				}
			}
		}

		if(erroro != 0) {
			chStyle(elem, 1);
			e.preventDefault();
			if(elem.type === "file")
				elem.style.color = "red";

		} else {
			if(elem.type === "file")
				elem.style.color = "green";
		}
	}
}



function priValidate(e) {
	var form = document.getElementById("priForm");
	var formCvor = document.getElementsByTagName('form')[0];
	var greske = "";
	while(countnewT != 0) {
		formCvor.removeChild(formCvor.lastChild);
		--countnewT;
	}

	for(var i = 0; i < form.length; ++i) {
		//Provjera da li je sve unešeno
		var elem = form[i];
		var erroro = 0;

		if(elem.type === "submit") {
			continue;
		}
		
		chStyle(elem, 0);

		//Provjera da li nije prazno

		//Provjera da li je korisnicko ime dobro napisano
		if(elem.id === "korisnicko_ime") {
			var val = elem.value;

			if(val === "") {
				greske += ("<br>" + "Korisničko ime ne smije biti prazna!");
				++erroro;
			} else if(val.length < 10) {
				greske += ("<br>" + "Korisničko ime mora imati bar 10 znakova!");
				++erroro;
			} else if (elem.type != "text") {
				greske += ("<br>" + "Korisničko ime mora biti tipa text!");
				++erroro;
			} else if(val[0] == val[0].toUpperCase()) {
				greske += ("<br>" + "Prvo slovo korisničkog imena treba biti malo!");
				++erroro;
			} else if(val == val.toLowerCase()) {
				greske += ("<br>" + "Korisničko ime se mora sastojati bar od jednog velikog slova!");
				++erroro;
			} else if(!checkIfSC(val, 2)) {
				greske += ("<br>" + "Korisničko ime mora sadržavati bar 2 specijalna znaka!");
				++erroro;
			}
		}


		//Provjera da li je lozinka dobro napisana
		if(elem.id === "lozinka") {
			var val = elem.value;
			if(val === "") {
				greske += ("<br>" + "Lozinka ne smije biti prazna!");
				++erroro;
			}else if(val.length < 8) {
				greske += ("<br>" + "Lozinka mora imati više od 8 znakova!");
				++erroro;
			} else if (elem.type != "password") {
				greske += ("<br>" + "Lozinka mora biti tipa password!");
				++erroro;
			} else if (val == val.toLowerCase() || val == val.toUpperCase()) {
				greske += ("<br>" + "Lozinka se mora sastojati od velikih i malih slova!");
				++erroro;
			} else if(!checkIfNum(val)) {
				greske += ("<br>" + "Lozinka mora sadržavati brojeve!");
				++erroro;
			} else if(!checkIfSC(val, 1)) {
				greske += ("<br>" + "Lozinka mora sadržavati specijalne zankove!");
				++erroro;
			}
		}

		if(erroro != 0) {
			chStyle(elem, 1);
			e.preventDefault();
		} else {
			
		}
	}
	var texxt = document.getElementById("prijGre");
	texxt.innerHTML = greske;

}


function chStyle(elem, choice) {
	if(choice == 1) {
		elem.style.borderColor = "red";
	} else if(choice == 0) {
		elem.style.borderColor = "green";
	} else {
		elem.style.borderColor = "";
	}
}

function checkIfSC(text, num) {
	var sc = "_.!#$?";
	var nSC = 0;
	for(var i = 0; i < text.length; ++i)
		for(var j = 0; j < sc.length; ++j)
			if(text[i] === sc[j])
				++nSC;

	if(nSC >= num)
		return true;
	return false;
}

function checkIfNum(text) {
	var num = "1234567890";
	for(var i = 0; i < text.length; ++i)
		for(var j = 0; j < num.length; ++j)
			if(text[i] === num[j])
				return true;

	return false;
}

function checkPhone(text) {
	var num = "1234567890";
	if(text.length != 11) {
		return false;
	} else if(text[3] != " ") {
		return false;
	}

	text = text.replace(" ", "");
	if(isNaN(text) || text.length != 10)
		return false;

	return true;
}

function checkEmail(text) {
	if(text.indexOf("@") == - 1 || text.indexOf(".") == -1)
		return false;

	if(text.lastIndexOf(".") - text.lastIndexOf("@") <= 1)
		return false;

	if(text.lastIndexOf(".") == text.length - 1)
		return false;

	return true;
}


function checkLocation(text) {
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