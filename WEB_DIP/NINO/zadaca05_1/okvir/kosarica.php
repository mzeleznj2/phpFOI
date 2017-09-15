<?php
include_once('aplikacijskiOkvir.php');

$korisnik = provjeraKorisnika();
dnevnik_zapis("Uspješna autorizacija");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    <center>
        Pozdrav korisniku: <b>
            <?php
            echo $korisnik->get_ime_prezime() . "</b> koji je prijavljen od: " . $korisnik->get_prijavljen_od() .
            " i aktivan : " . $korisnik->get_aktivan() . " sek";
            ?>
    </center>
    <p align="right"><a href="logout.php">Odjava</a></p>
    <?php
    if (isset($_SESSION["korisnici"])) {
        $korisnici = $_SESSION["korisnici"];
    } else {
        $korisnici = array();
    }

    if (isset($_GET["akcija"]) && $_GET["akcija"] == "dodaj" && isset($_GET["korisnik"])) {
        $noviKorisnik = $_GET["korisnik"];
        if (isset($korisnici[$noviKorisnik])) {
            $stariKorisnik = $korisnici[$noviKorisnik];
            print "Korisnik: $noviKorisnik: " . $stariKorisnik->get_ime_prezime() . " već postoji u košarici!";
        } else {
            $dbc = pripremiBazuPodataka();

            $sql = "select prezime, ime, lozinka, vrsta FROM POLAZNICI where maticni_broj = '$noviKorisnik'";
            $rs = $dbc->query($sql);
            if (!$rs) {
                trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
            }

            $broj = $rs->num_rows;
            $dodaniKorisnik = new Korisnik();

            if ($broj == 1) {
                list($prezime, $ime, $lozinka, $vrsta) = $rs->fetch_array();
                $dodaniKorisnik->set_podaci($noviKorisnik, $ime, $prezime, $lozinka, $vrsta);
                $korisnici[$noviKorisnik] = $dodaniKorisnik;
                $_SESSION["korisnici"] = $korisnici;
            } else {
                print "Korisnik: $noviKorisnik: ne postoji u bazi podataka!<br>";
            }
            $dbc->close();
        }
    }
    if (isset($_GET["akcija"]) && $_GET["akcija"] == "brisi" && isset($_GET["korisnik"])) {
        $noviKorisnik = $_GET["korisnik"];
        if (isset($korisnici[$noviKorisnik])) {
            unset($korisnici[$noviKorisnik]);
            $_SESSION["korisnici"] = $korisnici;
        } else {
            print "Korisnik: $noviKorisnik: NE postoji u ko�arici!<br>";
        }
    }
    ?>
    <br><a href="aplikacija.php">Početak aplikacije</a><br>
    Korisnici u košarici<br>
    <table border=1><tr><td>Prezime</td><td>Ime</td><td>Matični_broj</td><td>Vrsta</td><td>Akcija</td></tr>
        <?php
        foreach ($korisnici as $k => $v) {
            $prezime = $v->get_prezime();
            $ime = $v->get_ime();
            $maticni_broj = $k;
            $vrsta = $v->get_vrsta();
            print "<tr><td>$prezime</td><td>$ime</td><td>$maticni_broj</td><td>$vrsta</td>";
            print "<td><a href='kosarica.php?akcija=brisi&korisnik=$maticni_broj'>Obrisi iz košarice</a></td></tr>\n";
        }
        ?>
    </body>
</html>