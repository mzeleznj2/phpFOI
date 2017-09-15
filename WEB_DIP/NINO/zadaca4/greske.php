<?php
$id=$_REQUEST["greska"];
$poruka = "";
$poruka=$_REQUEST["pogreska"];

    switch ($id) {
        case 1: $poruka .= "GRESKA: REGISTRACIJA -> E-mail adresa je zauzeta!<br/>";
            break;
        case 2: $poruka .= "GRESKA: REGISTRACIJA -> Ime nije pisano velikim slovom.<br />";
            break;
        case 3: $poruka .= "GRESKA: REGISTRACIJA -> Prezime nije pisano velikim slovom.<br />";
            break;
        case 4: $poruka .= "GRESKA: REGISTRACIJA -> Netocno strukturirana e-mail adresa.<br />";
            break;
        case 5: $poruka .= "GRESKA: REGISTRACIJA -> Korisnicko ime ima manje od 6 znakova.<br />";
            break;
        case 6: $poruka .= "GRESKA: REGISTRACIJA -> Lozinka ima manje od 6 znakova.<br />";
            break;
        case 7: $poruka .= "GRESKA: REGISTRACIJA -> Lozinke nisu iste.<br />";
            break;
        case 8: $poruka .= "GRESKA: AKTIVACIJA -> Greska kod rada sa bazom.<br />";
            break;
    }
echo $poruka;
?>