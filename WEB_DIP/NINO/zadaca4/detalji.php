<?php
    include_once './baza.class.php';
    $baza=new Baza();
    $id=$_REQUEST["korisnik"];
    $upit="select * from korisnik where idkorisnika='$id';";
    $podaci=$baza->selectDB($upit);
    $red=$podaci->fetch_array();  
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Zadaća 4 - Detalji</title>
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

