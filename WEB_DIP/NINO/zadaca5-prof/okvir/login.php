<?php

$uri = $_SERVER["REQUEST_URI"];
$pos = strrpos($uri, "/");
$dir = $_SERVER["SERVER_NAME"] . substr($uri, 0, $pos + 1);

if (!isset($_SERVER["HTTPS"]) || strtolower($_SERVER["HTTPS"]) != "on") {
    $adresa = 'https://' . $dir . 'index.php';
    header("Location: $adresa");
    exit();
}

include_once('aplikacijskiOkvir.php');

dnevnik_zapis("Prijava korisnika");

$f_user = $_POST["f_user"];
$f_pass = $_POST["f_pass"];

$korisnik = autentikacija($f_user, $f_pass);
if ($korisnik->get_status() == 1) {
    session_start();
    $_SESSION["PzaWeb"] = $korisnik;
    $adresa = 'http://' . $dir . 'aplikacija.php';
    header("Location: $adresa");
    exit();
} else {
    $adresa = 'http://' . $dir . 'error.php?e=p';
    header("Location: $adresa" . $korisnik->get_status());
    exit();
}
?>