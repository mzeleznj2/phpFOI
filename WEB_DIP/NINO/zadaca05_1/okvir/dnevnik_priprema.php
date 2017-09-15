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
    <body>
    <center>
        Pozdrav korisniku: <b>
            <?php
            echo $korisnik->get_ime_prezime() . "</b> koji je prijavljen od: " . $korisnik->get_prijavljen_od() .
            " i aktivan : " . $korisnik->get_aktivan() . " sek";
            ?>
    </center>
    <p align="right"><a href="logout.php">Odjava</a></p>        
        <form id=form1 method=post name="form1" action="dnevnik_pregled.php">
            <P>
                <?php
                if ($korisnik->get_vrsta() == ADMINISTRATOR) {
                    ?>
                    Korisnik:<input name="korisnik"><br>
                    <?php
                }
                $poc = "01." . date('m.Y');
                $zav = date('d.m.Y');
                ?>
                Od datuma: <input name = "odDatuma" value="<?php echo $poc; ?>"><br>
                Do datuma: <input name = "doDatuma" value="<?php echo $zav; ?>"><br>
                <input type = "submit" value = " Šalji ">
        </form>
    </body>
</html>