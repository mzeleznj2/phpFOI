<?php
    include_once './baza.class.php';
    $baza=new Baza();
    $id=$_REQUEST["korisnik"];
    $upit="select * from korisnik where idkorisnika='$id';";
    $podaci=$baza->selectDB($upit);
    $red=$podaci->fetch_array();  
    
?>

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
            arkeralište -  eParking
        </header>

        <hr class="jedan"/>
        <hr class="dva"/>
        <hr class="tri"/>

        <nav id="meni">
            <ul>
                <li>
                    <a href="index.php"><img src="img/home.gif" alt="home" width="30" /> &nbsp;&nbsp;&nbsp;&nbsp;Početna</a>
                </li>
                <li>
                    <a href="prijava.php"><img src="img/login.gif" alt="login" width="30" /> &nbsp;&nbsp;&nbsp;&nbsp;Prijava</a>
                </li>
                <li>
                    <a href="registracija.php"><img src="img/sign.gif" alt="sign" width="30" /> &nbsp;&nbsp;&nbsp;&nbsp;Registracija</a>
                </li>
                <li>
                    <a href="korisnici.php"><img src="img/users.gif" alt="users" width="30"/> &nbsp;&nbsp;&nbsp;&nbsp;Korisnici</a>
                </li>
                <li>
                    <a href="dokumentacija.php"><img src="img/doc.gif" alt="doc" width="30" /> &nbsp;&nbsp;&nbsp;&nbsp;Dokumentacija</a>
                </li>
                <li>
                    <a href="oparkingu.php"><img src="img/about.gif" alt="about" width="30"/> &nbsp;&nbsp;&nbsp;&nbsp;O parkiralištu</a>
                </li>
                <li>
                    <a href="kupnja.php"><img src="img/ticket.gif" alt="ticket" width="30"/> &nbsp;&nbsp;&nbsp;&nbsp;Kupnja karte</a>
                </li>
                <li>
                    <a href="unosKazna.php"><img src="img/kazna.gif" alt="kazna" width="30"/> &nbsp;&nbsp;&nbsp;&nbsp;Unos kazne</a>
                </li>
                <li>
                    <a href="pregled.php"><img src="img/kazne.gif" alt="kazne" width="30"/> &nbsp;&nbsp;&nbsp;&nbsp;Pregled stanja</a>
                </li>
            </ul>
        </nav>
        <section id="sadrzaj">

            <form name="registracija" class="forma" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <fieldset>
                    <legend class="naslov" >Detalji o korisniku</legend>

                    <div class="row">
                      <div class="large-4 columns">
                          <label id="imeg" for="ime">Ime</label>
                          <input name="ime" type="text" id="ime" value="<?php echo $red[1]; ?>"/>
                      </div>
                      <div class="large-6 columns">
                          <label id="prezimeg"for="prezime">Prezime</label>
                          <input name="prezime" type="text" id="prezime" value="<?php echo $red[2]; ?>"/>
                      </div>
                      <div class="large-2 columns"></div>
                    </div>

                    <div class="row">
                      <div class="large-5 columns">
                          <label for="adresa">Adresa</label>
                          <input name="adresa" type="text" id="adresa" value="<?php echo $red[5]; ?>"/>
                      </div>
                      <div class="large-4 columns">
                          <label for="grad">Grad</label>
                          <input name="grad" type="text" id="grad" value="<?php echo $red[6]; ?>"/>
                      </div>
                      <div class="large-3 columns"></div> 
                    </div>

                    <div class="row">
                      <div class="large-4 columns">
                          <label for="telefon">Telefon</label>
                          <input name="telefon" type="tel" id="telefon" value="<?php echo $red[8]; ?>" />
                      </div>
                      <div class="large-4 columns">
                          <label for="email" id='greske1'>E-mail</label>
                          <input name="email" type="email" id="email" value="<?php echo $red[7]; ?>" />
                      </div>
                      <div class="large-4 columns">
                          <label for="korisnickoIme" id='greske' >Korisničko ime</label>
                          <input name="korisnicko" type="text" id="korisnickoIme" value="<?php echo $red[3]; ?>" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="large-5 columns">
                           <label for="lozinka" id="lozinkag" >Lozinka</label>
                           <input name="lozinka" type="text" id="lozinka" value="<?php echo $red[4]; ?>"/>
                      </div>
                      <div class="large-7 columns"></div>
                    </div>

                    <div class="row">
                      <div class="large-6 columns">
                          <label for="marka">Marka automobila</label>
                          <input name="marka" type="text" id="marka" required="" placeholder="Marka"/>
                      </div>
                      <div class="large-6 columns">
                          <label for="registracija">Vaša registracija</label>
                          <input name="registracija" type="text" id="registracija" required="" />
                      </div>
                    </div>

                </fieldset>  
            </form>
        </section>
        
        <div id="uvjeti" class="reveal-modal" data-reveal> 
            <h2>Uvjeti korištenja aplikacije</h2> 
            <p class="lead">Your couch. It is mine.</p> 
            <p>Im a cool paragraph that lives inside of an even cooler modal. Wins</p> 
            <a class="close-reveal-modal">&#215;</a> 
        </div>

        <script src="js/foundation/foundation.js"></script>
        <script src="js/foundation/foundation.reveal.js"></script>
        
        <script>
            $(document).foundation();
        </script>
    
        <footer id="footer">
            <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc/"><img src="img/html-5.png" alt="valid_html" /></a>
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_01/nzvorc"><img src="img/css.png" alt="valid_css" /></a>
            <br />

           <br/>
        </footer>
        <script src="js/nzvorc.js"></script>
    </body>
</html>


    <section id="sadrzaj">
        <article>
            <form name="registracija" id="registracija"  method="READ_ONLY" >
                <p class="naslov" >Korisnik</p>
                <label for="ime" >Ime</label>
                <input name="ime" class="input2" type="text" value="<?php echo $red[1]; ?>" /><br/>
                <label for="prezime" >Prezime</label>
                <input name="prezime" class="input1" type="text" value="<?php echo $red[2]; ?>" /><br/>
                <label for="adresa">Adresa</label>
                <input name="adresa" class="input2" type="text" value="<?php echo $red[5]; ?>" /><br/>
                <label for="grad">Grad</label>
                <input name="grad" class="input3" type="text" value="<?php echo $red[6]; ?>" /><br/>
                <label for="e-mail">E-mail</label>
                <input name="email" class="input3" type="email" value="<?php echo $red[7]; ?>" /><br/>
                <label for="korisnickoIme">Korisničko ime</label>
                <input name="korisnicko" class="input2" type="text" value="<?php  echo $red[3]; ?>" /><br/>
                <label for="lozinka">Lozinka</label>
                <input name="lozinka" class="input2" type="password" value="<?php echo $red[4]; ?>"  /><br/>
                <label for="telefon">Telefon</label>
                <input name="telefon" class="input3" type="tel" value="<?php echo $red[8]; ?>"  /><br>      
            </form>
        </article>
    </section>
    <footer id="footer">
        <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_03/nzvorc/registracija.html"><img src="img/html-5.png" height="100" alt="valid_html" /></a>
        <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_03/nzvorc/registracija.html"><img src="img/css.png" height="100" alt="valid_css" /></a><br />
        Vrijeme potrebno za riješavanje <b>aktivnog dokumenta / zadaće: 6h / 20h</b>
       <br/>
    </footer>
    </body>
</html>

