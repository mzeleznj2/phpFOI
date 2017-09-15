<?php
session_start();

if($_SESSION['tip'] != 1 ) {
    header("location: prijava.php");
}

include("include_smarty.php");
include("include_baza.class.php");
include("include_meni.php");

$db = new Baza();
$conn = $db->spojiDB();

$greske = [];
$uspjehi = [];

if(isset($_POST['otkljucaj'])) {
    $stmt = $conn->prepare("UPDATE Korisnik SET aktivan = 1 WHERE idKorisnik = ?");
    $stmt->bind_param("i", $_POST['otkljucaj']);
    $stmt->execute();
    $stmt->close();
}

if(isset($_POST['zakljucaj'])) {
    $stmt = $conn->prepare("UPDATE Korisnik SET aktivan = 0 WHERE idKorisnik = ?");
    $stmt->bind_param("i", $_POST['zakljucaj']);
    $stmt->execute();
    $stmt->close();
}

if(isset($_POST['tip']) && isset($_POST['idKorisnik'])) {
    $stmt = $conn->prepare("UPDATE Korisnik SET idTIP = ? WHERE idKorisnik = ?");
    $stmt->bind_param("ii", $_POST['tip'], $_POST['idKorisnik']);
    $stmt->execute();
    $stmt->close();
}

$stmt = $conn->prepare("SELECT idKorisnik, korime, ime, prezime, email, Korisnik.idTIP, aktivan, Tip.naziv FROM Korisnik, Tip WHERE Korisnik.idTIP = Tip.idTip ORDER BY idKorisnik DESC");
$stmt->bind_result($idKorisnik, $korime, $ime, $prezime, $email, $idTip, $aktivan, $tipNaziv);
$stmt->execute();

$korisnici = [];
while($stmt->fetch()) {
    $korisnici[] = [$idKorisnik, $korime, $ime, $prezime, $email, $idTip, $aktivan, $tipNaziv];
}
$stmt->close();

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Korisnici');
if(empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
$smarty->assign('greske', $greske);

$smarty->assign('korisnici', $korisnici);

$smarty->display('korisnici.tpl');

$db->zatvoriDB();