<?php
include_once('aplikacijskiOkvir.php');

provjeraUloge(ADMINISTRATOR);
dnevnik_zapis("Uspješna autorizacija");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Odabir razine izvještavanja o pogreškama</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Odabir razine izvještavanja o pogreškama</h1>
        <form method="POST" action="upisiPostavke.php">
            Odaberi elemente:<br>
            <input type="checkbox" name="E_ALL" value="1">E_ALL<br>
            <input type="checkbox" name="E_ERROR" value="1">E_ERROR<br>
            <input type="checkbox" name="E_WARNING" value="1">E_WARNING<br>
            <input type="checkbox" name="E_PARSE" value="1">E_PARSE<br>
            <input type="checkbox" name="E_NOTICE" value="1">E_NOTICE<br>
            <input type="submit" value=" Pošalji ">
        </form>
        <br><a href='aplikacija.php'>Početak aplikacije</a><br>        
    </body>
</html>
