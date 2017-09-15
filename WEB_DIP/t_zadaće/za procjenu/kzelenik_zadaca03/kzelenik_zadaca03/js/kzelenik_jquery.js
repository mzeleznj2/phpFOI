$(document).ready(function () {
    var drzave = new Array();
    $.getJSON("xml_json/drzave.json",
            function (data) {
                $.each(data, function (key, val) {
                    console.log(val);
                    drzave.push(val);
                });
            });

    $('#drzave').autocomplete({
        source: drzave
    });
	
	$('#tablicaaa').dataTable();
	
});

$(function() 
{
      $("#xyz").click( function() {
			var brojevii = new Array();
			$.getJSON("xml_json/drzave-brojevi.json",
				function (data) {
					$.each(data, function (key, v) {
						console.log(v);
						$('#item').append($('<option>', {
							value: v.value,
							text : key+" "+v
						}));
					});
				});
		});
});



$(document).ready(function(){
    $("#dpass").attr("disabled", "true");
    $("#pass").blur(function(){
        if ($(this).val() != "") {
            $("#dpass").removeAttr("disabled");
        } else {
            $("#dpass").attr("disabled", "true");        
        }
    });    
});

$(document).ready(function(){
	
    $("#dpass").blur(function(){
        if ($(this).val() == document.getElementById("pass").value) {
            $("#dpass").css('background-color', 'Green');
        } else {
            $("#dpass").css('background-color', 'Red');     
        }
    });    
});

$(document).ready(function(){
    $("#korim").attr("disabled", "true");
	var trigger = false;
    $("#ime").blur(function(){
        if ($(this).val() != "") {
            trigger = true;
        } else {
            trigger = false;       
        }
    });
	$("#prez").blur(function(){
			if ($(this).val() != "" && trigger == true) {
				$("#korim").removeAttr("disabled");
			} else {
				$("#korim").attr("disabled", "true");       
			}
		});
});


function provjeraSlova()
{
	var formular = document.getElementById("Form1");
    var imee = document.getElementById("ime");
	var prezii = document.getElementById("prez");
    var greske = document.getElementById("greske");
    var vrijednost = new RegExp(/^[A-Z][a-zA-Z]*$/);
	var pom = 0;
	var pom2 = 0;
    imee.addEventListener("keydown", function (event) {
		if(imee.value ==="")
		{
			imee.setAttribute("style", "background: white;");
		}
		if(prezii.value ==="")
		{
			prezii.setAttribute("style", "background: white;");
		}
        if(vrijednost.test(imee.value))
		{
			greske.innerHTML = "";
			imee.removeAttribute("style", "background: red;");
			imee.setAttribute("style", "background: green;");
			pom = 1;
			if(pom2 === 1)
			{
				$("#korim").removeAttr("disabled");
			}
		}
		else
		{
			greske.innerHTML = "Prvo slovo imena nije veliko";
            imee.className = "greske";
            imee.setAttribute("style", "background: red;");
			pom = 0;
		}
    }, false);
	prezii.addEventListener("keydown", function (event) {
        if(vrijednost.test(prezii.value))
		{
			greske.innerHTML = "";
			prezii.removeAttribute("style", "background: red;");
			prezii.setAttribute("style", "background: green;");
			if(pom === 1)
			{
				$("#korim").removeAttr("disabled");
			}
			pom2 = 1;
		}
		else
		{
			greske.innerHTML = "Prvo slovo prezimena nije veliko";
            prezii.className = "greske";
            prezii.setAttribute("style", "background: red;");
			pom2 = 0;
		}
    }, false);
}


function provjeraLozinke()
{
	var formular = document.getElementById("Form1");
    var sifra = document.getElementById("pass");
    var greske = document.getElementById("greske");
    var vrijednost = new RegExp(/^(?=(.*[A-Z]){2,})(?=(.*[a-z]){2,})(?=(.*\d){1,}).{5,15}$/);
    sifra.addEventListener("keyup", function (event) {
		if(sifra.value === "")
		{
			sifra.setAttribute("style", "background: white;");
		}
        if(vrijednost.test(sifra.value))
		{
			sifra.removeAttribute("style", "background: red;");
			sifra.setAttribute("style", "background: green;");
			$("#dpass").removeAttr("disabled");
		}
		else
		{
            sifra.className = "greske";
            sifra.setAttribute("style", "background: red;");
			$("#dpass").attr("disabled", "true");
		}
    }, false);
}



$(document).ready(function(){
    $("#korim").focusout(function (event) {
        var ime = $("#ime").val();
		var prezime  = $("#prez").val();
        var ime_provjera;
		var prezime_provjera;
        $.ajax({
            url: 'http://barka.foi.hr/WebDiP/2016/materijali/zadace/dz3/korisnikImePrezime.php',
            data: {ime: ime, prezime: prezime},
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('ime').each(function () {
                    ime_provjera = $(this).text();
                });
				$(xml).find('prezime').each(function () {
                    prezime_provjera = $(this).text();
                });
                if ($.isNumeric(ime_provjera)&&$.isNumeric(prezime_provjera) ) {
                    $("#greske").text("Korisnik ne postoji!");
                     $("#korim").focus();

                } else {
                    $("#greske").text("Korisnik postoji!");
                }

            }
        });
    });
	
	});                        