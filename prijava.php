<?php
session_start();

include("include_smarty.php");
include("include_baza.class.php");
include("include_meni.php");

$db = new Baza();
$conn = $db->spojiDB();

$greske = [];
$uspjehi = [];

if (!empty($_POST)) {

    if (empty($_POST['korime'])) {
        $greske[] = "Korisničko ime nije uneseno!";
    }

    if (empty($_POST['lozinka'])) {
        $greske[] = "Lozinka nije unesena!";
    }

    if (empty($greske)) {
        if(isset($_SESSION['brojPokusaja']) && $_SESSION['brojPokusaja'] >= 3) {
            $stmt = $conn->prepare("SELECT korime FROM Korisnik WHERE korime = ?");
            $stmt->bind_param("s", $_POST['korime']);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->affected_rows == 1) {
                $stmt = $conn->prepare("UPDATE Korisnik SET aktivan = 0 WHERE korime = ?");
                $stmt->bind_param("s", $_POST['korime']);
                $stmt->execute();

                $greske[] = "Vaš korisnički račun je blokiran. Javite se administratoru!";
            }
        } else {
            $stmt = $conn->prepare("SELECT idKorisnik, korime, email, idTIP, lozinkaKriptirana, brojPrijave FROM Korisnik WHERE aktivan = 1 AND korime = ?");

            $stmt->bind_param("s", $_POST['korime']);
            $stmt->bind_result($idKorisnik, $korime, $email, $idTIP, $lozinkaKriptirana, $brojPrijave);
            $stmt->execute();
            $stmt->store_result();
            $stmt->fetch();

            if($stmt->affected_rows == 1 && crypt($_POST['lozinka'], $lozinkaKriptirana) == $lozinkaKriptirana) {

                if($_POST['zapamtiMe'] == 1) {
                    setcookie("korime", $korime, time() + 24 * 30 * 60 * 60);
                } else {
                    setcookie("korime", $korime,time() - 24 * 30 * 60 * 60);
                }

                if($brojPrijave == 2) {
                    $aktivacijskiKod = md5(uniqid("randomstring", true));

                    $stmt = $conn->prepare("UPDATE Korisnik SET aktivacijskiKod = ? WHERE korime = ?");
                    $stmt->bind_param("ss", $aktivacijskiKod, $korime);
                    if($stmt->execute()) {
                        $_SESSION['vrijeme'] = time();

                        mail($email, 'Aktivacijski kod prijave', $aktivacijskiKod);

                        header("location: prijava_drugi_korak.php");
                    } else {
                        $greske[] = "Aktivacijski kod nije upisan u bazu!";
                    }
                } else {
                    $_SESSION['idKorisnik'] = $idKorisnik;
                    $_SESSION['tip'] = $idTIP;

                    unset($_SESSION['brojPokusaja']);

                    $stmt = $conn->prepare("INSERT INTO Statistika (vrijeme, akcija, idKorisnik) VALUES (?, 2, ?)");
                    $stmt->bind_param("ii", time(), $_SESSION['idKorisnik']);
                    $stmt->execute();

                    header("location: index.php");
                }
            } else {
                $_SESSION['brojPokusaja'] = isset($_SESSION['brojPokusaja']) ? $_SESSION['brojPokusaja'] + 1 : 1;
                $greske[] = "Krivo korisničko ime ili lozinka!";
            }
        }
    }
}

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Prijava');
if (empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
if (isset($_COOKIE["korime"])) {
    $smarty->assign('korime', $_COOKIE["korime"]);
}
$smarty->assign('greske', $greske);
$smarty->assign('uspjehi', $uspjehi);

$smarty->display('prijava.tpl');

$db->zatvoriDB();
?>