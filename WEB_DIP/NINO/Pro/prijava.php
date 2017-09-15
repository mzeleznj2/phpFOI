<?php

    include_once ("okviri/korisnik.class.php");
    include_once ("okviri/baza.class.php");
    include_once ("okviri/meni.php");
    include_once ("okviri/postavi_vrijeme.php");
    $baza=new Baza();  
        
    session_start();
    if (isset($_SESSION["prijava"])) {
        header("Location: zabranjeno.php?e=1");
        exit();
    }
    
    $greska="";
    
    if(isset($_POST["korisnicko"])){
        $korisnicko=$_POST["korisnicko"];
        $lozinka=$_POST["lozinka"];
        
        $upit="select idkorisnika, ime, prezime, korisnicko, lozinka, tip, aktivan, kod from korisnik where '$korisnicko'=korisnicko;";
        $podaci=$baza->selectDB($upit);
        if($red=$podaci->fetch_array()){
            $id=$red[0];
            $ime=$red[1];
            $prezime=$red[2];
            $loz=$red[4];
            $tip=$red[5];
            $aktivan=$red[6];
            $kod=$red[7];
            
            $upit="select pomak from pomak;";
            $podaci=$baza->selectDB($upit);
            $red=$podaci->fetch_array();
            $vrijeme_servera = time();

            $vrijeme_sustava = $vrijeme_servera + ($red[0] * 60 * 60); 
            $vrijeme=date('Y-m-d H:i:s', $vrijeme_sustava);
            
            if($loz!=$lozinka){
                $greska="Unesena lozinka nije ispravna!";
                $upit="insert into prijava VALUES('default','$id','2','$vrijeme');";
                $baza->updateDB($upit);
                
                $kod++;
                $upit="UPDATE korisnik SET kod = '$kod' WHERE '$id'=idkorisnika;";
                $baza->updateDB($upit);
                if($kod==3){
                     $upit="UPDATE korisnik SET aktivan = 0, kod = 0 WHERE '$id'=idkorisnika;";
                     $baza->updateDB($upit);
                     header("Location: zabranjeno.php?e=4");
                }
 
      
            }
            elseif($aktivan!=1){
                $greska="Vaš račun je neaktiviran! Aktivirajte ga mailom.";
                $upit="insert into prijava VALUES('default','$id','2','$vrijeme');";
                $baza->updateDB($upit);
            }
            else{
                $korisnik = new Korisnik();
                $korisnik->postavi($id, $korisnicko, $ime, $prezime, $lozinka, $tip);
                session_start();
                $_SESSION["prijava"] = $korisnik;
                $upit="insert into prijava VALUES('default','$id','1','$vrijeme');";
                $baza->updateDB($upit);
                header("Location: index.php");
                exit();
            }
        }
        else $greska="Nepostojeće korisničko ime!";
        
    }

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Parkeralište - Prijava</title>
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
                    echo kreiranjeIzbornika(0,0);
                ?>
            </ul>
        </nav>
        <section id="sadrzaj">
            <article>
                <p class="naslov">Prijava</p>
                <form name="prijavaa" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"  >

                    <div class="row">
                      <div class="large-12 columns">
                          <label>Korisničko ime
                              <input type="text" required="" name="korisnicko" autofocus="" />
                          </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="large-12 columns">
                          <label>Lozinka
                              <input type="password" required="" name="lozinka"/>
                          </label>
                      </div>
                    </div>

                    <div class="row">
                        <div class="large-12 columns">
                            <input id="checkbox" type="checkbox" ><label for="checkbox">Zapamti moju prijavu</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="large-5 large-offset-1 columns">
                          <input type="submit" value="Prijavi se" class="button expand tiny"/>
                        </div> 
                        <div class="large-5 end columns">
                            <a href="registracija.html" class="button secondary expand tiny ">Registriraj se</a>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="large-11 large-offset-1 columns" style="color: #ff2121; font-size: 14px;">
                          <?php echo $greska; ?>
                        </div> 
                    </div>

                </form>
            </article>
        </section>

        <footer id="footer">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/></a><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
    </body>
</html>