<?php
    include_once './baza.class.php';
    $baza=new Baza();
    $id=$_REQUEST["korisnik"];
    $upit="UPDATE korisnik SET aktivan = '1' WHERE email ='$id';";
    if(!$baza->updateDB($upit)){
        header("Location: greske.php?greska=8");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Zadaća 4 - Aktivacija </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="css/nzvorc.css" />
    </head>
    <body>
    <hr class="tri"/>
    <hr class="dva"/>
    <hr class="jedan"/>
    <header>
        Zadaća 4 - PHP
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
        <p class="naslov">
            Vas racun je aktiviran
        </p>
    </section>
    <footer id="footer">
        <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_03/nzvorc/korisnici_jquery.html"><img src="img/html-5.png" height="100" alt="valid_html" /></a>
        <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_03/nzvorc/korisnici_jquery.html"><img src="img/css.png" height="100" alt="valid_css" /></a><br />
        Vrijeme potrebno za riješavanje <b>aktivnog dokumenta / zadaće: 3h / 10h</b>
       <br/>
    </footer>
    </body>
</html>

