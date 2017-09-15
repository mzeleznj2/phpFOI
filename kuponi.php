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

$stmt = $conn->prepare("SELECT idProgram, naziv FROM Program");
$stmt->bind_result($idProgram, $naziv);
$stmt->execute();

$programi = [];
while ($stmt->fetch()) {
    $programi[] = [$idProgram, $naziv];
}
$stmt->close();

if(!empty($_POST)) {
    $stmt = $conn->prepare("SELECT potroseniBodovi FROM Korisnik WHERE idKorisnik = ?");
    $stmt->bind_param("i", $_SESSION['idKorisnik']);
    $stmt->bind_result($potroseniBodovi);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT SUM(Akcija.bodovi) AS bodovi FROM Akcija, Statistika WHERE Akcija.idAkcija = Statistika.akcija AND Statistika.idKorisnik = ?");
    $stmt->bind_param("i", $_SESSION['idKorisnik']);
    $stmt->bind_result($bodovi);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    $ukupno = $bodovi - $potroseniBodovi;
    $stmt = $conn->prepare("SELECT Kupon.idKupon, Kupon.naziv, Kupon.slika, Kupon_za_program.bodovi FROM Kupon, Kupon_za_program WHERE Kupon.idKupon = Kupon_za_program.idKupon AND Kupon_za_program.aktivan_do > ? AND Kupon_za_program.bodovi <= ? AND Kupon_za_program.idProgram = ?");
    $stmt->bind_param("iii", time(), $ukupno, $_POST['program']);
    $stmt->bind_result($idKupon, $naziv, $slika, $bodovi);
    $stmt->execute();

    $kuponi = [];
    while ($stmt->fetch()) {
        $kuponi[] = [$idKupon, $naziv, $slika, $bodovi];
    }
}

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Kuponi');
if(empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
if(isset($kuponi)) {
    $smarty->assign('kuponi', $kuponi);
}
$smarty->assign('programi', $programi);

$smarty->display('kuponi.tpl');

$db->zatvoriDB();

?>