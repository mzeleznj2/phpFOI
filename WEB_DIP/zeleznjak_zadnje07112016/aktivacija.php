<?php

include_once 'baza_class.php';

if (isset($_GET['kod']) && !empty($_GET['kod'])) {

    $sada = (new DateTime())->format('Y-m-d h:m:s');
    $upit = "SELECT * FROM korisnik WHERE aktivacijski_kod LIKE '" . $_GET['kod'] . "%' AND aktivacija_do > '" . $sada . "' ;";

    $baza = new Baza();
    $baza->spojiDB();
    $rezultat = $baza->selectDB($upit);

    if (!empty($rezultat) && mysqli_num_rows($rezultat) > 0) {
        $korisnik = mysqli_fetch_object($rezultat);

        $upit = "UPDATE korisnik set aktiviran=1 WHERE aktivacijski_kod='" . $_GET['kod'] . "' AND korisnik_id=" . $korisnik->id_korisnik . " ;";
        $baza->updateDB($upit);
        $baza->zatvoriDB();

        header("Location:detalji_korisnika.php?korisnik=" . $korisnik->id_korisnik . "&uspjeh=true");
    } else {
        echo "GREŠKA! Aktivacijski link je pogrešan ili je istekao";
    }
}