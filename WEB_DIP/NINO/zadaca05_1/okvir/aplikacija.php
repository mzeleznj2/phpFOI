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
    <p align="right"><a href="kosarica.php">Košarica</a></p>
    <p align="right"><a href="postaviPostavke.php">Postavi postavke</a></p>
    <p align="right"><a href="dnevnik_priprema.php">Pregled dnevnika</a></p>
    <p align="right"><a href="logout.php">Odjava</a></p>
    <?php
    $dbc = pripremiBazuPodataka();

    $sql = "select prezime, ime, maticni_broj FROM POLAZNICI " .
            "order by prezime, ime";
    $rs = $dbc->query($sql);
    if (!$rs) {
        trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }
    ?>
    <table border=1><tr><td>Prezime</td><td>Ime</td><td>Matični_broj</td><td>Akcija</td></tr>
        <?php
        while (list($prezime, $ime, $maticni_broj) = $rs->fetch_array()) {
            print "<tr><td>$prezime</td><td>$ime</td><td>$maticni_broj</td>";
            print "<td><a href='kosarica.php?akcija=dodaj&korisnik=$maticni_broj'>Dodaj u košaricu</a></td></tr>\n";
        }
        $rs->close();
        $dbc->close();
        ?>
    </table>
</body>
</html>