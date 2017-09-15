<?php

    include_once ("okviri/korisnik.class.php");
    include_once ("okviri/baza.class.php");
    include_once ("okviri/meni.php");
    include_once ("okviri/postavi_vrijeme.php");
    $baza=new Baza();  
        
    $korisnik=new Korisnik();
    session_start();
    if (isset($_SESSION["prijava"])) {
        $korisnik=$_SESSION["prijava"];
        $tipp=$korisnik->get_tip();
        $imeprezime=$korisnik->get_ime_prezime();
        if($korisnik->get_tip()>1){            
            header("Location: zabranjeno.php?e=1");
            exit();
        }
    } 
    
    if(isset($_POST["email"])){
        $ime=$_POST["ime"];
        $prezime=$_POST["prezime"];
        $korisnicko=$_POST["korisnicko"];
        $lozinka=$_POST["lozinka"];
        $plozinka=$_POST["plozinka"];
        $adresa=$_POST["adresa"];
        $grad=$_POST["grad"];
        $email=$_POST["email"];
        $telefon=$_POST["telefon"];
        $marka=$_POST["marka"];
        $registracija=$_POST["registracijaa"];
        
        $greska=0;

        $upit = "select * from korisnik where email='$email';";
        $rezultat = $baza->selectDB($upit);
        if ($rezultat->num_rows != 0) {
            $greska=1;
        }

        $upit = "select * from korisnik where korisnicko='$korisnicko';";
        $rezultat = $baza->selectDB($upit);
        if ($rezultat->num_rows != 0) {
            $greska=2;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            $greska=3;
        }

        if(strlen($korisnicko)<6){
            $greska=4;
        }

        if(strlen($lozinka)<6){
            $greska=5;
        }  

        if($lozinka!==$plozinka){
            $greska=6;
        }

        if($greska==0){
            $kod=rand()+1;
            
            $upit="select pomak from pomak;";
            $podaci=$baza->selectDB($upit);
            $red=$podaci->fetch_array();
            $vrijeme_servera = time();

            
            $vrijeme_sustava=date('Y-m-d H:i:s',strtotime('+1 day'))+ $vrijeme_servera + ($red[0] * 60 * 60);
            $vrijedi=date('Y-m-d H:i:s', $vrijeme_sustava);
            $upit="insert into korisnik  VALUES('default','$ime','$prezime','$korisnicko',"
                    . "'$lozinka','$adresa','$grad','$email','$telefon','3','0','$kod','$vrijedi');";
            if($baza->updateDB($upit)){
                $primatelj=$email;
                $naslov="Aktivacija korisnickog racuna";
                $sadrzaj="Aktivirajte svoj racun klikom na "
                        . "<a href=\"http://arka.foi.hr/WebDiP/2013_projekti/WebDiP2013_096/aktivacija.php?kod=$kod\">"
                        . "ovaj link.</a>"; 
                mail($primatelj, $naslov, $sadrzaj); 
                $upit="select idkorisnika from korisnik WHERE kod ='$kod';";
                $podaci=$baza->selectDB($upit);
                $red=$podaci->fetch_array();
                $id_vlasnika=$red[0];
                $upit="select idmarke from marka WHERE naziv ='$marka';";
                $podaci=$baza->selectDB($upit);
                $red=$podaci->fetch_array();
                $id_marke=$red[0];
                $upit="insert into vozilo VALUES('default','$registracija','$id_vlasnika','$id_marke');";
                if($baza->updateDB($upit)){
                    header("Location: prijava.php");                
                }
                else{
                    echo "greska";
                }                                 
            }
            else{
                    echo "greska2";
            }
        }
        else{
            echo "$greska";
        }
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Parkeralište - Registracija</title>
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
                    echo kreiranjeIzbornika($tipp, $imeprezime);
                ?>
            </ul>
        </nav>
        <section id="sadrzaj">

            <form name="registracija" class="forma" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <fieldset>
                    <legend class="naslov" >Registracija novog korisnika</legend>

                    <div class="row">
                      <div class="large-4 columns">
                          <label id="imeg" for="ime">Ime</label>
                          <input name="ime" type="text" id="ime" required="" placeholder="Ime"/>
                      </div>
                      <div class="large-6 columns">
                          <label id="prezimeg"for="prezime">Prezime</label>
                          <input name="prezime" type="text" id="prezime" required="" placeholder="Prezime"/>
                      </div>
                      <div class="large-2 columns"></div>
                    </div>

                    <div class="row">
                      <div class="large-5 columns">
                          <label for="adresa">Adresa</label>
                          <input name="adresa" type="text" id="adresa" required="" placeholder="Adresa"/>
                      </div>
                      <div class="large-4 columns">
                          <label for="grad">Grad</label>
                          <input name="grad" type="text" id="grad" required="" placeholder="Grad"/>
                      </div>
                      <div class="large-3 columns">
                          <label for="spol">Spol: </label>
                          <select name="spol" id="spol">
                              <option value="-1" selected="selected">Odaberi spol</option>
                              <option value="1" >Muški</option>
                              <option value="2" >Ženski</option>
                          </select>
                      </div> 
                    </div>

                    <div class="row">
                      <div class="large-4 columns">
                          <label for="telefon">Telefon</label>
                          <input name="telefon" type="tel" id="telefon" placeholder="+385-xx-xxx-xxxx" />
                      </div>
                      <div class="large-4 columns">
                          <label for="email" id='greske1'>E-mail</label>
                          <input name="email" type="email" id="email" placeholder="korisnicko@foi.hr" required="" />
                      </div>
                      <div class="large-4 columns">
                          <label for="korisnickoIme" id='greske' >Korisničko ime</label>
                          <input name="korisnicko" type="text" id="korisnickoIme" required=""  placeholder="Korisničko ime" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="large-5 columns">
                           <label for="lozinka" id="lozinkag" >Lozinka</label>
                           <input name="lozinka" type="password" id="lozinka" required="" />
                      </div>
                      <div class="large-5 columns">
                          <label for="plozinka" id="plozinkag">Ponovi lozinku </label>
                          <input name="plozinka" type="password" id="plozinka" required="" />
                      </div>
                        <div class="large-2 columns"></div>
                    </div>

                    <div class="row">
                      <div class="large-6 columns">
                          <label for="marka">Marka automobila</label>
                          <input name="marka" type="text" id="marka" required="" placeholder="Marka"/>
                      </div>
                      <div class="large-6 columns">
                          <label for="registracija">Vaša registracija</label>
                          <input name="registracijaa" type="text" id="registracija" required="" />
                      </div>
                    </div>

                    <div class="row">
                        <div class="large-6 columns">
                            <input id="checkbox" type="checkbox" required >
                            <label for="checkbox">Potvrđujem i prihvaćam 
                                <a href="#" data-reveal-id="uvjeti">uvjete upotrebe aplikacije</a> 
                            </label>
                        </div>
                        <div class="large-3 columns">
                            <input type="submit" value="Registriraj se" class="button expand tiny"/> 
                        </div>
                        <div class="large-3 columns">
                            <input type="reset" value="Obriši" class="button expand tiny"/>
                        </div>
                     </div>
                </fieldset>  
            </form>
        </section>
        
        <div id="uvjeti" class="reveal-modal" data-reveal> 
            <h2>Uvjeti korištenja aplikacije</h2> 
            <p class="lead" style="text-align: center;">Članak 1.</p> 
            <p>(1) Parkiranjem vozila na javnom parkiralištu s naplatom, vozač vozila je dužan u roku od 15 minuta od zaustavljanja, unaprijed platiti planirano vrijeme parkiranja, a najmanje jedan sat, prema cjenik u koji je sastavni dio ovog Pravilnika </p>
            <p>(2) Ako se vozač zatekne na parkiralištu s naplatom u vremenu dužem od 15 minuta bez plaćenog vremena parkiranja ili je prekoračio vrijeme parkiranja dužan je platiti cijenu zbroja pojedinačnih cijena obračunske
                    jedinice u određenom vremenu parkiranja za to parkirno mjesto tog dana.</p>
            <p>(3)Iz stavka 2. Ovog članka izuzimaju se vozači, ako je u pitanju bila viša sila (kvar, bolest, elementarne nepogode i sl.)</p>
            
            <p class="lead" style="text-align: center;">Članak 2.</p>
            <p>(1)Naplata satne karte obavlja se ručno i automatski neposredno na parkiralištu, poluautomatski (zatvoreno parkiralište), mobilnim telefonom, preko ovlaštenih prodajnih mjesta ili na blagajni Organizatora parkiranja.</p>
            <p>(2)Ručna naplata satne karte podrazumijeva istodobnu kupnju i preuzimanje tiskane parkirališne karte neposredno na parkiralištu od osobe koju ovlasti Organizator parkiranja.</p>
            <p>(3)Automatska naplata satne karte podrazumijeva istodobnu kupnju i preuzimanje tiskane parkirališne karte neposredno na parkiralištu putem parkirališnog automata.</p>
            <p>(4)Poluautomatska naplata satne karte podrazumijeva preuzimanje ulaznog listića na ulasku u parkiralište i plaćanje naknade u trenutku izlaza iz parkirališta. </p>
            <p>(5)Naplata satne karte mobilnim telefonom podrazumijeva kupnju parkirališne karte elektroničkim putem. Za plaćeno parkiranje koje je prihvaćeno i evidentirano u informacijskom sustavu Organizatora parkiranja ne izdaje se tiskana parkirališna karta već korisnik zaprima SMS potvrdu o plaćenoj parkirališnoj karti.</p>
            <p>(6)Naplata satne karte preko ovlaštenih prodajnih mjesta i na blagajni Organizatora parkiranja podrazumijeva istodobnu kupnju i preuzimanje tiskane parkirališne karte na ovlaštenom prodajnom mjestu ili na blagajni Organizatora parkiranja.</p>
            
            <p class="lead" style="text-align: center;">Članak 3.</p> 
           <p>(1)Organizator parkiranja je obvezan organizirati učinkovito čuvanje vozila od oštećivanja, krađa i provala u vozila. </p>
           <p>(2)Organizator parkiranja je obvezan sklopiti policu osiguranja za vozila za vrijeme za koje je plaćeno parkiranje, te nadoknaditi sve štete koje su nastale na vozili za vrijeme plaćenog vremena parkiranja. Visina štete određuje se dogovorno ili u slučaju nemogućnosti dogovaranja ovlaštena osoba osiguravajuće kuće kod koje je sklopljena polica za to parkirno mjesto. </p>
          
           <p class="lead" style="text-align: center;">Članak 4.</p>
           <p>(1)Cjenik parkiranja određuje Grad Karlovac sukladno Statutu.</p>
           <p>(2)Cjenik je sastavni do ovog Pravilnika</p>
           
        <a class="close-reveal-modal">&#215;</a> 
        </div>

        <script src="js/foundation/foundation.js"></script>
        <script src="js/foundation/foundation.reveal.js"></script>
        
        <script>
            $(document).foundation();
        </script>
    
        <footer id="footer" style="position: relative;">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/></a><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
        <script src="js/registracija.js"></script>
    </body>
</html>

