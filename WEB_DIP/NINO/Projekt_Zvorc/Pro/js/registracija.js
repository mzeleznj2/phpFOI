
$('registracija.php').ready(function(){
    
    var validno = /^[A-ZŠĐŽČĆ][a-zšđžčć]+$/;

//Provjera Ime
    $("#ime").focusout(function(event){
        var ime=$("#ime").val();
        if(!validno.test(ime)){
                $("#ime").css("box-shadow", "0 0 5px red");
                $("#ime").focus();
                $("#imeg").html("Ime nije ispravno uneseno! ");
                $("#imeg").css("color","red");
        }
        else {
                $("#ime").css("box-shadow", "0 0 5px green");
                $("#imeg").html("Ime");
                $("#imeg").css("color","green");
        }
    });

//Provjera Prezime
    $("#prezime").focusout(function(event){
        var prezime=$("#prezime").val();
        if(!validno.test(prezime)){
                $("#prezime").css("box-shadow", "0 0 5px red");
                $("#prezime").focus();
                $("#prezimeg").html("Prezime nije ispravno uneseno (Samo prvo slovo veliko)! ");
                $("#prezimeg").css("color","red");
        }
        else {
                $("#prezime").css("box-shadow", "0 0 5px green");
                $("#prezimeg").html("Prezime");
                $("#prezimeg").css("color","green");
        }
    });

//Provjera Lozinke
    $("#lozinka").focusout(function(event){
        var loz=$("#lozinka").val();        
        if(loz.length<6){
            $("#lozinka").css("box-shadow", "0 0 5px red");
            $("#lozinka").focus();
            $("#lozinkag").html("Lozinka mora sadrzavati MIN 6 znakova! ");
            $("#lozinkag").css("color","red");
        }
        else {
                $("#lozinka").css("box-shadow", "0 0 5px green");
                $("#lozinkag").html("Lozinka");
                $("#lozinkag").css("color","green");
        }

    });
    
//Provjera ponovljene lozinke
    $("#plozinka").focusout(function(event){
        var loz=$("#lozinka").val();
        var ploz=$("#plozinka").val();
        
        for (var i = 0; i < loz.length; i++) {
        if(loz[i] !== ploz[i] || loz.length !== ploz.length){
            $("#plozinka").css("box-shadow", "0 0 5px red");
            $("#plozinka").focus();
            $("#plozinkag").html("Lozinke se ne podudaraju! ");
            $("#plozinkag").css("color","red");
            return false;
        }
        $("#plozinka").css("box-shadow", "0 0 5px green");
        $("#plozinkag").html("Ponovi lozinku");
        $("#plozinkag").css("color","green");
    }

    });
    
//Provjera Korisničkog imena      
    $("#korisnickoIme").focusout(function(event){
        var korisnicko=$("#korisnickoIme").val();
        console.log("Vrijednost korisnickog unosa: "+ korisnicko);
        
        if(korisnicko.length<6){
            $("#korisnickoIme").css("box-shadow", "0 0 5px red");
            $("#korisnickoIme").focus();
            $("#greske").html("Korisničko ime (Min 6 znakova)! ");
            $("#greske").css("color","red");
        }
        
        $.ajax({
            type: 'GET',
            url: "http://arka.foi.hr/WebDiP/2013_projekti/WebDiP2013_096/okviri/korisnicko.php",
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
                if(zauzeto==1){
                    $("#korisnickoIme").css("box-shadow", "0 0 5px red");
                    $("#korisnickoIme").focus();
                    $("#greske").html("Korisničko ime je zauzeto! ");
                    $("#greske").css("color","red");
                }
                else if(korisnicko.length>5){
                     $("#korisnickoIme").css("box-shadow", "0 0 5px green");
                     $("#greske").html("Korisničko ime ");
                     $("#greske").css("color","green");
                }
            },
            
            error: function(data){
                console.log("Greska kod prijenosa podataka!!!");
            }
        });
    });

//Provjera E-maila
    $("#email").focusout(function(event){
        var email=$("#email").val();
        var zas=0;
        var validno = /^[a-zA-Z0-9._-]+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/i;
        if(!validno.test(email)){  zas=1;  }
        
        $.ajax({
            type: 'GET',
            url: "http://arka.foi.hr/WebDiP/2013_projekti/WebDiP2013_096/okviri/email.php",
            dataType: 'xml',
            
            data:{
                'korisnik':email
            },
            
            success:function(data){
                var zauzeto = "";
                $(data).find('korisnici').each(function(){
                    zauzeto=$(this).find('korisnik').text();
                });
                console.log(zauzeto);
                if(zas==1){  
                    $("#email").css("box-shadow", "0 0 5px red");
                    $("#email").focus();
                    $("#greske1").html("E-mail adresa nije valjana!");
                    $("#greske1").css("color","red");
                }
                
                else if(zauzeto==1){
                    $("#email").css("box-shadow", "0 0 5px red");
                    $("#email").focus();
                    $("#greske1").html("E-mail je zauzet! ");
                    $("#greske1").css("color","red");
                }
                else{
                     $("#email").css("box-shadow", "0 0 5px green");
                     $("#greske1").html("E-mail ");
                     $("#greske1").css("color","green");
                }
            },
            
            error: function(data){
                console.log("Greska kod prijenosa podataka!!!");
            }
        });
    });
 
//Gradovi
    var gradovi = new Array();
    $.getJSON( "http://arka.foi.hr/WebDiP/2013_projekti/WebDiP2013_096/js/gradovi.json", function( data ) {
      $.each( data, function( key, val ) {
        console.log(val);
        gradovi.push(val);
        });
    });
    
    $("#grad").autocomplete({
        source: gradovi
    });
    
//Marke
    var marke = new Array();
    $.getJSON( "http://arka.foi.hr/WebDiP/2013_projekti/WebDiP2013_096/js/marke.json", function( data ) {
      $.each( data, function( key, val ) {
        console.log(val);
        marke.push(val);
        });
    });
    
    $("#marka").autocomplete({
        source: marke
    });
});