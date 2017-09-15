<?php
include_once './baza.class.php';
$baza=new Baza();
$upit="select * from korisnik;";
$podaci=$baza->selectDB($upit);
$tablica="<table width=70% style='margin-left: 15%'><tr><th>Ime</th><th>Prezime</th><th>Slika</th><th>E-mail</th><th>Detalji</th></tr>";

while ($red=$podaci->fetch_array()){
    $tablica.="<tr><td>".$red[1]."</td><td>".$red[2]."</td>"
            . "<td><a href=\"detalji.php?korisnik={$red[0]}\"><img src=\"img/osoba.png\" /></a></td>"
            . "<td>".$red[7]."</td><td><a href=\"detalji.php?korisnik={$red[0]}\">Detalji</a></td></tr>";
}

$tablica.="</table>";

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Zadaća 4 - Korisnici </title>
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
        <article>
            <p class="naslov" >Korisnici</p>
            <br/>
            <?php
            echo "$tablica";
            ?>
            <button class="gumb4" id="prvi">Prvi</button>
            <button class="gumb3" id="predhodni">Predhodni</button>
            <button class="gumb3" id="sljedeci">Sljedeci</button>
            <button class="gumb3" id="osljednji">Posljednji</button>
        </article>
    </section>
    <footer id="footer">
        <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_03/nzvorc/korisnici_jquery.html"><img src="img/html-5.png" height="100" alt="valid_html" /></a>
        <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_03/nzvorc/korisnici_jquery.html"><img src="img/css.png" height="100" alt="valid_css" /></a><br />
        Vrijeme potrebno za riješavanje <b>aktivnog dokumenta / zadaće: 3h / 10h</b>
       <br/>
    </footer>
    </body>
</html>

