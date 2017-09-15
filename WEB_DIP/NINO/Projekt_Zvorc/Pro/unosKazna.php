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
    
    if ($tip>2) {
        header("Location: zabranjeno.php?e=2");
        exit();
    }
    
    $forma1="";
    $forma2="display: none;";
    
   if(isset($_POST["idvozil"])){
        $cijena=$_POST["cijena"];
        $vrijeme=date('Y-m-d H:i:s');
        $napomena=$_POST["napomen"];
        $idvoz=$_POST["idvozil"];
        $idpar=$_POST["idparking"];
        $izdao=$korisnik->get_id();
        
        $upit="insert into kazna values('default','$cijena','$vrijeme','$idvoz','$idpar','$izdao','$napomena','null');"; 
        $baza->updateDB($upit);
        
        $upit="select pomak from pomak;";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $vrijeme_servera = time();

        $vrijeme_sustava = $vrijeme_servera + ($red[0] * 60 * 60); 
        $vrijeme=date('Y-m-d H:i:s', $vrijeme_sustava);
        $upit="insert into prijava VALUES('default','$izdao','4','$vrijeme');";
        $baza->updateDB($upit);
        header("Location: uspjesno.php?e=4");
   }
    
    if(isset($_POST["reg"])){
        
        $id_parkinga=$_POST["parking"];
        $reg=$_POST["reg"];
        $napomena=$_POST["napomena"];
                
        $forma2="";
        $forma1="display: none;";
        
        $upit="select v.idvozila, k.idkorisnika, k.ime, k.prezime from vozilo v, korisnik k where v.vlasnik=k.idkorisnika and v.registracija='$reg';";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $idvozila=$red[0];
        $idkorisnika=$red[1];
        $ime=$red[2];
        $prezime=$red[3];
        
        $upit="select naziv, sat, naplata from parking where idparkinga='$id_parkinga';";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $parking=$red[0];
        
        $sat=$red[1];
        $naplata=explode("-",$red[2]);
        
        $upit="select pomak from pomak;";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $vrijeme_servera = time();

        $vrijeme_sustava = $vrijeme_servera + ($red[0] * 60 * 60); 
        $vrijeme=date('H', $vrijeme_sustava);
        
        $koef=$naplata[1]-$vrijeme;
        
        if($naplata[0]>$vrijeme || $naplata[1]<$vrijeme){
             header("Location: zabranjeno.php?e=3");
        }
        
        echo $naplata[0]." ".$naplata[1];
        $cijena=$sat*$koef;      
       
    }

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Parkeralište - Unos Kazne</title>
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
            <article style="<?php echo $forma1; ?>">
                <form class="forma2" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"  >
                    <fieldset>
                        <legend class="naslov" >Unos Kazne</legend>

                        <div class="row">
                          <div class="large-6 columns">
                              <label for="reg">Registracija</label>
                              <input type="text" name="reg" id="reg" required="" />
                          </div>
                          <div class="large-6 columns">
                              <label for="parking">Parking: </label>
                              <select id="parking" name="parking">
                                  <option value="-1" selected="selected">Odaberi parking</option>
                                  <option value="1" >Čakovec</option>
                                  <option value="2" >Varaždin</option>
                                  <option value="3" >Zagreb Sjever</option>
                                  <option value="4" >Zagreb Središte</option>
                                  <option value="5" >Zagreb Jug</option>
                              </select>
                          </div> 
                        </div>

                        <div class="row">
                            <div class="large-8 columns">
                                <label for="napomena">Napomena</label>
                                <textarea  id="napomena" name="napomena"  rows="1" cols="40" ></textarea>                        
                            </div>
                            <div class="large-4 columns">
                            </div>
                        </div>

                        <div class="row">
                            <div class="large-4 small-8 large-centered small-centered columns">
                                <input type="submit" value="Izdaj kaznu" class="button expand tiny"/> 
                            </div>
                        </div>                    
                    </fieldset>  
                </form>
            </article>
            <article style="<?php echo $forma2; ?>">
                <form class="forma2" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"  >
                    <fieldset>
                        <legend class="naslov" >Potvrda kazne</legend>

                        <div class="row">
                          <div class="large-5 columns">
                              <label for="ime">Ime</label>
                              <input type="text" name="ime" id="ime" value="<?php echo $ime; ?>" disabled="" />
                          </div>
                          <div class="large-7 columns">
                              <label for="prezime">Prezime</label>
                              <input type="text" name="prezime" id="prezime" value="<?php echo $prezime; ?>" disabled="" />
                          </div>            
                        </div>

                        <div class="row">
                          <div class="large-5 columns">
                              <label for="regi">Registracija</label>
                              <input type="text" name="regi" id="regi" value="<?php echo $reg; ?>" disabled=""/>
                          </div>
                          <div class="large-5 columns">
                              <label for="parking">Za parking</label>
                              <input type="text" name="parking" id="parking" value="<?php echo $parking; ?>"  disabled=""/>
                          </div>
                          <div class="large-2 columns"></div>              
                        </div>
                        
                        <div class="row">
                            <div class="large-9 columns">
                                <label for="napomen">Napomena</label>
                                <textarea  id="napomen" name="napomen" rows="1" cols="40" ><?php echo $napomena; ?></textarea>                        
                            </div>
                            <div class="large-4 columns">
                            </div>
                        </div>

                        <div class="row">
                            <div class="large-4 large-offset-2 columns">
                                <input type="submit" value="Potvrdi kaznu" class="button expand tiny"/> 
                            </div>
                            <div class="large-4 columns">
                                <a class="button expand  alert tiny " href="odustani.php?karta=-1" >Odustani</a> 
                            </div>
                            <div class="large-2  columns"></div>
                        </div> 
                        <div class="row" style="visibility: hidden;">
                            <div class="large-1 columns">
                                <input type="text" name="cijena" id="cijena" value="<?php echo $cijena; ?>" />
                            </div>
                            <div class="large-1 columns">
                                <input type="text" name="idvozil" id="idvozil" value="<?php echo $idvozila; ?>" />
                            </div> 
                            <div class="large-1 columns">
                                <input type="text" name="idparking" id="idparking" value="<?php echo $id_parkinga; ?>" />
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
        <script src="js/karta_kazna.js"></script>
    </body>
</html>
