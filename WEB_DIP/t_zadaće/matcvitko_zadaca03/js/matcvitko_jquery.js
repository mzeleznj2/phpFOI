var ime_p = false, prezime_p = false, k_p = false, l_p = false, l2_p = false, d_p = false, m_p = false, g_p = false, mob_p = false, e_p = false, lok_p = false, robot_provjera = false;
$(document).ready(function () {
    $("#registracija").submit(function (e) {
        if (ime_p === true && prezime_p === true && k_p === true && l_p === true && l2_p === true && d_p === true && m_p === true && g_p === true && e_p === true && lok_p === true && robot_provjera === true)
        {
            $("#greske").html("<p></p>");

        } else
        {
            if (ime_p === false || prezime_p === false || k_p === false || l_p === false || l2_p === false || d_p === false || m_p === false || g_p === false || e_p === false || lok_p === false || robot_provjera === false)
            {
                $("#greske").html("<p> Nisu sva pravila u unosu zadovoljena! </p>");
                e.preventDefault();
            }
        }
    });
});
$(document).ready(function () {

    $("input").focus(function () {
        $(this).css("background-color", "#add8e6");
    });
    $("input").focusout(function () {
        $(this).css("background-color", "white");
    });
    $("textarea").focus(function () {
        $(this).css("background-color", "#add8e6");
    });
    $("textarea").focusout(function () {
        $(this).css("background-color", "white");
    });

    $("#ime").focusout(function (event) {
        ime_p = false;
        var ime = $("#ime").val();
        if (ime.length !== 0) {
            $("#ime").css("border-color", "green");
            ime_p = true;
        } else {
            if (ime.length === 0)
            {
                $("#ime").css("border-color", "red");
                $("#greske").html("<p> Morate unijeti vrijednost u polje ime! </p>");
            }
        }
    });
    $("#prezime").focusout(function (event) {
        prezime_p = false;
        var prezime = $("#prezime").val();
        if (prezime.length !== 0) {
            $("#prezime").css("border-color", "green");
            prezime_p = true;
        } else {
            if (prezime.length === 0)
            {
                $("#prezime").css("border-color", "red");
                $("#greske").html("<p> Morate unijeti vrijednost u polje prezime! </p>");
            }
        }
    });
    $("#username").focusout(function (event) {
        k_p = false;
        var tip = $('#username').attr('type');
        var korisnickoIme = $("#username").val();
        var maloSlovo = /^[a-z]/;
        var velikaSlova = /[A-Z]{1}/;
        var znakovi = /(?=(.*[-_$?!#]){2})/;
        var korisnickoIme = $("#username").val();

        $.ajax({
            url: 'https://barka.foi.hr/WebDiP/2015/materijali/zadace/dz3_dio2/korisnik.php',
            type: 'GET',
            data: {'korisnik': korisnickoIme},
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('korisnik').each(function () {
                    if (($(this).text() === "0") && korisnickoIme.length > 10 && korisnickoIme.match(maloSlovo) && korisnickoIme.match(velikaSlova) && korisnickoIme.match(znakovi) && tip === "text")
                    {
                        $("#username").css("border-color", "green");
                        $("#greske").html("<p></p>");
                        k_p = true;

                    } else
                    {
                        if ($(this).text() === "1")
                        {
                            $("#username").css("border-color", "red");
                            $("#istoKorime").html("<p>Korisnicko ime je zauzeto! </p>");
                            $("#istoKorime").effect("highlight", 3000);
                            $("#username").focus();
                        }
                        if (korisnickoIme.length < 10)
                        {
                            $("#username").css("border-color", "red");
                            $("#greske").html("<p> Korisničko ime mora biti dužine 10! </p>");
                        }
                        if (!(korisnickoIme.match(maloSlovo)))
                        {
                            $("#username").css("border-color", "red");
                            $("#greske").html("<p> Mora početi s malim slovom! </p>");
                        }
                        if (!(korisnickoIme.match(velikaSlova)))
                        {
                            $("#username").css("border-color", "red");
                            $("#greske").html("<p> Mora sadržavati barem jedno veliko! </p>");
                        }
                        if (!(korisnickoIme.match(znakovi)))
                        {
                            $("#username").css("border-color", "red");
                            $("#greske").html("<p> Mora sadržavati barem dva posebna znaka! </p>");
                        }
                        if (tip !== "text")
                        {
                            $("#username").css("border-color", "red");
                            $("#greske").html("<p> Korisničko ime mora biti tipa text! </p>");
                        }
                    }
                });
            }
        });
    });
    $("#password").focusout(function (event) {
        l_p = false;
        var tip = $('#password').attr('type');
        var pass = $("#password").val();
        var uvjet = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!#$?]).+$/;
        var maloSlovo = /(?=.*?[a-z])/;
        var velikaSlovo = /(?=.*?[A-Z])/;
        var znakovi = /(?=.*?[#?!$])/;
        var brojevi = /(?=.*?[0-9])/;
        var duljina = /.{8,}/;
        if (pass.match(duljina) && tip === "password" && pass.match(maloSlovo) && pass.match(velikaSlovo) && pass.match(znakovi) && pass.match(brojevi)) {
            $("#password").css("border-color", "green");
            $("#greske").html("<p></p>");
            l_p = true;
        } else {
            if (!(pass.match(duljina)))
            {
                $("#password").css("border-color", "red");
                $("#greske").html("<p> Lozinka mora imati barem 8 znakova! </p>");
            }
            if (!(pass.match(maloSlovo)))
            {
                $("#password").css("border-color", "red");
                $("#greske").html("<p> Lozinka mora sadržavati barem jedno malo slovo! </p>");
            }
            if (!(pass.match(velikaSlovo)))
            {
                $("#password").css("border-color", "red");
                $("#greske").html("<p> Lozinka mora sadržavati barem jedno veliko slovo! </p>");
            }
            if (!((pass.match(znakovi))))
            {
                $("#password").css("border-color", "red");
                $("#greske").html("<p> Lozinka mora sadržavati barem jedan posebni znak! </p>");
            }
            if (!(pass.match(brojevi)))
            {
                $("#password").css("border-color", "red");
                $("#greske").html("<p> Lozinka mora sadržavati barem jedan broj! </p>");
            }
            if (tip !== "password")
            {
                $("#password").css("border-color", "red");
                $("#greske").html("<p> Lozinka mora biti tipa password! </p>");
            }
        }
    });

    $("#password2").focusout(function (event) {
        l2_p = false;
        var tip = $('#password2').attr('type');
        var pass = $("#password2").val();
        var potvrda = $("#password").val();

        if (tip === "password" && pass === potvrda) {
            $("#password2").css("border-color", "green");
            $("#greske").html("<p></p>");
            l2_p = true;
        } else {
            if (pass !== potvrda)
            {
                $("#password2").css("border-color", "red");
                $("#greske").html("<p> Lozinke moraju biti jednake! </p>");
            }
        }
    });
    $("#dan").focusout(function (event) {
        d_p = false;
        var tip = $('#dan').attr('type');
        var dan = $("#dan").val();
        if (tip === "number" && dan > 0 && dan < 32) {
            $("#dan").css("border-color", "green");
            $("#greske").html("<p></p>");
            d_p = true;
        } else {
            if (tip !== "number")
            {
                $("#dan").css("border-color", "red");
                $("#greske").html("<p> Dan mora biti tipa number! </p>");
            }
            if (dan <= 0 || dan > 31)
            {
                $("#dan").css("border-color", "red");
                $("#greske").html("<p> Dan mora biti u intervalu 1-31! </p>");
            }
        }
    });
    $("#mjesec").focusout(function (event) {
        m_p = false;
        var mjesec = $("#mjesec").val();
        var tip = $('#Mjeseci').prop('tagName');
        if (tip === "DATALIST" && mjesec.length !== 0) {
            $("#mjesec").css("border-color", "green");
            m_p = true;
        } else {
            if (tip !== "DATALIST")
            {
                $("#mjesec").css("border-color", "red");
                $("#greske").html("<p> Mjesec mora biti tipa Datalist! </p>");
            }
            if (mjesec.length === 0)
            {
                $("#mjesec").css("border-color", "red");
                $("#greske").html("<p> Morate izabrati vrijednost u polju mjesec! </p>");
            }
        }
    });
    $("#godina").focusout(function (event) {
        g_p = false;
        var tip = $('#godina').attr('type');
        var godina = $("#godina").val();
        if (tip === "number" && godina > 1930 && godina < 2016) {
            $("#godina").css("border-color", "green");
            $("#greske").html("<p></p>");
            g_p = true;
        } else {
            if (tip !== "number")
            {
                $("#godina").css("border-color", "red");
                $("#greske").html("<p> Godina mora biti tipa number! </p>");
            }
            if (godina <= 1930 || godina > 2015)
            {
                $("#godina").css("border-color", "red");
                $("#greske").html("<p> Godina mora biti u intervalu 1931-2015! </p>");
            }
        }
    });
    $("#mobitel").focusout(function (event) {
        mob_p = false;
        var tip = $('#mobitel').attr('type');
        var mobitel = $("#mobitel").val();
        var uvjet = /^\d{3}\s\d{7}/;
        if (tip === "tel" && mobitel.match(uvjet) && mobitel.length === 11) {
            $("#mobitel").css("border-color", "green");
            $("#greske").html("<p></p>");
            mob_p = true;
        } else {
            if (tip !== "tel")
            {
                $("#mobitel").css("border-color", "red");
                $("#greske").html("<p> Mobitel mora biti tipa tel! </p>");
            }
            if (mobitel.length > 11)
            {
                $("#mobitel").css("border-color", "red");
                $("#greske").html("<p> Broj ima previše znakova! </p>");
            }
            if (!(mobitel.match(uvjet)))
            {
                $("#mobitel").css("border-color", "red");
                $("#greske").html("<p> Format broje je XXX XXXXXXX! </p>");
            }

        }
    });
    $("#email").focusout(function (event) {
        e_p = false;
        var tip = $('#email').attr('type');
        var email = $("#email").val();
        var uvjet = /[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-z]{2,3}/;
        if (tip === "text" && email.match(uvjet)) {
            $("#email").css("border-color", "green");
            $("#greske").html("<p></p>");
            e_p = true;
        } else {
            if (tip !== "email")
            {
                $("#email").css("border-color", "red");
                $("#greske").html("<p> E-mail adresa mora biti tipa email! </p>");
            }
            if (!(email.match(uvjet)))
            {
                $("#email").css("border-color", "red");
                $("#greske").html("<p> Email mora biti format nesto@nesto.nesto! </p>");
            }
        }
    });
    $("#lokacija").focusout(function (event) {
        lok_p = false;
        var tip = $('#lokacija').prop('tagName');
        var lokacija = $("#lokacija").val();
        var uvjet = /[0-9]+;[0-9]/;
        if (tip === "TEXTAREA" && lokacija.match(uvjet)) {
            $("#lokacija").css("border-color", "green");
            $("#greske").html("<p></p>");
            lok_p = true;
        } else {
            if (tip !== "TEXTAREA")
            {
                $("#lokacija").css("border-color", "red");
                $("#greske").html("<p> Lokacija mora biti tipa textarea! </p>");
            }
            if (!(lokacija.match(uvjet)))
            {
                $("#lokacija").css("border-color", "red");
                $("#greske").html("<p> Lokacija mora imati format latitude;longitude ! </p>");
            }
        }
    });
    $("#robot").click(function (event)
    {
        robot_provjera = false;
        if ($("#robot").is(':checked'))
        {
            robot_provjera = true;
        }
    });

    $("#drzava").focusin(function (event) {

        var drzave = new Array();

        $.ajax({
            url: 'xml_json/drzave.json',
            type: 'POST',
            dataType: "json",
            success: function (data) {
                $.each(data, function (key, val) {
                    drzave.push(val);
                });
            }
        });

        $('#drzava').autocomplete({
            source: drzave
        });
    });

    $("#korisnici").dataTable({
        "bPaginate": true,
        "bSort": true,
        "bFilter": true
    });

    $(window).resize(function () {
        $("#kolonaid").hide();
    });

    $('#json').click(function () {
        var tablica = $('<table id="tablica" class="display">');
        tablica.append('<thead><tr><th>Ime</th><th>Prezime</th><th>Email</th></tr>');
        $.getJSON('xml_json/korisnici.json', function (data) {
            var tbody = $("<tbody>");
            for (i = 0; i < data.length; i++) {
                var red = "<tr>";
                red += "<td>" + data[i].ime + "</td>";
                red += "<td>" + data[i].prezime + "</td>";
                red += "<td>" + data[i].email + "</td>";
                red += "</tr>";
                tbody.append(red);
            }
            tbody.append("</tbody>");
            tablica.append(tbody);
            $('#sadrzaj_gen').html(tablica);
            $('#tablica').dataTable({
            });
        });
    });
    $('#xml').click(function () {
        var tablica = $('<table id="tablica">');
        tablica.append('<thead><tr><th>Ime</th><th>Prezime</th><th>Email</th></tr></thead>');
        $.ajax({
            type: "GET",
            url: "xml_json/korisnici.xml",
            dataType: "xml",
            success: function (data) {
                var tbody = $('<tbody>');
                $(data).find('korisnik').each(function () {
                    var red = '<tr>';
                    red += '<td>' + $(this).attr('ime') + '</td>';
                    red += '<td>' + $(this).attr('prezime') + '</td>';
                    red += '<td>' + $(this).attr('mail') + '</td>';
                    red += '</tr>';
                    tbody.append(red);
                });
                tablica.append(tbody);
                $('#sadrzaj_gen').html(tablica);
                $('#tablica').dataTable();
            }
        });
    });
});
