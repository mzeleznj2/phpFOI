window.onload = function () {

    /*
     *
     * REGISTRACIJA
     *
     */

    var greske = [];
    var postojeGreske = false;
  
    function ispisiGreske() {
        $("#jsGreske").empty();
       
        $(".inputError").removeClass("inputError");

        postojeGreske = false;

        for (var i in greske) {
            switch (greske[i]) {               
                case "ime":
                    $("#jsGreske").append("<div>Ime mora početi velikim slovom!</div>");
                    $("#ime").addClass("inputError");
                    break;
                case "imePrazno":
                    $("#jsGreske").append("<div>Niste upisali ime!</div>");
                    $("#ime").addClass("inputError");
                    break;
                case "prezime":
                    $("#jsGreske").append("<div>Prezime mora početi velikim slovom!</div>");
                    $("#prezime").addClass("inputError");
                    break;
                case "prezimePrazno":
                    $("#jsGreske").append("<div>Niste upisali prezime!</div>");
                    $("#prezime").addClass("inputError");
                    break;
                case "korIme":
                    $("#jsGreske").append("<div>Korisničko ime je zauzeto!</div>");
                    $("#korime").addClass("inputError");
                    break;
                case "lozinka":
                    $("#jsGreske").append("<div>Lozinka mora sadržavat barem dva velika slova, dva mala slova i jedan broj. Mora biti duljine od 5 do 15 znakova!</div>");
                    $("#lozinka").addClass("inputError");
                    break;
                case "lozinkaPonovi":
                    $("#jsGreske").append("<div>Lozinke se ne podudaraju!</div>");
                    $("#lozinkaPonovi").addClass("inputError");
                    break;
            }

            postojeGreske = true;
        }

        greske = [];
    }

    $("#registracija").on("focusout", "input", function () {
        if (!$("#ime").val()) {
            greske.push("imePrazno");
        } else {
            if (!/^[A-Z]/.test($("#ime").val())) {
                greske.push("ime");
            }
        }

        if (!$("#prezime").val()) {
            greske.push("prezimePrazno");
        } else {
            if (!/^[A-Z]/.test($("#prezime").val())) {
                greske.push("prezime");
            }
        }

        $.ajax({
            url: "ajax_korisnik.php",
            method : "POST",
            data: { korisnik : $("#korime").val() },
        }).done(function( data ) {
            if(data == "1") {
                greske.push("korIme");
            }
        });

        if (!/^(?=(.*[A-Z]){2})(?=(.*[a-z]){2})(?=(.*[0-9]){1}).{5,15}$/.test($("#lozinka1").val())) {
            greske.push("lozinka");
        }

        if ($("#lozinka1").val() !== $("#lozinka2").val()) {
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

};