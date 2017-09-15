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

if(isset($_POST['isprazni'])) {
    unset($_SESSION['kosarica']);
}

if(isset($_GET['idKupon']) && isset($_GET['program'])) {
    $_SESSION['kosarica'][] = [$_GET['idKupon'], $_GET['program']];
}

if(isset($_POST['idKupon']) && isset($_POST['idProgram'])) {
    $stmt = $conn->prepare("SELECT potroseniBodovi, Akcija.bodovi FROM Statistika, Akcija, Korisnik WHERE Akcija.idAkcija = Statistika.akcija AND Korisnik.idKorisnik = Statistika.idKorisnik AND Statistika.idKorisnik = ?");
    $stmt->bind_param("i", $_SESSION['idKorisnik']);
    $stmt->bind_result($potroseniBodovi, $bodovi);
    $stmt->execute();

    $ukupno['bodovi'] = 0;
    $ukupno['potroseno'] = 0;
    while($stmt->fetch()) {
        $ukupno['bodovi'] += $bodovi;
        $ukupno['potroseno'] = $potroseniBodovi;
    }
    $stmt->close();
    $bodoviTrenutno = $ukupno['bodovi'] - $ukupno['potroseno'];

    $stmt = $conn->prepare("SELECT bodovi FROM Kupon_za_program WHERE idProgram = ? AND idKupon = ? AND bodovi <= ?");
    $stmt->bind_param("iii", $_POST['idProgram'], $_POST['idKupon'], $bodoviTrenutno);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->affected_rows == 1) {
        $stmt->close();

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $kod = substr(str_shuffle($chars), 0, 15);

        $stmt = $conn->prepare("INSERT INTO Korisnik_kupon (idProgram, idKupon, idKorisnik, kod_kupon) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $_POST['idProgram'], $_POST['idKupon'], $_SESSION['idKorisnik'], $kod);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("SELECT bodovi FROM Kupon_za_program WHERE idProgram = ? AND idKupon = ?");
        $stmt->bind_param("ii", $_POST['idProgram'], $_POST['idKupon']);
        $stmt->bind_result($bodoviKupon);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();

        $stmt = $conn->prepare("UPDATE Korisnik SET potroseniBodovi = potroseniBodovi + ? WHERE idKorisnik = ?");
        $stmt->bind_param("ii", $bodoviKupon, $_SESSION['idKorisnik']);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO Statistika (vrijeme, akcija, idKorisnik) VALUES (?, 3, ?)");
        $stmt->bind_param("ii", time(), $_SESSION['idKorisnik']);
        $stmt->execute();
        $stmt->close();

        foreach ($_SESSION['kosarica'] as $key => $kosarica) {
            if (in_array($_POST['idKupon'], $kosarica) && in_array($_POST['idProgram'], $kosarica)) {
                unset($_SESSION['kosarica'][$key]);
            }
        }
    } else {
        $stmt->close();
        $greske[] = "Nemate dovoljno bodova za kupovinu ovog kupona";
    }
}

$rezultat = [];
if(isset($_SESSION['kosarica'])) {
    foreach ($_SESSION['kosarica'] as $kosarica) {
        $stmt = $conn->prepare("SELECT naziv, slika, aktivan_od, aktivan_do, bodovi FROM Kupon, Kupon_za_program WHERE Kupon.idKupon = Kupon_za_program.idKupon AND Kupon.idKupon = ? AND Kupon_za_program.idProgram = ?");
        $stmt->bind_param("ii", $kosarica[0], $kosarica[1]);
        $stmt->bind_result($naziv, $slika, $aktivan_od, $aktivan_do, $bodovi);
        $stmt->execute();
        $stmt->fetch();

        $rezultat[] = [$kosarica[0], $kosarica[1], $naziv, $slika, date("d.m.Y H:i", $aktivan_od), date("d.m.Y H:i", $aktivan_do), $bodovi];
        $stmt->close();
    }
}

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Košarica');
if(empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
$smarty->assign('greske', $greske);

$smarty->assign('rezultat', $rezultat);

$smarty->display('kosarica.tpl');

$db->zatvoriDB();