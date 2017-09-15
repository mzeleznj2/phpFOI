

$(document).ready(function () {
    $("#ime").on("keydown", prvoSlovo);
    $("#prez").on("keydown", prvoSlovo);
    
    
    $("#korIme").focusout(function () {
        $.ajax({
            type: 'GET',
            url: 'http://barka.foi.hr/WebDiP/2016/materijali/zadace/dz3/korisnikImePrezime.php?ime=' + $("#ime").val() + '&prezime=' + $("#prez").val(),
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('korisnik').each(function () {
                var korIme = $(this).find("korIme").text();

                if (("korIme").val()===korIme) {
                    alert ("Korisnicko ime vec postoji!");
                    $("#korIme").attr("class", "imaGresku");
                } else {
                    $("#korIme").attr("class", "nemaGresku");   
                }
            });
        }
    });
});
    
    $(".omiljeni_slike").on("mouseover", function (event) {	
	var trazeni;
        if (event.target.id==="om1") {
            $("#om1").css('z-index', '2');
            trazeni=$("#om1");
	} else if (event.target.id==="om2") {
            $("#om2").css('z-index', '2');
            trazeni=$("#om2");
	} else if (event.target.id==="om3") {
            $("#om3").css('z-index', '2');
            trazeni=$("#om3");
	}
	alert("Visina: " + trazeni.height() + "; Sirina: " + trazeni.width() + "; alt: " + trazeni.attr("alt"));
    });
    
});
function prvoSlovo() {
    var ime = document.getElementById("ime");
    var prezime = document.getElementById("prez");
    var korIme = document.getElementById("korIme");

    var pocetnoSlovo = new RegExp(/^[A-Z]/);
    var prvoIme = pocetnoSlovo.test(ime.value);
    var prvoPrez = pocetnoSlovo.test(prezime.value);


    if (prvoIme === false) {
        $(document.registracija.ime).attr("class", "imaGresku");
    } else {
        $(document.registracija.ime).attr("class", "nemaGresku");
    }

    if (prvoPrez === false) {
        $(document.registracija.prez).attr("class", "imaGresku");
    } else {
        $(document.registracija.prez).attr("class", "nemaGresku");
    }
    
    if (ime.value.length > 0 && prezime.value.length > 0)
    {
        korIme.disabled = false;
    } else {
        korIme.disabled = true;
    }
}

function blokirajUnosPotvrdeLoz () {
    var lozinka = document.getElementById("lozinka1");
    var potvrda = document.getElementById("lozinka2");   
    var loz = new RegExp(/^(?=(.*[a-z]){2,})(?=(.*\d){1,})(?=(.*[A-Z]){2,}).{5,15}$/);
    var unos = loz.test(lozinka.value);

    if (unos===false) {
        $(document.registracija.lozinka1).attr("class", "imaGresku");
        potvrda.disabled = true;
    }
    else {
        $(document.registracija.lozinka1).attr("class", "nemaGresku");
        potvrda.disabled = false;
    }
}

function provjeriLoz () {
    var lozinka = document.getElementById("lozinka1");
    var potvrda = document.getElementById("lozinka2");
    
    if (lozinka.value === potvrda.value) {
      $(document.registracija.lozinka2).attr("class", "nemaGresku");  
    } 
    else {
      $(document.registracija.lozinka2).attr("class", "imaGresku");   
    }
}

