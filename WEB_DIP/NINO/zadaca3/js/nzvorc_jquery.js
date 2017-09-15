

$('registracija_jquery.html').ready(function(){
    
    $("#korisnickoIme").focusout(function(event){
        var korisnicko=$("#korisnickoIme").val();
        console.log("Vrijednost korisniÄ?kog unosa: "+ korisnicko);
        
        $.ajax({
            type: 'GET',
            url: "korisnici.xml",
            dataType: 'xml',
            
            data:{
                'korisnik':korisnicko
            },
            
            success:function(data){
                var zauzeto = "";
                $(data).find('korisnici').each(function(){
                    zauzeto=$(this).find('korisnik').text();
                });
                console.log(zauzeto);
                if(zauzeto===1){
                    $("#korisnickoIme").toggle("highlight");
                    $("#korisnickoIme").css("background-color","#FF9966");
                    $("#korisnickoIme").focus();
                    $("#greske1").html("<p>Greska: Korisnicko ime je zauzeto!!!</p>");
                }
                else{
                     console.log("Korisnicko ime je slobodno");
                     $("#korisnickoIme").css("background-color","white");
                     $("#greske1").html("");
                }
            },
            
            error: function(data){
                console.log("Greska kod prijenosa podataka!!!");
            }
        });
    });
    
    $("#email").focusout(function(event){
        var korisnicko=$("#email").val();
        console.log("Vrijednost korisnickog unosa: "+ korisnicko);
        var zas=0;
        var validno = /^[a-zA-Z0-9._-]+@foi.hr/i;
        if(!validno.test(korisnicko)){  zas=1;  }
        
        $.ajax({
            type: 'GET',
            url: "http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/korisnikEmail.php",
            dataType: 'xml',
            
            data:{
                'korisnik':korisnicko
            },
            
            success:function(data){
                var zauzeto = "";
                $(data).find('korisnici').each(function(){
                    zauzeto=$(this).find('korisnik').text();
                });
                console.log(zauzeto);
                if(zas===1){  
                    $("#email").css("background-color","#FF9966");
                    $("#email").focus();
                    $("#greske1").html("<p>Greska: E-mail adresa nije valjana!!!</p>");
                }
                
                else if(zauzeto===1){                   
                    $("#email").toggle("highlight");
                    $("#email").css("background-color","#FF9966");
                    $("#email").focus();
                    $("#greske1").html("<p>Greska: E-mail je zauzeti!!!</p>");
                }
                else{
                     console.log("E-mail je slobodan");
                     $("#email").css("background-color","white");
                     $("#greske1").html("");
                }
            },
            
            error: function(data){
                console.log("Greska kod prijenosa podataka!!!");
            }
        });
    });
    
    var gradovi = new Array();
    $.getJSON( "http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/gradovi.json", function( data ) {
      $.each( data, function( key, val ) {
        console.log(val);
        gradovi.push(val);
        });
    });
    
    $("#grad").autocomplete({
        source: gradovi
    });

    
});

$(document).ready(function(){
    
    $("#korisnici").dataTable({
        "aaSorting" : [[0,"asc"],[1,"asc"]],
        "bPaginate" : true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true });
});

$(function() {
    $("#jsontablica").click(function() {
        var tablica = $('<table id="tablica">');
        tablica.append("<thead><tr><th>Ime</th><th>Prezime</th><th>Email</th></tr></thead>");
        $.getJSON("http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/korisnici.json", function(data) {
            var tbody = $("<tbody>");
            for (i = 0; i < data.length; i++) {
                var red = "<tr>";
                red += "<td>" + data[i].ime + "</td>";
                red += "<td>" + data[i].prezime + "</td>";
                red += "<td>" + data[i].email + "</td>";
                red += "</tr>";
                tbody.append(red);
            }
            tablica.append(tbody);
            $("#content").html(tablica);
            $("#tablica").dataTable();

        });
    });
    
});