<?php
session_start();

include("include_smarty.php");
include("include_baza.class.php");
include("include_meni.php");

$db = new Baza();
$conn = $db->spojiDB();

$greske = [];
$uspjehi = [];

$stmt = $conn->prepare("SELECT idVrsta, vrsta FROM Vrste_vjezbe");
$stmt->bind_result($idVrsta, $vrsta);
$stmt->execute();

while($stmt->fetch()) {
    $vrstaPrograma[] = [$idVrsta, $vrsta];
}

if(!empty($_POST)) {
    $stmt = $conn->prepare("SELECT naziv, vrijeme, trajanje, COUNT(Polaznik.idKorisnik) AS count FROM Program, Polaznik WHERE idVrsta = ? AND Program.idProgram = Polaznik.idProgram GROUP BY Program.idProgram ORDER BY count DESC LIMIT 3");
    $stmt->bind_param("i", $_POST['idVrsta']);
    $stmt->bind_result($naziv, $vrijeme, $trajanje, $count);
    $stmt->execute();

    while($stmt->fetch()) {
        $programi[] = [$naziv, $vrijeme > 0 ? date("d.m.Y H:i", $vrijeme) : "", $trajanje, $count];
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

$smarty->display('programi_gost.tpl');

$db->zatvoriDB();

?>