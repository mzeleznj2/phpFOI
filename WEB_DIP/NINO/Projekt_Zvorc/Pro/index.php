<?php

    include_once ("okviri/korisnik.class.php");  
    include_once ("okviri/meni.php");  
    include_once ("okviri/postavi_vrijeme.php");
    $korisnik=new Korisnik();
    
    session_start();
    if (isset($_SESSION["prijava"])) {
        $korisnik=$_SESSION["prijava"];
        $tip=$korisnik->get_tip();
        $imeprezime=$korisnik->get_ime_prezime();
    }
?>

<!DOCTYPE html>
<!--
Ovo je pocetak mog projekta iz WebDiP-a na temu e-parkiraliste.
Započet: 31.05.2014 11:00
-->
<html>
    <head>
        <title>Parkeralište - e-parking</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/css_nzvorc.css" />
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
        <section id="sadrzaj">
            <p class="naslov" >Dobrodošli na stranicu Parkeralište - eParking</p>

        </section>
        <footer id="footer">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/></a><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
    </body>
</html>
