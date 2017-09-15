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

$stmt = $conn->prepare("SELECT opis, naziv FROM Evidencija, Program WHERE Evidencija.idProgram = Program.idProgram AND Evidencija.idKorisnik = ? GROUP BY Evidencija.idEvidencija ORDER BY idEvidencija DESC");
$stmt->bind_param("i", $_SESSION['idKorisnik']);
$stmt->bind_result($opis, $naziv);
$stmt->execute();

while($stmt->fetch()) {
    $evidencija[] = [$opis, $naziv];
}

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Evidencija');
if (empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
if(isset($evidencija)) {
    $smarty->assign('evidencija', $evidencija);
}

$smarty->display('evidencija.tpl');

$db->zatvoriDB();
?>