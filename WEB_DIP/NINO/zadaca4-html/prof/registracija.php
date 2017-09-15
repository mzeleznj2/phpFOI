<?PHP
include_once './baza.class.php';
$baza=new Baza();
$greske = "";
if (isset($_POST['registracija'])) {
    $kor_email = $_POST['korisnici_email'];
    $kor_naziv = $_POST['korisnici_naziv'];
    $kor_lozinka = $_POST['korisnici_lozinka'];
    $kor_prezime = $_POST['korisnici_prezime'];
    $kor_adresa = $_POST['korisnici_adresa'];
    $kor_grad = $_POST['korisnici_grad'];

    $upit = "SELECT * FROM korisnici where korisnici_email='$kor_email'";
    $rezultat = $baza->selectDB($upit);
    if ($rezultat->num_rows != 0) {
        $greske.="Zauzeta email adresa!<br/>";
    }

    #VALIDACIJA FORMULARA SA SERVERSKE STRANE
    #EMAIL, PHP >= 5.2
    if(!filter_var($kor_email, FILTER_VALIDATE_EMAIL)){ 
        $greske .= "NetoÄŤno strukturirana email adresa.<br />";
    }     
    
    #LOZINKA PUTEM REGEXP
    if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $kor_lozinka)){
        $greske .= "Krivo strukturirana lozinka. <br />";
    }   
    
    #LOZINKE JEDNAKE
    #TODO
	
    #IME PREZIME TODO
    
    if (empty($greske)) {
        $upit = "insert into korisnici(tipkorisnika_id,korisnici_email,korisnici_lozinka,"
                . "korisnici_naziv,korisnici_prezime,korisnici_adresa,korisnici_grad,"
                . "korisnici_datumPristupanja,korisnici_status) VALUES('1','$kor_email',"
                . "'$kor_lozinka','$kor_naziv','$kor_prezime','$kor_adresa','$kor_grad',"
                . "now(),'0');";
        if ($baza->updateDB($upit)) {
            $primatelj = $kor_email;
            $naslov = "Aktivacija korisničkog računa";
            $poruka = "Poštovani <br><br> Molimo vas da aktivirte svoj korisnički "
                    . "račun klikom na "
                    . "<a href=\"http://arka.foi.hr/WebDiP/2013/materijali/mnovak2/grupa_2/zadaca_04/aktivacija.php?kod=$kor_email\">"
                    . "ovaj link</a>";
            mail($primatelj, $naslov, $poruka);
            header("Location: korisnici.php");
        } else {
            $greske.="Greška pri radu baze podatka.<br/>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Zadaća 1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="mnovak2.css" />

    </head>
    <body>
        <header style="background: red; color: white;">
            Zadaća 1 - HTML/CSS <br/>
            <img src="foi_logo_white.png" width="300" height="80" alt="foi logo" usemap="#mapa1"/>
            <map name="mapa1">
                <area href="#footer" alt="pravokutnik" shape="rect" coords="20,0,40,80" />
                <area href="#sadrzaj_predavanja" alt="krug" shape="circle" coords="53,49,13"/>
            </map>
        </header>
        <nav id="meni">
            <ul>
                <li>
                    <a href="index.html"><i>Početna stranica</i></a>  
                </li>
                <li>
                    <a href="prijava.html">Prijava</a>  
                </li>
                <li>
                    <a href="registracija.html">Registracija</a>  
                </li>
                <li>
                    <a href="korisnici.html">Korisnici</a>  
                </li>
                <li>
                    <a href="osobna.html" target="new">O meni</a>  
                </li>
            </ul>
        </nav>
        <section id="sadrzaj">
            <article id='greske'>
<?PHP echo $greske; ?>
            </article>  
            <article id="formular">
                <form name="registracija" id="registracija" 
                      action="<?PHP echo $_SERVER['PHP_SELF'] ?>" 
                      method="POST">
                    <label for="korisnici_email">E-mail (korisničko ime!):</label>
                    <input type="text" name="korisnici_email" size="50" ><br>
                    <label for="korisnici_lozinka">Lozinka:</label>
                    <input type="password" name="korisnici_lozinka" size="50" maxlength="20"  ><br>
                    <label for="korisnici_lozinka2">Lozinka2:</label>
                    <input type="password" name="korisnici_lozinka2" size="50" maxlength="20"  ><br>
                    <label for="korisnici_naziv">Ime:</label>
                    <input type="text" name="korisnici_naziv" size="50" maxlength="100"  ><br>
                    <label for="korisnici_prezime">Prezime:</label>
                    <input type="text" name="korisnici_prezime" size="50" maxlength="100"  ><br>
                    <label for="korisnici_adresa">Adresa:</label>
                    <input type="text" name="korisnici_adresa" size="50" maxlength="45"  ><br>
                    <label for="korisnici_grad">Grad:</label>
                    <input type="text" name="korisnici_grad" size="50" maxlength="45"  >
                    <br>        
                    <input type="submit" name="registracija" class="gumb" value="Salji">
                    <input type="reset" name="resetiraj" class="gumb" value="Brisi">
                </form>
            </article>
        </section>
        <footer id="footer">
            <address>
                Kontaktirajte nas:<br/>
                <a href="mailto:matnovak@foi.hr">Matija Novak</a><br/>
                <a href="mailto:jseva@foi.hr">Jurica Ševa</a><br/>
            </address>
            <p>
                <small>Sva prava pridržana, Web dizajn i programiranje, 2014.</small>

            </p>
        </footer>
        <script src="js/matnovak.js"></script>
    </body>
</html>








