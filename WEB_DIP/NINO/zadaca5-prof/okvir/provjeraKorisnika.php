<?php

include_once('korisnik.class.php');

function provjeraKorisnika() {
    $korisnik = null;

    session_start();
    if (!isset($_SESSION["ID"])) {
        header("Location: error.php?e=2");
        exit();
    } else {
        $korisnik = $_SESSION["ID"];
        if ($korisnik->get_status() != 1) {
            header("Location: error.php?e=2");
            exit();
        } 
        if($korisnik->get_adresa() != $_SERVER["REMOTE_ADDR"]) {
            header("Location: error.php?e=2");
            exit();
        }
    }
    return $korisnik;
}

?>