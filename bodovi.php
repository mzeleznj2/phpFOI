<?php
session_start();

if($_SESSION['tip'] != 3 ) {
    header("location: prijava.php");
}

include("include_smarty.php");
include("include_baza.class.php");
include("include_meni.php");

$db = new Baza();
$conn = $db->spojiDB();

$greske = [];
$uspjehi = [];

$stmt = $conn->prepare("SELECT potroseniBodovi, vrijeme, Akcija.bodovi, Akcija.opis FROM Statistika, Akcija, Korisnik WHERE Akcija.idAkcija = Statistika.akcija AND Korisnik.idKorisnik = Statistika.idKorisnik AND Statistika.idKorisnik = ? ORDER BY vrijeme DESC");
$stmt->bind_param("i", $_SESSION['idKorisnik']);
$stmt->bind_result($potroseniBodovi, $vrijeme, $bodovi, $akcija);
$stmt->execute();

$bodoviRezultat = [];
$ukupno['bodovi'] = 0;
$ukupno['potroseno'] = 0;
while($stmt->fetch()) {
    $ukupno['bodovi'] += $bodovi;
    $ukupno['potroseno'] = $potroseniBodovi;
    $bodoviRezultat[] = [date("d.m.Y H:i", $vrijeme), $bodovi, $akcija];
}

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Bodovi');
if (empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
$smarty->assign('bodovi', $bodoviRezultat);
$smarty->assign('ukupno', $ukupno);

$smarty->display('bodovi.tpl');

$db->zatvoriDB();

?>