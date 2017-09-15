
function promjena_velicine_ekrana() {
    if ($(window).width() === 320)
    {
        $('td:nth-child(1n+5),th:nth-child(1n+5)').hide();
    }
    if ($(window).width() === 480)
    {
        $('td:nth-child(1n+6),th:nth-child(1n+6)').hide();
    }
    if ($(window).width() === 640)
    {
        $('td:nth-child(1n+8),th:nth-child(1n+8)').hide();
    }
    if ($(window).width() === 1136)
    {
        $('td:nth-child(1n+12),th:nth-child(1n+12)').hide();
    }
    if ($(window).width() === 720)
    {
        $('td:nth-child(1n+7),th:nth-child(1n+7)').hide();
    }
    if ($(window).width() === 1280)
    {
        //
    }

}


$(document).ready(function () {

    $(function () {
        var drzave = new Array();
        $.getJSON("xml_json/drzave.json",
                function (data) {
                    $.each(data, function (key, val) {
                        console.log(val);
                        drzave.push(val);
                    });
                });

        $('#drzava').autocomplete({
            source: drzave
        });
    });


    $(function () {
        $('#korisnici').dataTable(
                {
                    "aaSorting": [[0, "asc"], [1, "asc"], [2, "asc"]],
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true
                });
    });


    $(function () {
        $('#json').click(function () {
            var tablica = $('<table id="tablica" class="display">');
            tablica.append('<thead><tr><th>Korisnik ID</th><th>Status ID</th><th>Tip ID</th><th>Korisničko ime</th><th>Ime</th><th>Prezime</th><th>Email</th><th>Slika</th><th>Aktivacijski kod</th><th>Neuspješne prijave</th><th>Blokiran do</th><th>Lozinka</th></tr>');

            $.getJSON('xml_json/korisnici.json', function (data) {
                var tbody = $("<tbody>");
                for (i = 0; i < data.length; i++) {
                    var red = "<tr>";
                    red += "<td>" + data[i].id_korisnik + "</td>";
                    red += "<td>" + data[i].id_status + "</td>";
                    red += "<td>" + data[i].id_tip + "</td>";
                    red += "<td>" + data[i].korisnicko_ime + "</td>";
                    red += "<td>" + data[i].ime + "</td>";
                    red += "<td>" + data[i].prezime + "</td>";
                    red += "<td>" + data[i].email + "</td>";
                    red += "<td>" + data[i].slika + "</td>";
                    red += "<td>" + data[i].aktivacijski_kod + "</td>";
                    red += "<td>" + data[i].neuspjesne_prijave + "</td>";
                    red += "<td>" + data[i].blokiran_do + "</td>";
                    red += "<td>" + data[i].lozinka + "</td>";
                    red += "</tr>";
                    tbody.append(red);
                }
                tbody.append("</tbody>");
                tablica.append(tbody);
                $('#content').html(tablica);
                $(function () {
                    $('#tablica').dataTable(
                            {
                                "aaSorting": [[0, "asc"], [1, "asc"], [2, "asc"]],
                                "bPaginate": true,
                                "bLengthChange": true,
                                "bFilter": true,
                                "bSort": true,
                                "bInfo": true,
                                "bAutoWidth": true
                            });
                });
            });
        });
    });

    $(function () {
        $('#xml').click(function () {
            $.ajax({
                url: 'xml_json/korisnici.xml',
                type: 'GET',
                dataType: 'xml',
                success: function (xml) {
                    var tablica = '<table id="tablica" class="display">';
                    tablica += '<thead><tr><th>Korisnik ID</th><th>Status ID</th><th>Tip ID</th><th>Korisničko ime</th><th>Ime</th><th>Prezime</th><th>Email</th><th>Slika</th><th>Aktivacijski kod</th><th>Neuspješne prijave</th><th>Blokiran do</th><th>Lozinka</th></tr></thead>';
                    var tbody = $('<tbody>');
                    $(xml).find('korisnik').each(function () {
                        var red = '<tr>';
                        red += '<td>' + $(this).attr('id') + '</td>';
                        red += '<td>' + $(this).attr('status') + '</td>';
                        red += '<td>' + $(this).attr('tip') + '</td>';
                        red += '<td>' + $(this).attr('korime') + '</td>';
                        red += '<td>' + $(this).attr('ime') + '</td>';
                        red += '<td>' + $(this).attr('prezime') + '</td>';
                        red += '<td>' + $(this).attr('mail') + '</td>';
                        red += '<td>' + $(this).attr('slika') + '</td>';
                        red += '<td>' + $(this).attr('kod') + '</td>';
                        red += '<td>' + $(this).attr('prijave') + '</td>';
                        red += '<td>' + $(this).attr('blokiran') + '</td>';
                        red += '<td>' + $(this).attr('pass') + '</td>';
                        red += '</tr>';
                        tbody += red;
                    });

                    tbody += "</tbody>";
                    tablica += tbody;
                    tablica += '</table>';
                    $('#content')[0].innerHTML = tablica;

                    $(function () {
                        $('#tablica').dataTable(
                                {
                                    "aaSorting": [[0, "asc"], [1, "asc"], [2, "asc"]],
                                    "bPaginate": true,
                                    "bLengthChange": true,
                                    "bFilter": true,
                                    "bSort": true,
                                    "bInfo": true,
                                    "bAutoWidth": true
                                });
                    });
                }
            });
        });
    });


    $("#ime").focus(function () {
        $('#ime').addClass('plava');
    });

    $("#ime").blur(function () {
        $('#ime').removeClass('plava');
    });

    $("#prezime").focus(function () {
        $('#prezime').addClass('plava');
    });

    $("#prezime").blur(function () {
        $('#prezime').removeClass('plava');
    });

    $("#korisnickoime").focus(function () {
        $('#korisnickoime').addClass('plava');
    });

    $("#korisnickoime").blur(function () {
        $('#korisnickoime').removeClass('plava');
    });

    $("#lozinka1").focus(function () {
        $('#lozinka1').addClass('plava');
    });

    $("#lozinka1").blur(function () {
        $('#lozinka1').removeClass('plava');
    });

    $("#lozinka2").focus(function () {
        $('#lozinka2').addClass('plava');
    });

    $("#lozinka2").blur(function () {
        $('#lozinka2').removeClass('plava');
    });

    $("#enkripcija").focus(function () {
        $('#enkripcija').addClass('plava');
    });

    $("#enkripcija").blur(function () {
        $('#enkripcija').removeClass('plava');
    });

    $("#rodendan").focus(function () {
        $('#rodendan').addClass('plava');
    });

    $("#rodendan").blur(function () {
        $('#rodendan').removeClass('plava');
    });

    $("#mjesec_rodenja").focus(function () {
        $('#mjesec_rodenja').addClass('plava');
    });

    $("#mjesec_rodenja").blur(function () {
        $('#mjesec_rodenja').removeClass('plava');
    });

    $("#godina").focus(function () {
        $('#godina').addClass('plava');
    });

    $("#godina").blur(function () {
        $('#godina').removeClass('plava');
    });

    $("#spol").focus(function () {
        $('#spol').addClass('plava');
    });

    $("#spol").blur(function () {
        $('#spol').removeClass('plava');
    });

    $("#drzava").focus(function () {
        $('#drzava').addClass('plava');
    });

    $("#drzava").blur(function () {
        $('#drzava').removeClass('plava');
    });

    $("#telefon").focus(function () {
        $('#telefon').addClass('plava');
    });

    $("#telefon").blur(function () {
        $('#telefon').removeClass('plava');
    });

    $("#email").focus(function () {
        $('#email').addClass('plava');
    });

    $("#email").blur(function () {
        $('#email').removeClass('plava');
    });

    $("#label_robot").focus(function () {
        $('#label_robot').addClass('plava');
    });

    $("#label_robot").blur(function () {
        $('#label_robot').removeClass('plava');
    });

    $("#lokacija").focus(function () {
        $('#lokacija').addClass('plava');
    });

    $("#lokacija").blur(function () {
        $('#lokacija').removeClass('plava');
    });

    $("#slika").focus(function () {
        $('#slika').addClass('plava');
    });

    $("#slika").blur(function () {
        $('#slika').removeClass('plava');
    });

    $("#label_obavijesti").focus(function () {
        $('#label_obavijesti').addClass('plava');
    });

    $("#label_obavijesti").blur(function () {
        $('#label_obavijesti').removeClass('plava');
    });
    
    $("#ime").focusout(function (event) {
        var re = new RegExp(/\w/);
        var ok = re.test($("#ime").val());
        if (!ok)
        {
            event.preventDefault();
            $('#ime').addClass('crvena');
            alert("Niste unijeli ime!");
        } else
        {
            $('#ime').addClass('zelena');
            $('#ime').removeClass('crvena');
        }
    });

    $("#prezime").focusout(function (event) {
        var re = new RegExp(/\w/);
        var ok = re.test($("#prezime").val());
        if (!ok)
        {
            event.preventDefault();
            $('#prezime').addClass('crvena');
            alert("Niste unijeli prezime!");
        } else
        {
            $('#prezime').addClass('zelena');
            $('#prezime').removeClass('crvena');
        }
    });

    $("#korisnickoime").focusout(function (event) {
        var re = new RegExp(/^[a-z](?=.*[A-Z])(?=(.*[-_!#$?]){2})[A-Za-z\d-_!#$?]{9,}/);
        var ok = re.test($("#korisnickoime").val());
        var re2 = new RegExp(/text/);
        var ok2 = re2.test($("#korisnickoime").get(0).type);
        if (!ok)
        {
            event.preventDefault();
            $('#korisnickoime').addClass('crvena');
            alert("Neispravano korisničko ime!");
        } else if (!ok2)
        {
            event.preventDefault();
            $('#korisnickoime').addClass('crvena');
            alert("Greška: Korisničko ime nije tipa text!");
        } else
        {
            $('#korisnickoime').addClass('zelena');
            $('#korisnickoime').removeClass('crvena');
        }
    });

    $("#korisnickoime").focusout(function (event) {
        var korime = $("#korisnickoime").val();
        $.ajax({
            url: 'https://barka.foi.hr/WebDiP/2015/materijali/zadace/dz3_dio2/korisnik.php',
            type: 'GET',
            data: {'korisnik': korime},
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('korisnik').each(function () {
                    if ($(this).text() === '1') {
                        $('#korime_greska').html("Korisničko ime '" + korime + "' je zauzeto!");
                        $("#korime_greska").toggle("highlight");
                        $("#korime_greska").toggle("highlight");
                        $("#korime_greska").toggle("highlight");
                        $("#korime_greska").toggle("highlight");
                        $("#korime_greska").toggle("highlight");
                        $("#korisnickoime").focus();
                    } else
                        $('#korime_greska').html(" ");
                });
            }
        });
    });

    $("#lozinka1").focusout(function (event) {
        var re = new RegExp(/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!#$?])[A-Za-z\d!#$?]{8,}/);
        var ok = re.test($("#lozinka1").val());
        var re2 = new RegExp(/password/);
        var ok2 = re2.test($("#lozinka1").get(0).type);
        if (!ok)
        {
            event.preventDefault();
            $('#lozinka1').addClass('crvena');
            alert("Neispravana lozinka!");
        } else if (!ok2)
        {
            event.preventDefault();
            $('#lozinka1').addClass('crvena');
            alert("Greška: Lozinka nije tipa password!");
        } else
        {
            $('#lozinka1').addClass('zelena');
            $('#lozinka1').removeClass('crvena');
        }
    });

    $("#lozinka2").focusout(function (event) {
        var loz = $("#lozinka1").val();
        var ok = $("#lozinka2").val();
        var re2 = new RegExp(/password/);
        var ok2 = re2.test($("#lozinka2").get(0).type);
        if (ok !== loz)
        {
            event.preventDefault();
            $('#lozinka2').addClass('crvena');
            alert("Ponovljena lozinka krivo upisana!");
        } else if (!ok2)
        {
            event.preventDefault();
            $('#lozinka2').addClass('crvena');
            alert("Greška: Lozinka nije tipa password!");
        } else
        {
            $('#lozinka2').addClass('zelena');
            $('#lozinka2').removeClass('crvena');
        }
    });

    $("#enkripcija").focusout(function (event) {
        var re = new RegExp(/\w/);
        var ok = re.test($("#enkripcija").val());
        if (!ok)
        {
            event.preventDefault();
            $('#enkripcija').addClass('crvena');
            alert("Niste unijeli enkripciju!");
        } else
        {
            $('#enkripcija').addClass('zelena');
            $('#enkripcija').removeClass('crvena');
        }
    });


    $("#rodendan").focusout(function (event) {
        var re = new RegExp(/^[0-9]{1,2}/);
        var ok = re.test($("#rodendan").val());
        var re2 = new RegExp(/number/);
        var ok2 = re2.test($("#rodendan").get(0).type);
        if (!ok)
        {
            event.preventDefault();
            $('#rodendan').addClass('crvena');
            alert("Neispravan dan rođenja!");
        } else if (!ok2)
        {
            event.preventDefault();
            $('#rodendan').addClass('crvena');
            alert("Greška: Dan rođenja nije tipa number!");
        } else
        {
            $('#rodendan').addClass('zelena');
            $('#rodendan').removeClass('crvena');
        }
    });

    $("#mjesec_rodenja").focusout(function (event) {
        var re = new RegExp(/^(Siječanj|Veljača|Ožujak|Travanj|Svibanj|Lipanj|Srpanj|Kolovoz|Rujan|Listopad|Studeni|Prosinac)/);
        var ok = re.test($("#mjesec_rodenja").val());
        var re2 = new RegExp(/DATALIST/);
        var ok2 = re2.test($("#mjesec").get(0).tagName);
        if (!ok)
        {
            event.preventDefault();
            $('#mjesec_rodenja').addClass('crvena');
            alert("Neispravan mjesec rođenja!");
        } else if (!ok2)
        {
            event.preventDefault();
            $('#mjesec_rodenja').addClass('crvena');
            alert("Greška: Mjesec rođenja nije tipa datalist!");
        } else
        {
            $('#mjesec_rodenja').addClass('zelena');
            $('#mjesec_rodenja').removeClass('crvena');
        }
    });

    $("#godina").focusout(function (event) {
        var re = new RegExp(/(^[1]{1}[9]{1}[3-9]{1}[0-9]{1}$)|(^[2]{1}[0]{1}[0-1]{1}[0-5]{1}$)/);
        var ok = re.test($("#godina").val());
        var re2 = new RegExp(/number/);
        var ok2 = re2.test($("#godina").get(0).type);
        if (!ok)
        {
            event.preventDefault();
            $('#godina').addClass('crvena');
            alert("Neispravna godina rođenja!");
        } else if (!ok2)
        {
            event.preventDefault();
            $('#godina').addClass('crvena');
            alert("Greška: Godina rođenja nije tipa number!");
        } else
        {
            $('#godina').addClass('zelena');
            $('#godina').removeClass('crvena');
        }
    });

    $("#spol").focusout(function (event) {
        var re = new RegExp(/\w/);
        var ok = re.test($("#spol").val());
        if (!ok)
        {
            event.preventDefault();
            $('#spol').addClass('crvena');
            alert("Niste unijeli spol!");
        } else
        {
            $('#spol').addClass('zelena');
            $('#spol').removeClass('crvena');
        }
    });

    $("#drzava").focusout(function (event) {
        var re = new RegExp(/\w/);
        var ok = re.test($("#drzava").val());
        if (!ok)
        {
            event.preventDefault();
            $('#drzava').addClass('crvena');
            alert("Niste unijeli drzavu!");
        } else
        {
            $('#drzava').addClass('zelena');
            $('#drzava').removeClass('crvena');
        }
    });

    $("#telefon").focusout(function (event) {
        var re = new RegExp(/^(\d){3}[\ ]\d{7}$/);
        var ok = re.test($("#telefon").val());
        var re2 = new RegExp(/tel/);
        var ok2 = re2.test($("#telefon").get(0).type);
        if (!ok)
        {
            event.preventDefault();
            $('#telefon').addClass('crvena');
            alert("Neispravan telefonski broj!");
        } else if (!ok2)
        {
            event.preventDefault();
            $('#telefon').addClass('crvena');
            alert("Greška: Telefonski broj nije tipa tel!");
        } else
        {
            $('#telefon').addClass('zelena');
            $('#telefon').removeClass('crvena');
        }
    });

    $("#email").focusout(function (event) {
        var re = new RegExp(/^\w{2,}@(\w{2,}\.){1}\w{2,}$/);
        var ok = re.test($("#email").val());
        var re2 = new RegExp(/email/);
        var ok2 = re2.test($("#email").get(0).type);
        if (!ok)
        {
            event.preventDefault();
            $('#email').addClass('crvena');
            alert("Neispravan email!");
        } else if (!ok2)
        {
            event.preventDefault();
            $('#email').addClass('crvena');
            alert("Greška: Email nije tipa email!");
        } else
        {
            $('#email').addClass('zelena');
            $('#email').removeClass('crvena');
        }
    });

    $("#robot").focusout(function (event) {
        var re = new RegExp(/true/);
        var ok = re.test($("#robot").get(0).checked);
        if (!ok)
        {
            event.preventDefault();
            $('#label_robot').addClass('crvena');
            alert("Označite da niste robot!");
        } else
        {
            $('#label_robot').addClass('zelena');
            $('#label_robot').removeClass('crvena');
        }
    });

    $("#lokacija").focusout(function (event) {
        var re = new RegExp(/^(\d{1,2}\.\d{1,})\;(\d{1,2}\.\d{1,})$/);
        var ok = re.test($("#lokacija").val());
        var re2 = new RegExp(/textarea/);
        var ok2 = re2.test($("#lokacija").get(0).type);
        if (!ok)
        {
            event.preventDefault();
            $('#lokacija').addClass('crvena');
            alert("Pogrešan unos lokacije!");
        } else if (!ok2)
        {
            event.preventDefault();
            $('#lokacija').addClass('crvena');
            alert("Greška: Lokacija nije tipa textarea!");
        } else
        {
            $('#lokacija').addClass('zelena');
            $('#lokacija').removeClass('crvena');
        }
    });

    $("#slika").focusout(function (event) {
        var re = new RegExp(/\w/);
        var ok = re.test($("#slika").val());
        if (!ok)
        {
            event.preventDefault();
            $('#slika').addClass('crvena');
            alert("Niste unijeli sliku!");
        } else
        {
            $('#slika').addClass('zelena');
            $('#slika').removeClass('crvena');
        }
    });

    $("#obavijesti1").focusout(function (event) {
        var re = new RegExp(/\w/);
        var ok = re.test($("#obavijesti1").val());
        if (!ok)
        {
            event.preventDefault();
            $('#label_obavijesti').addClass('crvena');
            alert("Niste označili polje obavijesti!");
        } else
        {
            $('#label_obavijesti').addClass('zelena');
            $('#label_obavijesti').removeClass('crvena');
        }
    });

});
