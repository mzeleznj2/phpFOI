<?php

include_once ("baza.class.php");
include_once ("prijava_odjava.class.php");
include_once ("korisnik.php");
include_once ("CRUD.class.php");


$prijava=new PrijavaOdjava();

if(isset($_POST['korIme'])){
    
    $korIme = $_POST["korIme"];
    $lozinka = $_POST["lozinka"];
    
    $korisnik = $prijava->validacija($korIme, $lozinka);
    
    if ($korisnik->get_status() == 1) {
        $id=$korisnik->get_id(); 
        $mail=$korisnik->get_adresa(); 
        $kor_ime=$korisnik->get_kor_ime(); 
        $ime=$korisnik->get_ime(); 
        $prezime=$korisnik->get_prezime(); 
        $tip=$korisnik->get_vrsta(); 
        
        $prijava->kreiranjeSesije($id, $mail, $kor_ime, $ime, $prezime, $tip);
        header("Location: korisnici.php");
        exit();
    } else {
        header("Location: greske.php?greska=9");
        exit();
    }  
    
}

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Zadaća 5 - Prijava</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="css/nzvorc.css" />
    </head>
    <body>
    <hr class="tri"/>
    <hr class="dva"/>
    <hr class="jedan"/>
    <header>
        Zadaća 5 - PHP<br/>
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
                <a href="prijava.php">Prijava</a>
            </li>
            <li>
                <a href="registracija.php">Registracija</a>
            </li>
        </ul>
    </nav>
    
    <?php         
        $crud  = new CRUD($_SESSION['ID'],$_SESSION['tip']);
        echo $crud->kreirajOkomitiMeni(); 
    ?>

    
    <section id="sadrzaj">
        <article>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <p class="naslov">Prijava</p>
                <label for="korisnickoImee">Korisničko ime</label>
                <input name="korIme" class="input1" autofocus type="text" id="korisnickoImee" required="" /><br/>
                <label for="lozinkaa">Lozinka</label>
                <input name="lozinka" class="input1" type="password" id="lozinkaa" required="" /><br/>
                <label class="zapamti" for="zapamti">Zapampti moju prijavu</label>
                <input class="check" type="checkbox" id="zapamti">
                <input type="submit" value="Prijavi se" class="gumb"/><br/> 
                <p>Registriraj se <a href="registracija.html">ovdje</a></p>
            </form>
        </article>
    </section>
    <footer id="footer">
        <a href="http://validator.w3.org/check?uri=http://arka.foi.hr/WebDiP/2013/zadaca_03/nzvorc/prijava.html"><img src="img/html-5.png" height="100" alt="valid_html" /></a>
        <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://arka.foi.hr/WebDiP/2013/zadaca_03/nzvorc/prijava.html"><img src="img/css.png" height="100" alt="valid_css" /></a><br />
        Vrijeme potrebno za riješavanje <b>aktivnog dokumenta / zadaće: 1h / 10h</b>
       <br/>
    </footer>
    <script src="js/nzvorc.js"></script> 
    </body>
</html>

