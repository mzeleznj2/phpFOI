<?php
include_once './baza.class.php';
$baza=new Baza();
$greska=0;
if(isset($_POST["registracija"])){
    $ime=$_POST["ime"];
    $prezime=$_POST["prezime"];
    $korisnicko=$_POST["korisnicko"];
    $lozinka=$_POST["lozinka"];
    $plozinka=$_POST["plozinka"];
    $adresa=$_POST["adresa"];
    $grad=$_POST["grad"];
    $email=$_POST["email"];
    $telefon=$_POST["telefon"];
    
    $upit = "select * from korisnik where email='$email';";
    $rezultat = $baza->selectDB($upit);
    if ($rezultat->num_rows != 0) {
        $greska=1;
    }
    
    if(!preg_match("/[A-Z]/", $ime[0])){
        $greska=2;
    }
    
    if(!preg_match("/[A-Z]/", $prezime[0])){
        $greska=3;
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
        $greska=4;
    }
    
    if(strlen($korisnicko)<6){
        $greska=5;
    }
    
    if(strlen($lozinka)<6){
        $greska=6;
    }  
    
    if($lozinka!==$plozinka){
        $greska=7;
    }
    
    if($greska==0){
        $upit="insert into korisnik  VALUES('default','$ime','$prezime','$korisnicko',"
                . "'$lozinka','$adresa','$grad','$email','$telefon','3','0');";
        if($baza->updateDB($upit)){
            $primatelj=$email;
            $naslov="Aktivacija korisnickog racuna";
            $sadrzaj="Aktivirajte svoj racun klikom na "
                    . "<a href=\"http://arka.foi.hr/WebDiP/2013/zadaca_04/nzvorc/aktivacija.php?korisnik=$email\">"
                    . "ovaj link.</a>"; 
            mail($primatelj, $naslov, $sadrzaj);            
            header("Location: korisnici.php");                    
        }
        else{
            header("Location: greske.php?greska=8");
        }
    }
    else{
        header("Location: greske.php?greska=$greska");
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Zadaća 4 - Registracija</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="css/nzvorc.css" />
    </head>
    <body>
    <hr class="tri"/>
    <hr class="dva"/>
    <hr class="jedan"/>
    <header>
        Zadaća 4 - PHP<br/>
    </header>
    <hr class="jedan"/>
    <hr class="dva"/>
    <hr class="tri"/>
    <nav id="meni" style="margin-right: 5%;">
        <ul>  
            <li>
                <a href="index.php">Početna</a>
            </li>
            <li>
                <a href="korisnici.php">Korisnici</a>
            </li>
            <li>
                <a href="registracija.php">Registracija</a>
            </li>
        </ul>
    </nav>
    <section id="sadrzaj">
        <article>
            <form name="registracija" id="registracija" action="<?php echo $_SERVER['PHP_SELF'] ?>"  method="POST" >
                <p class="naslov" >Registracija novog korisnika</p>
                <label for="ime" >Ime</label>
                <input name="ime" class="input2" type="text" id="ime" required="" placeholder="Ime" /><br/>
                <label for="prezime" >Prezime</label>
                <input name="prezime" class="input1" type="text" id="prezime" required="" placeholder="Prezime" /><br/>
                <label for="slika" >Slika</label>
                <input type="file" id="slika" class="browse" /><br/>
                <label for="adresa">Adresa</label>
                <input name="adresa" class="input2" type="text" id="adresa" required="" placeholder="Adresa" /><br/>
                <label for="grad">Grad</label>
                <input name="grad" class="input3" type="text" id="grad" required="" placeholder="Grad" /><br/>
                <label for="e-mail">E-mail</label>
                <input name="email" class="input3" type="email" id="e-mail" placeholder="korisnicko@foi.hr" required="" /><br/>
                <label for="korisnickoIme">Korisničko ime</label>
                <input name="korisnicko" class="input2" type="text" id="korisnickoIme" required=""  title="Najmanje 6 znakova!" placeholder="Korisničko ime" /><br/>
                <label for="lozinka">Lozinka</label>
                <input name="lozinka" class="input2" type="password" id="lozinka" required=""  title="Najmanje 6 znakova!"  /><br/>
                <label for="plozinka">Ponovi lozinku </label>
                <input name="plozinka" class="input2" type="password" id="plozinka" required="" title="Najmanje 6 znakova!"  /><br/>
                <label for="telefon">Telefon</label>
                <input name="telefon" class="input3" type="tel" id="telefon" placeholder="+385-xx-xxx-xxxx"  /><br>
                <label for="zivotopis">Životopis</label>
                <textarea id="zivotopis" rows="5" cols="40"  placeholder="Kratak životopis"></textarea><br>
                <label for="spol">Spol: </label>
                <select id="spol">
                    <option value="-1" selected="selected">Odaberi spol</option>
                    <option value="1" >muški</option>
                    <option value="2" >ženski</option>
                </select>
                <br/>
                <br/>
                <?php
                    require_once('recaptcha/recaptchalib.php');
                    $publickey = "6Lc1IvMSAAAAAEPv-nsSj0gwC7igrh79EZc5yk8T"; 
                    echo recaptcha_get_html($publickey);
                ?>
                <br/>
                <input type="submit" name="registracija" value="Registriraj se" class="gumb2"/><br/>       
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


