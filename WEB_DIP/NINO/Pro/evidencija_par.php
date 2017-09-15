<?php

    include_once ("okviri/baza.class.php");
    include_once ("okviri/korisnik.class.php");
    include_once ("okviri/meni.php");
    include_once ("okviri/postavi_vrijeme.php");
    $baza=new Baza();
    $korisnik=new Korisnik();
    
    session_start();
    if (!isset($_SESSION["prijava"])) {
        header("Location: zabranjeno.php?e=2");
        exit();
    }
    $korisnik=$_SESSION["prijava"];
    $tip=$korisnik->get_tip();
    $imeprezime=$korisnik->get_ime_prezime();
    
    if ($tip>1) {
        header("Location: zabranjeno.php?e=2");
        exit();
    }
    
    function zaposlenici($id){
        $baza=new Baza();
        $upit="select k.ime, k.prezime from pripada p, korisnik k "
                . "where p.parking=$id and k.idkorisnika=p.zaposlenik;";
        $podaci=$baza->selectDB($upit);
        while ($red=$podaci->fetch_array()){
            $zap.=$red[0]." ".$red[1]."<br>";
        }        
        return $zap;
    }
    
    function parking($id){
        $baza=new Baza();
        $upit="select p.naziv from pripada pr, parking p "
                . "where pr.zaposlenik=$id and p.idparkinga=pr.parking;";
        $podaci=$baza->selectDB($upit);
        while ($red=$podaci->fetch_array()){
            $par.=$red[0]."<br>";
        }        
        return $par;
    }
    
    $upit="select idparkinga, naziv, brmjesta, dnevna, mjesecna, naplata from parking;";
    $podaci=$baza->selectDB($upit);
    $tablica="<table id='tablica' width=90% style='margin-left: 7%'><thead><tr><th>Br.</th><th>Naziv parkinga</th><th>Vrijeme naplate</th><th>Br. mjesta</th><th>Dnevna</th><th>Mjesecna</th><th>Zaposlenici</th></tr></thead>";
    
    while ($red=$podaci->fetch_array()){
            $tablica.="<tr><td>".$red[0]."</td><td>".$red[1]."</td><td style=\"text-align: center;\">".$red[5]." h</td><td style=\"text-align: center;\" >".$red[2]."</td><td style=\"text-align: center;\">".$red[3]."kn</td>"
                    . "<td style=\"text-align: center;\">".$red[4]."kn</td><td style=\"text-align: center;\" >".zaposlenici($red[0])."</td>";    
    }
    $tablica.="</table>";


    $upit="select idkorisnika, ime, prezime, email, telefon from korisnik where tip=2;";
    $podaci=$baza->selectDB($upit);
    $tablica1="<table id='tablica1' width=90% style='margin-left: 7%'><thead><tr><th>Br.</th><th>Ime Prezime</th><th>E-mail</th><th>Telefon</th><th>Parking</tr></thead>";
    
    while ($red=$podaci->fetch_array()){
            $tablica1.="<tr><td>".$red[0]."</td><td>".$red[1]." ".$red[2]."</td><td>".$red[3]."</td>"
                    . "<td>".$red[4]."</td><td>".  parking($red[0])."</td>";    
    }
    $tablica1.="</table>";
    
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Parkeralište - Pregled Kazni</title>
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

        <nav id="meni" style="height: auto; ">
            <ul>
                <?php
                    echo kreiranjeIzbornika($tip, $imeprezime);
                ?>
            </ul>
        </nav>
        <section id="sadrzaj">
            <ul class="button-group">
                <li><a href="evidencija_kaz.php" class="button tiny ">Evidencija kazni</a></li>
              <li><a href="evidencija_kar.php" class="button tiny">Evidencija karti</a></li>
              <li><a href="evidencija_kor.php" class="button tiny ">Evidencija korisnika</a></li>
              <li><a href="#" class="button tiny oznacen">Popis parkinga i zaposlenika</a></li>
              <li><a href="evidencija_sustava.php" class="button tiny">Dnevnik rada</a></li>
            </ul>
            <h4 style="text-align: center;">Popis parkinga</h4>
            <?php
                    echo $tablica;
            ?>
            <h4 style="text-align: center;">Popis zaposlenika</h4>
            <?php
                    echo $tablica1;
            ?>
        </section>
    
        <footer id="footer" style="position: relative;">
           <img src="img/html-5.png" alt="valid_html" />
           <img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>        
        <script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>  
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 
        <link href="http://datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" /> 
        <script src="js/tablice.js"></script>
    </body>
</html>
