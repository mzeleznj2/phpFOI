<?php
include_once('./okvir/aplikacijskiOkvir.php');

dnevnik_zapis("Neuspješna autorizacija");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        $e = $_GET["e"];
        $message = "";
        switch ($e) {
            case -1: $message = "Korisnik ne postoji.";
                break;
            case 0: $message = "Nispravno korisničko ime/lozinka.";
                break;
            case 2: $message = "Neautorizirani pristup.";
                break;
            default: $message = "Nepoznata pogreska.";
                break;
        }
        print $message;
        ?>
    </body>
</html>