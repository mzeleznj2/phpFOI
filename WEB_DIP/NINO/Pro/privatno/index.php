<?php

    include_once ("../okviri/baza.class.php");
    $baza=new Baza();
      
    $upit="select k.idkorisnika, k.ime, k.prezime, k.adresa, k.grad, k.email, k.telefon, t.naziv, k.aktivan "
            . "from korisnik k, tip_korisnika t where t.idtipa=k.tip;";
    $podaci=$baza->selectDB($upit);
    $tablica="<table width=80% style='margin-left: 10%'><thead><tr><th>Ime Prezime</th><th>Adresa</th><th>Grad</th><th>E-mail</th><th>Telefon</th><th>Tip korisnika</th><th>Detalji</th></tr></thead>";
    while ($red=$podaci->fetch_array()){        
            $tablica.="<tr><td>".$red[1]." ".$red[2]."</td><td>".$red[3]."</td><td>".$red[4]."</td>"
                    . "<td>".$red[5]."</td><td>".$red[6]."</td><td>".$red[7]."</td>"
                    . "<td align=center ><a href=\"detalji.php?korisnik={$red[0]}\"><img src='../img/detalji.gif' alt='detalji' /></a></td></tr>"; 
    }
    $tablica.="</table>";
    
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Parkeralište - Pregled Kazni</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="../css/foundation.css" />
        <link rel="stylesheet" href="../css/css_nzvorc.css" />
        <script src="../js/vendor/modernizr.js"></script>
        </head>
    <body>

        <header>
            arkeralište -  eParking
        </header>

        <hr class="jedan"/>
        <hr class="dva"/>
        <hr class="tri"/>
        
            <h4 style="text-align: center;">Svi korisnici</h4>
            <?php
                    echo $tablica;
            ?>            
     
    
        <footer id="footer" style="position: relative;">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="../img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="../img/css.png" alt="valid_css" style="margin-bottom: 3px;"/></a><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
    </body>
</html>