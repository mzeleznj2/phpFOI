
$('unosKazna.php').ready(function(){
    
//Registracije
    var registracije = new Array();
    $.getJSON( "http://arka.foi.hr/WebDiP/2013_projekti/WebDiP2013_096/okviri/registracije.php", function( data ) {
      $.each( data, function( key, val ) {
        console.log(val);
        registracije.push(val);
        });
    });
    
    $("#reg").autocomplete({
        source: registracije
    });

});