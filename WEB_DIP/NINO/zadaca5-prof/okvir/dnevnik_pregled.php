<?php
include_once('aplikacijskiOkvir.php');

$korisnik = provjeraKorisnika();
dnevnik_zapis("Uspješna autorizacija");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pregled dnevnika</title>
        <meta charset="utf-8">
    </head>
    <center>
        Pozdrav korisniku: <b>
            <?php
            echo $korisnik->get_ime_prezime() . "</b> koji je prijavljen od: " . $korisnik->get_prijavljen_od() .
            " i aktivan : " . $korisnik->get_aktivan() . " sek";
            ?>
    </center>
    <p align="right"><a href="logout.php">Odjava</a></p>    
    <body>
        <?php
        if ($korisnik->get_vrsta() != ADMINISTRATOR) {
            $kor_ime = $korisnik->get_kor_ime();
        } else {
            if (!isset($_POST["korisnik"]) || $_POST["korisnik"] == "") {
                $kor_ime = "%";
            } else {
                $kor_ime = $_POST["korisnik"];
            }
        }
        if (!isset($_POST["odDatuma"])) {
            echo "Nije upisan Od datuma!";
            exit();
        } else {
            $pd = date_create_from_format("d.m.Y", $_POST["odDatuma"]);
            $odDatuma = date_format($pd, "Y.m.d 00:00:00");
        }
        if (!isset($_POST["doDatuma"]) || empty($_POST["doDatuma"])) {
            $doDatuma = date("Y.m.d 23:55:55");
        } else {
            $pd = date_create_from_format("d.m.Y", $_POST["doDatuma"]);
            $doDatuma = date_format($pd, "Y.m.d 23:55:55");
        }

        $dbc = pripremiBazuPodataka();

        $sql = "select korisnik, adresa, skripta, tekst, preglednik, vrijeme FROM DNEVNIK " .
                "WHERE korisnik like '" . $kor_ime . "' and " .
                "vrijeme between '" . $odDatuma . "' and '" . $doDatuma . "'";

        $rs = $dbc->query($sql);
        if (!$rs) {
            echo "Problem kod upita na bazu podataka!";
            exit;
        }

        print "<table border=1><tr><td>Korisnik</td><td>Adresa</td><td>Sktipta</td><td>Vrijeme</td></tr>\n";

        while (list($korime, $adresa, $skripta, $tekst, $preglednik, $vrijeme) = $rs->fetch_row()) {
            $d = date("d.m.Y H:i:s", strtotime($vrijeme));
            print "<tr><td>$korime</td><td>$adresa</td><td>$skripta</td><td>$d</td></tr>\n";
        }
        print "</table>\n";

        $dbc->close();
        ?>
        <br><a href='aplikacija.php'>Početak aplikacije</a><br>          
    </table>
</body>
</html>
