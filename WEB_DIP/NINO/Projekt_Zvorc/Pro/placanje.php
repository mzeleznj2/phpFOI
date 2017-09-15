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
    $id=$korisnik->get_id();
    
    $idkazne=$_REQUEST["kazna"];
    
        $upit="SELECT kazna.idkazne, k.ime, k.prezime, p.naziv, kazna.cijena, kor.ime, kor.prezime, kazna.placeno, v.registracija "
            . "FROM kazna, korisnik k, korisnik kor, vozilo v, parking p "
            . "WHERE p.idparkinga = kazna.parking "
            . "AND v.idvozila = kazna.vozilo "
            . "AND kazna.izdao = kor.idkorisnika "
            . "AND v.vlasnik = k.idkorisnika "
            . "AND '$id' = k.idkorisnika "
            . "AND kazna.idkazne='$idkazne';" ;
    $podaci=$baza->selectDB($upit);
    $red=$podaci->fetch_array();
    
    $link="placeno.php?kod={$red[0]}";
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Parkeralište - Plaćanje kazne</title>
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
            <article class="karta" >
                <ul class="pricing-table"> 
                    <li class="title"><?php echo "Kazna br: ". $red[0]; ?></li> 
                    <li class="price"><?php echo $red[4].".00kn"; ?></li> 
                    <li class="description">Plaćanje kazne</li> 
                    <li class="bullet-item"><?php echo "Parkiralište: ". $red[3]; ?></li> 
                    <li class="bullet-item"><?php echo "Izdao kartu: ".$red[5]." ".$red[6]; ?></li>
                    <li class="bullet-item"><?php echo "Registracija: ".$red[8]; ?></li>
                    <li class="bullet-item"><?php echo "Platitelj: ".$korisnik->get_ime_prezime(); ?></li> 
                    <li class="cta-button">
                        <a class="button alert " href="pregled_kaz.php" >Odustani</a>&nbsp;&nbsp;
                        <a class="button " href="<?php echo $link; ?>">Plati kaznu</a>
                    </li>
                </ul>
            </article>
        </section>
    
        <footer id="footer">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/></a><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
    </body>
</html>

