<?php
session_start();

include("include_smarty.php");
include("include_baza.class.php");
include("include_meni.php");

$baza = new Baza();
$conn = $baza->spojiDB();

$greske = [];
$uspjehi = [];

if (!empty($_POST)) {
    $stmt = $conn->prepare("SELECT idKorisnik, idTIP FROM Korisnik WHERE aktivacijskiKod = ?");
    $stmt->bind_param("s", $_POST['aktivacijskiKod']);
    $stmt->bind_result($idKorisnik, $idTIP);
    $stmt->execute();
    $stmt->store_result();
    $stmt->fetch();

    if($stmt->affected_rows == 1) {
        if(isset($_SESSION['vrijeme']) && $_SESSION['vrijeme'] + 60 * 5 > time()) {
            unset($_SESSION['vrijeme']);
            unset($_SESSION['brojPokusaja']);

            $_SESSION['idKorisnik'] = $idKorisnik;
            $_SESSION['tip'] = $idTIP;

            $stmt = $conn->prepare("INSERT INTO Statistika (vrijeme, akcija, idKorisnik) VALUES (?, 2, ?)");
            $stmt->bind_param("ii", time(), $_SESSION['idKorisnik']);
            $stmt->execute();

            header("location: index.php");
        } else {
            $greske[] = "Vrijeme za unos aktivacijskog koda je isteklo!";
        }
    } else {
        $greske[] = "Aktivacijski kod je neispravan!";
    }
}

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Drugi korak prijave');
if (empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
$smarty->assign('greske', $greske);
$smarty->assign('uspjehi', $uspjehi);

$smarty->display('prijava_drugi_korak.tpl');

$baza->zatvoriDB();
?>