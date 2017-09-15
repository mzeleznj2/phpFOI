window.onload = function () {

    /*
     *
     * REGISTRACIJA
     *
     */

    var greske = [];
    var postojeGreske = false;

    // funkcija za ispis greski
    function ispisiGreske() {
        // izbrisemo greske
        $("#greske").empty();

        // maknemo klasu "inputError"
        $(".inputError").removeClass("inputError");

        // oznacuje da greske ne postoje
        postojeGreske = false;

        // provjerimo ako postoje greske te ih ispisujemo i dodajemo klasu "inputError" input tagu sa greskom
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
                    $("#greske").append("<div>Lozinka mora sadržavat barem dva velika slova, dva mala slova i jedan broj. Mora biti duljine od 5 do 15 znakova!</div>")
                    $("#lozinka").addClass("inputError");
                    break;
                case "lozinkaPonovi":
                    $("#greske").append("<div>Lozinke se ne podudaraju!</div>");
                    $("#lozinkaPonovi").addClass("inputError");
                    break;
            }

            // oznacuje da greske postoje
            postojeGreske = true;

        }

        // resetiramo greske
        greske = [];
    }


    // koristimo keyup dogadaj za provjeru upisanih podataka za ime i prezime
    $(document).on("keyup", "#ime, #prezime", function () {
        // ako su ime i prezime upisani
        if ($("#ime").val() && $("#prezime").val()) {
            // makne se atribute disabled sa korisnickog imena
            $("#korisnickoIme").removeAttr("disabled");

            // ako ime ne pocinje sa velikim pocetnim slovom
            if (!/^[A-Z]/.test($("#ime").val()) || !/^[A-Z]/.test($("#prezime").val())) {
                greske.push("imePrezime");
            }

            // ispisi greske
            ispisiGreske();

            // ako nisu upisani ime ili prezime vraca atribut disabled na korisnicko ime
        } else {
            $("#korisnickoIme").attr("disabled", "disabled");
        }
    });

    // koristimo focusout dogadaj za provjeru dali korisnicko ime postoji uz pomoc AJAX-a
    $(document).on("focusout", "#korisnickoIme", function () {
        $.get("http://barka.foi.hr/WebDiP/2016/materijali/zadace/dz3/korisnikImePrezime.php", {
            ime: $("#ime").val(),
            prezime: $("#prezime").val()
        })
            .done(function (xml) {
                // pretrazujemo odgovor od servera u XML formatu za Korisnicko ime
                var korisnickoIme = $(xml).find('korisnicko_ime').text();
                // ako korisnicko ime postoji
                if (korisnickoIme !== "0") {
                    // ako je korisicno ime iz forme jednako korisnickom imenu iz serverskog XML odgovora
                    if (korisnickoIme == $("#korisnickoIme").val()) {
                        // dodajemo gresku
                        greske.push("korisnickoIme");
                    }
                    // ispisi greske
                    ispisiGreske();
                }
            });
    });

    // uzimamo AJAX metodom JSON drzave i stavljamo u Array
    var drzave = [];
    $.ajax({
        type: "POST",
        url: "drzave.json",
        success: function (response) {
            $.each(response, function (index, value) {
                drzave.push(value);
            });
        }
    });

    // autocomplete za polje drzave
    if ($.ui) {
        $("#drzava").autocomplete({
            source: drzave
        });
    }

    // uzima AJAX metodom JSON pozivne brojeve i radi select input na pritisak gumba Ucitaj
    $(document).on("click", "#pozivniBrojButton", function (e) {
        // onemougcimo opcenitu akciju za prosljedivanje forme
        e.preventDefault()

        // AJAX poziv koji popunjava select input
        $.ajax({
            type: "POST",
            url: "drzave-brojevi.json",
            dataType: "json",
            success: function (response) {
                $("#pozivniBroj").empty();
                $.each(response, function (index, value) {
                    $("#pozivniBroj").append("<option value='" + index + "'>" + value + " - " + index + "</option>");
                });
            }
        });

    });

    // koristimo keyup dogadaj za provjeru upisanih podataka za lozinku
    $(document).on("keyup", "#lozinka", function () {
        // ako je lozinka upisana
        if ($("#lozinka").val()) {
            // makne se atribute disabled sa potvrde lozinke
            $("#lozinkaPonovi").removeAttr("disabled");

            // ako lozinka sadrži barem dva velika slova, dva mala slova i jedan broj. Mora biti duljine od 5 do 15 znakova
            if (!/^(?=(.*[A-Z]){2})(?=(.*[a-z]){2})(?=(.*[0-9]){1}).{5,15}$/.test($("#lozinka").val())) {
                greske.push("lozinka");
            }

            // ispisi greske
            ispisiGreske();

            // ako nije upisana lozinka vraca atribut disabled na potvrdu lozinke
        } else {
            $("#lozinkaPonovi").attr("disabled", "disabled");
        }
    });

    // koristimo keyup dogadaj za provjeru upisanih podataka za ponovljenu lozinku
    $(document).on("focusout", "#lozinkaPonovi", function () {
        if ($("#lozinkaPonovi").val() !== $("#lozinka").val()) {
            greske.push("lozinkaPonovi");
        }

        // ispisi greske
        ispisiGreske();
    });

    // blokiramo prosljedivanje forme ako postoje greske
    $(document).on("submit", "#registracija", function (e) {
        // onemougcimo opcenitu akciju za prosljedivanje forme
        e.preventDefault();

        // ako ne postoje greske pokreni formu
        if (!postojeGreske) {
            this.submit();
        }
    });


    /*
     *
     * PROIZVOD
     *
     */

    $("#triSLike img").hover(function () {
        $("#modal").append("<img src='" + $(this).attr("src") + "'>");
        $("#modal").append("<p>ALT=" + $(this).attr("alt") + " ŠIRINA=" + this.naturalWidth + "px VISINA=" + this.naturalHeight + "px</p>");
        $("#modal").css("display", "block");
    }, function () {
        $("#modal").empty();
        $("#modal").css("display", "none");
    })


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
}