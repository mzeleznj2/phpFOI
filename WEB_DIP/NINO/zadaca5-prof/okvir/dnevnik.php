<?php

function dnevnik_zapis($tekst) {
    $korisnik = isset($_SESSION["PzaWeb"]) ? $_SESSION["PzaWeb"]->get_kor_ime() : "";
    $adresa = $_SERVER["REMOTE_ADDR"];
    $skripta = $_SERVER["REQUEST_URI"];
    $preglednik = $_SERVER["HTTP_USER_AGENT"];
    
    $dbc = pripremiBazuPodataka();

    $sql = "insert into dnevnik (korisnik, adresa, skripta, tekst, preglednik) values " .
            "('$korisnik', '$adresa', '$skripta', '$tekst', '$preglednik')";

    $rs = $dbc->query($sql);
    if (!$rs) {
        trigger_error("Problem kod upisa u bazu podataka!" . $dbc->error, E_USER_ERROR);
    }

    $dbc->close();
}

?>