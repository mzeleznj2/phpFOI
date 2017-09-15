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
$conn2 = $db->spojiDB();

$greske = [];
$uspjehi = [];

$stmt = $conn->prepare("SELECT idVrsta, vrsta FROM Vrste_vjezbe");
$stmt->bind_result($idVrsta, $vrsta);
$stmt->execute();

while($stmt->fetch()) {
    $vrstaPrograma[] = [$idVrsta, $vrsta];
}

if(!empty($_POST)) {
    $stmt = $conn->prepare("SELECT Program.idProgram, vrijeme, zamjenski_termin, broj_polaznika, Program.idKorisnik, idVrsta, trajanje, naziv, COUNT(Polaznik.idKorisnik) AS broj_polaznika_count FROM Program, Polaznik WHERE idVrsta = ? AND Program.idProgram = Polaznik.idProgram GROUP BY Program.idProgram ORDER BY Program.vrijeme DESC");
    $stmt->bind_param("i", $_POST['idVrsta']);
    $stmt->bind_result($idProgram, $vrijeme, $zamjenski_termin, $broj_polaznika, $idKorisnik, $idVrsta, $trajanje, $naziv, $broj_polazinka_count);
    $stmt->execute();

    while($stmt->fetch()) {
        $stmt2 = $conn2->prepare("SELECT idProgram FROM Polaznik WHERE idProgram = ? AND idKorisnik = ?");
        $stmt2->bind_param("ii", $idProgram, $_SESSION['idKorisnik']);
        $stmt2->execute();
        $stmt2->store_result();

        $programi[] = [$idProgram, $vrijeme, $zamjenski_termin, $broj_polaznika, $idKorisnik, $idVrsta, $trajanje, $naziv, $broj_polazinka_count, $stmt2->affected_rows == 1 ? 1 : 0];
    }

    if(isset($programi)) {
        $smarty->assign('programi', $programi);
    }
}

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Programi');
if (empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
$smarty->assign('vrstaPrograma', $vrstaPrograma);

$smarty->display('programi.tpl');

$db->zatvoriDB();

?>