<?php
    
    include_once ("../okviri/baza.class.php");
    $baza=new Baza();
     
    $id=$_REQUEST["korisnik"];
    $upit="select * from korisnik k, vozilo v, marka m where k.idkorisnika='$id' and k.idkorisnika=v.vlasnik and m.idmarke=v.marka;";
    $podaci=$baza->selectDB($upit);
    $red=$podaci->fetch_array(); 
    
    $por="visibility: hidden;";
    if($red[9]==3){
        $por="visibility: visible;";
    }
    
    if(isset($_POST["idd"])){
        $id=$_POST["idd"];
        $datum=date('Y-m-d');
        $parking=$_POST['parking'];
        
        $upit="insert into pripada VALUES('$parking','$id','$datum');";
        $baza->updateDB($upit);
                
        $upit="UPDATE korisnik SET tip=2 WHERE idkorisnika ='$id';";
        $baza->updateDB($upit);
        header("Location: index.php");
    }
    
    
    
    
?>

<html>
    <head>
        <title>Parkeralište - Registracija</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="../css/foundation.css" />
        <link rel="stylesheet" href="../css/css_nzvorc.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <script src="../js/vendor/modernizr.js"></script>
    </head>
    <body>

        <header>
            arkeralište -  eParking
        </header>

        <hr class="jedan"/>
        <hr class="dva"/>
        <hr class="tri"/>

        <section style="width: 80%; margin-left: 10%">

            <form name="registracija" class="forma"  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
                <fieldset>
                    <legend class="naslov" >Detalji o korisniku</legend>

                    <div class="row">
                      <div class="large-4 columns">
                          <label id="imeg" for="ime">Ime</label>
                          <input name="ime" type="text" id="ime" disabled="" value="<?php echo $red[1]; ?>"/>
                      </div>
                      <div class="large-6 columns">
                          <label id="prezimeg"for="prezime">Prezime</label>
                          <input name="prezime" type="text" id="prezime" disabled="" value="<?php echo $red[2]; ?>"/>
                      </div>
                      <div class="large-2 columns"></div>
                    </div>

                    <div class="row">
                      <div class="large-5 columns">
                          <label for="adresa">Adresa</label>
                          <input name="adresa" type="text" id="adresa" disabled="" value="<?php echo $red[5]; ?>"/>
                      </div>
                      <div class="large-4 columns">
                          <label for="grad">Grad</label>
                          <input name="grad" type="text" id="grad" disabled="" value="<?php echo $red[6]; ?>"/>
                      </div>
                        <div class="large-3 columns">
                          <label for="telefon">Telefon</label>
                          <input name="telefon" type="tel" id="telefon" disabled="" value="<?php echo $red[8]; ?>" />
                        </div> 
                    </div>

                    <div class="row">
                        <div class="large-4 columns">
                          <label for="korisnickoIme" id='greske' >Korisničko ime</label>
                          <input name="korisnicko" type="text" id="korisnickoIme" disabled="" value="<?php echo $red[3]; ?>" />
                        </div>
                        <div class="large-4 columns">
                          <label for="email" id='greske1'>E-mail</label>
                          <input name="email" type="email" id="email" disabled="" value="<?php echo $red[7]; ?>" />
                        </div>
                        <div class="large-4 columns">
                           <label for="lozinka" id="lozinkag" >Lozinka</label>
                           <input name="lozinka" type="text" id="lozinka" disabled="" value="<?php echo $red[4]; ?>"/>
                        </div>
                    </div>

                    <div class="row">
                          <div class="large-3 columns">
                              <label for="marka">Marka automobila</label>
                              <input name="marka" type="text" id="marka" required="" disabled="" value="<?php echo $red[18]; ?>"/>
                          </div>
                          <div class="large-4 columns">
                              <label for="registracija">Registracija</label>
                              <input name="registracija" type="text" id="registracija" disabled="" value="<?php echo $red[14]; ?>"/>
                          </div>
                          <div class="large-4 columns" style="<?php echo $por; ?>">
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
                         <div class="large-1 columns"></div>
                    </div>
                    <div class="row">      
                        <div class="large-2 columns" style="visibility: hidden;">
                            <input name="idd" type="text" id="idd"  value="<?php echo $id; ?>"/>
                        </div>
                        <div class="large-3 columns">
                            <a href="index.php" class="button expand tiny">Povratak</a>
                        </div>
                        <div class="large-3 columns" style="<?php echo $por; ?>">
                            <input type="submit" value="Zaposli korisnika" class="button expand tiny"/>
                        </div>
                        <div class="large-3 columns"></div>
                     </div></div>

                </fieldset>  
            </form>
        </section>
        
   
        <footer id="footer">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/></a><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
    </body>
</html>