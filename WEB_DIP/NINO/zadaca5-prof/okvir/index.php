<?php
if(! isset($_SERVER["HTTPS"]) || strtolower($_SERVER["HTTPS"]) != "on") {
    $adresa = 'https://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    header("Location: $adresa");   
    exit();    
}
include_once('aplikacijskiOkvir.php');

dnevnik_zapis("Početak aplikacije");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <form action="login.php" method="POST">
            <table border="0" cellspacing="5" cellpadding="5">
                <tr>
                    <td>Korisnik</td>
                    <td><input type="text" size="10" name="f_user"></td>
                </tr>
                <tr>
                    <td>Lozinka</td>
                    <td><input type="password" size="10" name="f_pass"></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="submit" value="Log In">
                    </td> 
                </tr> 
            </table>
        </form> 
    </body>
</html>