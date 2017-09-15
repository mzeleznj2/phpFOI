
$('unosParkinga.php').ready(function(){
    
//Registracije
    var korisnik = new Array();
    $.getJSON( "http://arka.foi.hr/WebDiP/2013_projekti/WebDiP2013_096/okviri/imeprezime.php", function( data ) {
      $.each( data, function( key, val ) {
        console.log(val);
        korisnik.push(val);
        });
    });
    
    $("#korisnik").autocomplete({
        source: korisnik
    });

});