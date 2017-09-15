<?php
/*
 * The MIT License
 *
 * Copyright 2014 Jurica Ševa <jurica.seva@foi.hr>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Klasa za generiranja tablica i formi sa CRUD kontrolama
 *
 * @author Jurica Seva <jurica.seva@foi.hr>
 */
include 'classes/Baza.class.php';

#objekti za bazu i forme
$baza = new baza();
$naziv = "Registriraj se!";
$poruka = "";

#obrada poslanih podataka iz formulara
if(isset($_POST['registracija'])){
    #registracija korisnika

    $korisnici_email = $_POST['korisnici_email'];
    $korisnici_lozinka = $_POST['korisnici_lozinka'];
    $korisnici_lozinka1 = $_POST['korisnici_lozinka1'];    
    $korisnici_naziv = $_POST['korisnici_naziv'];
    $korisnici_prezime = $_POST['korisnici_prezime'];
    $korisnici_adresa = $_POST['korisnici_adresa'];
    $korisnici_grad = $_POST['korisnici_grad'];    
    
    #provjera da li postoji registrirana email adresa
    $upitZauzeto = "select * from korisnici where korisnici_email = '$korisnici_email'";
    $rezultatZauzeto = $baza::selectDB($upitZauzeto);
    if ($rezultatZauzeto->num_rows != 0){
        $poruka .= "Zauzeta email adresa<br />";
    }    
    
    #VALIDACIJA FORMULARA SA SERVERSKE STRANE
    #EMAIL, PHP >= 5.2
    if(!filter_var($korisnici_email, FILTER_VALIDATE_EMAIL)){ 
        $poruka .= "Netočno strukturirana email adresa.<br />";
    }     
    
    #LOZINKA PUTEM REGEXP
    if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $korisnici_lozinka)){
        $poruka .= "Krivo strukturirana lozinka. <br />";
    }   
    
    #LOZINKE JEDNAKE
    if (strcmp($korisnici_lozinka,$korisnici_lozinka1) != 0){
        $poruka .= "Lozinke nisu jednake. <br />";
    }       
    
    
    #NEMA NETOČNO ISPUNJENIH POLJA
    if($poruka == ""){
        #EMAIL ADRESA SLOBODNA, REGISTRIRA SE KORISNIČKI RAČUN
            $upit = "insert into korisnici (tipkorisnika_id,korisnici_email,korisnici_lozinka,korisnici_naziv,korisnici_prezime,korisnici_adresa,korisnici_grad,korisnici_datumPristupanja,korisnici_status)"
                . "values ('1','{$korisnici_email}','$korisnici_lozinka','$korisnici_naziv','$korisnici_prezime','$korisnici_adresa','$korisnici_grad',now(),'0')";
            if($baza::updateDB($upit)){
                #uspješan upit -> generiranje aktivacijskog emaila i redirekcija na login skriptu
                $primatelj=$korisnici_email;
                $naslov="Aktivacija korisničkog računa";
                $poruka="Poštovani, <br/> <br/> Molimo vas da aktivirate svoj korisnički račun klikom na <a href='http://arka.foi.hr/WebDiP/2013/materijali/zadaca04/aktivacija.php?kljuc={$primatelj}'>LINK</a>";
                mail($primatelj,$naslov,$poruka);
                header("Location: prijava.php?aktivacija=1");
            } else {
                $poruka .= "Greška pri radu baze podataka.<br />";
            }
    }
}

?>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $naziv; ?></title>
        <link rel="stylesheet" type="text/css" media="screen and (min-width: 480px)" href="CSS/pozicioiniranje.css" />
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 480px)" href="CSS/pozicioiniranje_small.css" />
        <link href="CSS/global.css" rel="stylesheet" type="text/css" >
        <!-- <link rel="stylesheet" type="text/css" href="CSS/izbornikVodoravno.css"> -->
        <link rel="stylesheet" type="text/css" media="screen and (min-width: 730px)" href="CSS/izbronikOkomito.css" /> <!-- ako piše min-device-width onda to je baš device rezolucija-->
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 730px)" href="CSS/izbronikOkomito_small.css" />
    </head>
    <body>
    <header>
        STAVITI SLIKU
    </header>
    <nav id="meni">
        <ul>
                <li class="active"><a href="index.php">Početna stranica</a></li>
        </ul>
    </nav>    
    <section id='sadrzaj'>
        <article id='greske'>
            <?php echo $poruka; ?>
        </article>  
        <article id="formular">
            <form name="registracija" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <label forname="korisnici_email">E-mail (korisničko ime!):</label><input type="text" name="korisnici_email" size="50" <?php (isset($korisnici_email) ? "value='{$korisnici_email}'":""); ?> ><br>
                <label forname="korisnici_lozinka">Lozinka:</label><input type="password" name="korisnici_lozinka" size="50" maxlength="20" <?php (isset($korisnici_lozinka) ? "value='{$korisnici_lozinka}'":""); ?> ><br>       
                <label forname="korisnici_lozinka1">Lozinka:</label><input type="password" name="korisnici_lozinka1" size="50" maxlength="20" <?php (isset($korisnici_lozinka1) ? "value='{$korisnici_lozinka1}'":""); ?> ><br>                  
                <label forname="korisnici_naziv">Ime:</label><input type="text" name="korisnici_naziv" size="50" maxlength="100" <?php (isset($korisnici_naziv) ? "value='{$korisnici_naziv}'":""); ?> ><br>
                <label forname="korisnici_prezime">Prezime:</label><input type="text" name="korisnici_prezime" size="50" maxlength="100" <?php (isset($korisnici_prezime) ? "value='{$korisnici_prezime}'":""); ?> ><br>
                <label forname="korisnici_adresa">Adresa:</label><input type="text" name="korisnici_adresa" size="50" maxlength="45" <?php (isset($korisnici_adresa) ? "value='{$korisnici_adresa}'":""); ?> ><br>
                <label forname="korisnici_grad">Grad:</label><input type="text" name="korisnici_grad" size="50" maxlength="45" <?php (isset($korisnici_grad) ? "value='{$korisnici_grad}'":""); ?> ><br>        
                <input type="submit" name="registracija" class="gumb" value="Registiraj se "><input type="reset" name="resetiraj" class="gumb" value="Resetiraj">
            </form>
        </article>
    </section>
    <footer>
        <address>
                Kontaktirajte nas na:<br /> 
                <a href="mailto:jseva@foi.hr">Jurica Ševa</a><br />
                <a href="mailto:matija.novak@foi.hr">Matija Novak</a>            
        </address>
        <p><small>© Sva prava pridržana, Web dizajn i programiranje, 2014.</small></p>
    </footer>
    </body>
    </html>