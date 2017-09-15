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
    
    $forma="";
    $tabla="display: none;";

    if(isset($_POST["parking"])){
        $id_parkinga=$_POST["parking"];
        $karta=$_POST["karta"];
        
        $forma="display: none;";
        $tabla="";
              
        $upit="select naziv, $karta from parking where '$id_parkinga'=idparkinga ";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $naziv_parkinga=$red[0];
        $cijena=$red[1];
      
        $upit="select pomak from pomak;";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $vrijeme_servera = time();

        $vrijeme_sustava = $vrijeme_servera + ($red[0] * 60 * 60);        
        $pocetak=date('Y-m-d', $vrijeme_sustava);
        if($karta=="dnevna") {
            $vrsta_karte="Dnevna";            
            $kraj=date('Y-m-d', $vrijeme_sustava);
            $vrijedi=date('d.m.Y', $vrijeme_sustava);
        }
        elseif($karta=="mjesecna") {
            $vrsta_karte="Mjesečna";
            $vr=strtotime('+1 month') + ($red[0] * 60 * 60);
            $kraj=date('Y-m-d', $vr);            
            $vrijedi=date('d.m.Y', $vr);
        }
        
        $idvlasnika=$korisnik->get_id();
        
        $upit="select idvozila from vozilo where vlasnik='$idvlasnika';";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $vozilo=$red[0];
        
        $kod=rand()+1;
        
        $upit="insert into karta  VALUES('default','$cijena','$pocetak','$kraj','$vozilo','$id_parkinga','$kod');";
        $baza->updateDB($upit);
        
        $upit="select idkarte from karta where '$kod'=kod; ";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $broj=$red[0];
        
        $potvrdi="potvrda.php?karta={$kod}";
        $odustani="odustani.php?karta={$kod}";
    }

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Parkeralište - Kupnja karte</title>
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
            <article style="<?php echo $forma; ?>" >
                  <form name="registracija" class="forma2" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <fieldset>
                    <legend class="naslov" >Kupnja karte</legend>
                    
                    <div class="row">
                      <div class="large-6 columns">
                          <label for="parking">Parking: </label>
                          <select name="parking" id="parking" >
                              <option value="0" selected="selected">Odaberi parking</option>
                              <option value="1" >Čakovec</option>
                              <option value="2" >Varaždin</option>
                              <option value="3" >Zagreb Sjever</option>
                              <option value="4" >Zagreb Središte</option>
                              <option value="5" >Zagreb Jug</option>
                          </select>
                      </div> 
                      <div class="large-6 columns">
                          <label for="karta">Vrsta: </label>
                          <select name="karta" id="karta" >
                              <option value="0" selected="selected">Odaberi vrstu karte</option>
                              <option value="dnevna" >Dnevna</option>
                              <option value="mjesecna" >Mjesečna</option>
                          </select>
                      </div> 
                    </div>
                    
                    <div class="row" >
                        <div class="large-8 columns">
                            <input id="checkbox" type="checkbox" required="" ><label for="checkbox">Potvrđujem i prihvaćam uvjete kupnje karte</label>
                        </div>
                        <div class="large-4 columns">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="large-4 small-8 large-centered small-centered columns">
                            <input type="submit" value="Nastavi" class="button expand tiny"/> 
                        </div>
                    </div>
                    </fieldset>  
                </form>
            </article>
            <article class="karta"  style="<?php echo $tabla; ?>" >
                <ul class="pricing-table"> 
                    <li class="title"><?php echo "Karta br: ". $broj; ?></li> 
                    <li class="price"><?php echo $cijena.".00kn"; ?></li> 
                    <li class="description">Kupnja karte</li> 
                    <li class="bullet-item"><?php echo "Parkiralište: ". $naziv_parkinga; ?></li> 
                    <li class="bullet-item"><?php echo "Vrsta: ".$vrsta_karte; ?></li>
                    <li class="bullet-item"><?php echo "Vrijedi do: ".$vrijedi."&nbsp;&nbsp; 23:59"; ?></li>
                    <li class="bullet-item"><?php echo "Na ime: ".$korisnik->get_ime_prezime(); ?></li> 
                    <li class="cta-button">
                        <a class="button alert " href="<?php echo $odustani;?>" >Odustani</a>&nbsp;&nbsp;
                        <a class="button " href="<?php echo $potvrdi;?>" >Kupi kartu</a>
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

