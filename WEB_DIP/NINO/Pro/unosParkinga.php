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
    
    if(isset($_POST["parking"])){
        $parking=$_POST["parking"];
        $korisnik=$_POST["korisnik"];
        $brmjesta=$_POST["brmj"];
        $sat=$_POST["sat"];
        $dan=$_POST["dnevna"];
        $mjesec=$_POST["mjesecna"];
        $naplata=$_POST["naplata"];
        
        $upit="insert into parking values('default','$parking','$brmjesta','$sat','$dan','$mjesec','$naplata');";
        $baza->updateDB($upit);
        
        $imep=explode(" ",$korisnik);
        $upit="select idkorisnika from korisnik where ime='$imep[0]' and prezime='$imep[1]';";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $idkor=$red[0];
        
        $upit="UPDATE korisnik SET tip=2 WHERE idkorisnika ='$idkor';";
        $baza->updateDB($upit);
                
        $upit="select idparkinga from parking where naziv='$parking';";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $par=$red[0];
        
        $upit="select pomak from pomak;";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $vrijeme_servera = time();

        $vrijeme_sustava = $vrijeme_servera + ($red[0] * 60 * 60);
        $datum=date('Y-m-d', $vrijeme_sustava);
                  
        $upit="insert into pripada VALUES('$par','$idkor','$datum');";
        $baza->updateDB($upit);
        
        header("Location: evidencija_par.php");
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
        <section id="sadrzaj">
            <form class="forma2" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"  >
                    <fieldset>
                        <legend class="naslov" >Unos Parkinga</legend>

                        <div class="row">
                          <div class="large-6 columns">
                              <label for="korisnik">Zaposlenik</label>
                              <input type="text" name="korisnik" id="korisnik" required="" placeholder="Ime Prezime"/>
                          </div>
                          <div class="large-6 columns">
                              <label for="parking">Naziv parkinga</label>
                              <input type="text" name="parking" id="parking" required="" placeholder="Naziv"/>
                          </div> 
                        </div>
                        
                        <div class="row">
                            <div class="large-5 columns">
                                <label for="brmj">Broj mjesta </label>
                                <input type="text" name="brmj" id="brmj" required="" />                     
                            </div>
                          <div class="large-4 columns">
                              <label for="naplata">Vrijeme naplate</label>
                              <input type="text" name="naplata" id="naplata" required="" placeholder="OD-DO"/>
                          </div>
                            <div class="large-3 columns"></div>
                        </div>

                        <div class="row">
                            
                            <div class="large-4 columns">
                              <div class="row collapse">
                                <label>Jedan sat</label>
                                <div class="small-9 columns">
                                  <input  type="text" name="sat" id="sat" required="" />
                                </div>
                                <div class="small-3 columns">
                                  <span class="postfix">kn</span>
                                </div>
                              </div>
                            </div>
                            <div class="large-4 columns">
                              <div class="row collapse">
                                <label>Dnevna</label>
                                <div class="small-9 columns">
                                  <input  type="text" name="dnevna" id="dnevna" required="" />
                                </div>
                                <div class="small-3 columns">
                                  <span class="postfix">kn</span>
                                </div>
                              </div>
                            </div>
                            <div class="large-4 columns">
                              <div class="row collapse">
                                <label>Mjesecna</label>
                                <div class="small-9 columns">
                                  <input  type="text" name="mjesecna" id="mjesecna" required="" />
                                </div>
                                <div class="small-3 columns">
                                  <span class="postfix">kn</span>
                                </div>
                              </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="large-4 small-8 large-centered small-centered columns">
                                <input type="submit" value="Unesi parking" class="button expand tiny"/> 
                            </div>
                        </div>                    
                    </fieldset>  
                </form>
            </article>

        </section>
        <footer id="footer">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/></a><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 
        <script src="js/parking.js"></script>
    </body>
</html>
