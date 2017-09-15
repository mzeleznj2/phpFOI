<?php

    include_once ("okviri/baza.class.php");
    include_once ("okviri/korisnik.class.php");
    include_once ("okviri/meni.php");
    include_once ("okviri/postavi_vrijeme.php");
    $baza=new Baza();
    $korisnik=new Korisnik();
    
    session_start();    
    if (isset($_SESSION["prijava"])) {
        $korisnik=$_SESSION["prijava"];
        $tip=$korisnik->get_tip();
        $imeprezime=$korisnik->get_ime_prezime();
    }
    
    $upit="select idparkinga, naziv, brmjesta, dnevna, mjesecna, naplata from parking;";
    $podaci=$baza->selectDB($upit);
    $tablica="<table width=90% style='margin-left: 5%'><thead><tr><th>Br.</th><th>Naziv parkinga</th><th>Vrijeme naplate</th><th>Br. mjesta</th><th>Dnevna</th><th>Mjesecna</th></tr></thead>";
    
    while ($red=$podaci->fetch_array()){
            $tablica.="<tr><td>".$red[0]."</td><td>".$red[1]."</td><td style=\"text-align: center;\">".$red[5]." h</td><td style=\"text-align: center;\" >".$red[2]."</td><td style=\"text-align: center;\">".$red[3]."kn</td>"
                    . "<td style=\"text-align: center;\">".$red[4]."kn</td></tr>";    
    }
    $tablica.="</table>";
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Parkeralište - O parkiralištu</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/css_nzvorc.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <script src="js/vendor/modernizr.js"></script>
    </head>
    <body>

        <header>
            <div style="width: 50%; display: inline-block; box-sizing: border-box;">arkeralište -  eParking                
            </div>
              <div style="text-align: right; font-size: 14px; width: 45%; display: inline-block; line-height: 20px; ">
                      <?php 
                        echo ispisi_vrijeme();
                      ?>
              </div>
        </header>
        
        <hr class="jedan"/>
        <hr class="dva"/>
        <hr class="tri"/>

        <nav id="meni">
            <ul>
                <?php
                    echo kreiranjeIzbornika($tip, $imeprezime);
                ?>
            </ul>
        </nav>
        <section id="sadrzaj" style="margin-left: 10px;">
            <article>
                <p class="naslov">O Parkiralištu</p>
                
                <p>Parkeralište je e-sustav koji omogućuje lakše korištenje parkirališta. Na ovom e-sustavu možete kupiti karte za naša parkirališta, potrebna vam je samo internetska veze te neki od prijenosnih uređaja.(SmartPhone, Tablet, Laptop) da bi putem sustava mogli kupiti kartu.</p>
                <p>Funkcionalnosti koje nudi Parkeralište e-parking su: </p>
                <ul>
                    <li>Kupnja karte</li>
                    <li>Plaćanje kazne</li>
                    <li>Pregled vežećih i nevažećih karti</li>
                    <li>Pregled plaćenih i neplaćenih kazni</li>
                    <li>Pregled svih parkirališta</li>
                </ul>
                <p>Sustav raspolaže s 5 parkirališta koje detaljno možete pogledati <a href="#" data-reveal-id="popis">ovdje.</a></p>
           
            </article>
        </section>
        
        <div id="popis" class="reveal-modal" data-reveal> 
            <h2>Popis naših parkirališta</h2>
            <br>
            <?php
                    echo $tablica;
            ?>

            <a class="close-reveal-modal">&#215;</a> 
        </div>
        
        <script src="js/foundation/foundation.js"></script>
        <script src="js/foundation/foundation.reveal.js"></script>
        
        <script>
            $(document).foundation();
        </script>
    
        <footer id="footer">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/></a><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
    </body>
</html>
