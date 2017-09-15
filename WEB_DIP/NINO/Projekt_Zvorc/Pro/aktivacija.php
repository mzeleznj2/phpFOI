<?php

    include_once ("okviri/baza.class.php");
    include_once ("okviri/postavi_vrijeme.php");
    $baza=new Baza();
    
    $kod=$_REQUEST["kod"];    
    $upit="select ime, prezime, vrijeme from korisnik WHERE kod ='$kod';";
    $podaci=$baza->selectDB($upit);
    if($podaci){
        $red=$podaci->fetch_array();
        $ime=$red[0];
        $prezime=$red[1];                
    }
    else{
        header("Location: zabranjeno.php?e=2");
        exit();
    }
    
    $upit="select pomak from pomak;";
    $podaci=$baza->selectDB($upit);
    $red=$podaci->fetch_array();
    $vrijeme_servera = time();

    $vrijeme_sustava = $vrijeme_servera + ($red[0] * 60 * 60);     
    $datum=date('Y-m-d H:i:s', $vrijeme_sustava);
    if($red[2]>$datum){
        $upit="UPDATE korisnik SET aktivan = '1', kod = '0' WHERE kod ='$kod';";
        if(!$baza->updateDB($upit)){
            echo "Greska";
        }
        $poruka="$ime  $prezime , Vas račun je aktiviran";
    }
    else{ 
        $poruka="Vrijeme za Vašu aktivaciju je isteklo. Javite se administratoru.";
    }
        
?>

<!DOCTYPE html>
<!--
Ovo je pocetak mog projekta iz WebDiP-a na temu e-parkiraliste.
Započet: 31.05.2014 11:00
-->
<html>
    <head>
        <title>Parkeralište - aktivacija</title>
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
                    echo "<li><a href=\"index.php\"><img src=\"img/home.gif\" alt=\"home\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Početna</a></li>"
                     ."<li> <a href=\"prijava.php\"><img src=\"img/login.gif\" alt=\"login\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Prijava</a></li>"
                     ."<li><a href=\"registracija.php\"><img src=\"img/sign.gif\" alt=\"sign\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Registracija</a></li>"
                     ."<li><a href=\"dokumentacija.php\"><img src=\"img/doc.gif\" alt=\"doc\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Dokumentacija</a></li>"
                     ."<li><a href=\"oparkingu.php\"><img src=\"img/about.gif\" alt=\"about\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;O parkiralištu</a></li>";
                ?>
            </ul>
        </nav>
        <section id="sadrzaj">
            <h4 style="text-align: center;" > <?php echo $poruka; ?> </h4>
           
        </section>
               

        <footer id="footer">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/></a><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
    </body>
</html>

