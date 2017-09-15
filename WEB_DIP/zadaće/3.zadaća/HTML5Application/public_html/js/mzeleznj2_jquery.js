window.onload = function () {

    /*
     *
     * REGISTRACIJA
     *
     */

    var greske = [];
    var postojeGreske = false;
  
    function ispisiGreske() {       
        $("#greske").empty();
       
        $(".inputError").removeClass("inputError");

        postojeGreske = false;

        for (var i in greske) {
            switch (greske[i]) {
                case "korisnickoIme":
                    $("#greske").append("<div>Korisničko ime već postoji. Promjenite korisničko ime!</div>");
                    $("#korisnickoIme").addClass("inputError");
                    break;
                case "imePrezime":
                    $("#greske").append("<div>Ime i prezime moraju početi velikim slovom!</div>");
                    $("#ime").addClass("inputError");
                    $("#prezime").addClass("inputError");
                    break;
                case "lozinka":
                    $("#greske").append("<div>Lozinka mora sadržavat barem dva velika slova, dva mala slova i jedan broj. Mora biti duljine od 5 do 15 znakova!</div>");
                    $("#lozinka").addClass("inputError");
                    break;
                case "lozinkaPonovi":
                    $("#greske").append("<div>Lozinke se ne podudaraju!</div>");
                    $("#lozinkaPonovi").addClass("inputError");
                    break;
            }

            postojeGreske = true;
        }

        greske = [];
    }

 
    $(document).on("keyup", "#ime, #prezime", function () {     
        if ($("#ime").val() && $("#prezime").val()) {
            $("#korisnickoIme").removeAttr("disabled");

            if (!/^[A-Z]/.test($("#ime").val()) || !/^[A-Z]/.test($("#prezime").val())) {
                greske.push("imePrezime");
            }

            ispisiGreske();

        } else {
            $("#korisnickoIme").attr("disabled", "disabled");
        }
    });

//ime: Markos   prezime: Jurišić     korime: mjurisic
    $(document).on("focusout", "#korisnickoIme", function () {
        $.get("http://barka.foi.hr/WebDiP/2016/materijali/zadace/dz3/korisnikImePrezime.php", {
            ime: $("#ime").val(),
            prezime: $("#prezime").val()
        })
            .done(function (xml) {
                var korisnickoIme = $(xml).find('korisnicko_ime').text();
                if (korisnickoIme !== "0") {
                    if (korisnickoIme === $("#korisnickoIme").val()) {
                        greske.push("korisnickoIme");
                    }
                    ispisiGreske();
                }
            });
    });

//'korisnicko_ime'
    
    var drzave = [];
    $.ajax({
        url: "xml_json/drzave.json",
        dataType: "json",
        success: function (response) {
            $.each(response, function (index, value) {
                drzave.push(value);
            });
        }
    });

    
    if ($.ui) {
        $("#drzava").autocomplete({
            source: drzave
        });
    }

    $(document).on("click", "#pozivniBrojButton", function (e) {
        e.preventDefault();
      
        $.ajax({  
            url: "xml_json/drzave-brojevi.json",
            dataType: "json",
            success: function (response) {
                $("#pozivniBroj").empty();
                $.each(response, function (index, value) {
                    $("#pozivniBroj").append("<option value='" + index + "'>" + value + " - " + index + "</option>");
                });
            }
        });

    });

  
    $(document).on("keyup", "#lozinka", function () {      
        if ($("#lozinka").val()) {          
            $("#lozinkaPonovi").removeAttr("disabled");
    
            if (!/^(?=(.*[A-Z]){2})(?=(.*[a-z]){2})(?=(.*[0-9]){1}).{5,15}$/.test($("#lozinka").val())) {
                greske.push("lozinka");
            }

            ispisiGreske();

        } else {
            $("#lozinkaPonovi").attr("disabled", "disabled");
        }
    });

    $(document).on("focusout", "#lozinkaPonovi", function () {
        if ($("#lozinkaPonovi").val() !== $("#lozinka").val()) {
            greske.push("lozinkaPonovi");
        }

        ispisiGreske();
    });

 
    $(document).on("submit", "#registracija", function (e) {
         e.preventDefault();
 
        if (!postojeGreske) {
            this.submit();
        }
    });

  
    /*
     *
     * POPIS PROIZVODA
     *
     */

    if ($().dataTable) {
        $('#proizvodiTable').DataTable({
            "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
        });
    }
};