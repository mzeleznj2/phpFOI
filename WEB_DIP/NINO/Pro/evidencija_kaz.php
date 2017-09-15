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
    
    $upit="SELECT kazna.idkazne, k.ime, k.prezime, p.naziv, kazna.cijena, kor.ime, kor.prezime, kazna.napomena, v.registracija "
            . "FROM kazna, korisnik k, korisnik kor, vozilo v, parking p "
            . "WHERE p.idparkinga = kazna.parking "
            . "AND v.idvozila = kazna.vozilo "
            . "AND kazna.izdao = kor.idkorisnika "
            . "AND v.vlasnik = k.idkorisnika "
            . "AND kazna.placeno='0000-00-00';" ;
    $podaci=$baza->selectDB($upit);
    
    $tablica="<table id='tablica' width=90% style='margin-left: 7%'><thead><tr><th>Br. kazne</th><th>Ime Prezime</th><th>Registracija</th><th>Parkiralište</th><th>Iznos kazne</th><th>Izdao</th><th>Napomena</th></tr></thead>";
    while ($red=$podaci->fetch_array()){
        $tablica.="<tr><td>".$red[0]."</td><td>".$red[1]." ".$red[2]."</td><td>".$red[8]."</td>"               
                . "<td>".$red[3]."</td><td>".$red[4]."</td><td>".$red[5]." ".$red[6]."</td><td>".$red[7]."</td>";
    }
    $tablica.="</table>";
    
    $upit="SELECT kazna.idkazne, k.ime, k.prezime, p.naziv, kazna.cijena, kor.ime, kor.prezime, kazna.placeno, v.registracija "
            . "FROM kazna, korisnik k, korisnik kor, vozilo v, parking p "
            . "WHERE p.idparkinga = kazna.parking "
            . "AND v.idvozila = kazna.vozilo "
            . "AND kazna.izdao = kor.idkorisnika "
            . "AND v.vlasnik = k.idkorisnika "
            . "AND kazna.placeno<>'0000-00-00';" ;
    $podaci=$baza->selectDB($upit);
    
    $tablica1="<table id='tablica1' width=90% style='margin-left: 7%'><thead><tr><th>Br. kazne</th><th>Ime Prezime</th><th>Registracija</th><th>Parkiralište</th><th>Iznos kazne</th><th>Izdao</th><th>Plaćeno</th></tr></thead>";
    while ($red=$podaci->fetch_array()){
        $tablica1.="<tr><td>".$red[0]."</td><td>".$red[1]." ".$red[2]."</td><td>".$red[8]."</td>"               
                . "<td>".$red[3]."</td><td>".$red[4]."</td><td>".$red[5]." ".$red[6]."</td><td>".$red[7]."</td>";
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

        <nav id="meni">
            <ul>
                <?php
                    echo kreiranjeIzbornika($tip, $imeprezime);
                ?>
            </ul>
        </nav>
        <section id="sadrzaj">
            <div class="row">
                <ul class="button-group">
                  <li><a href="#" class="button tiny oznacen">Evidencija kazni</a></li>
                  <li><a href="evidencija_kar.php" class="button tiny">Evidencija karti</a></li>
                  <li><a href="evidencija_kor.php" class="button tiny">Evidencija korisnika</a></li>
                  <li><a href="evidencija_par.php" class="button tiny">Popis parkinga i zaposlenika</a></li>
                  <li><a href="evidencija_sustava.php" class="button tiny">Dnevnik rada</a></li>
                </ul>
            </div>
            <h4 style="text-align: center;">Neplaćene kazne</h4>
            <?php
                    echo $tablica;
            ?>  
            <h4 style="text-align: center;">Plaćene kazne</h4>
            <?php
                    echo $tablica1;
            ?>
        </section>
    
        <footer id="footer" style="position: relative;">
            <img src="img/html-5.png" alt="valid_html" />
            <img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
    </body>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>        
        <script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>  
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 
        <link href="http://datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" /> 
        <script src="js/tablice.js"></script>
</html>
