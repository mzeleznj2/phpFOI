<?php
session_start();

include("include_smarty.php");
include("include_baza.class.php");
include("include_meni.php");
include("recaptcha/recaptcha.php");

$greske = [];
$uspjehi = [];

if (!empty($_POST)) {
    $db = new Baza();
    $conn = $db->spojiDB();

    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $korime = $_POST['korime'];
    $email = $_POST['email'];
    $lozinka1 = $_POST['lozinka1'];
    $lozinka2 = $_POST['lozinka2'];

    if (empty($ime) || empty($prezime) || empty($korime) || empty($email) || empty($lozinka1) || empty($lozinka2)) {
        $greske[] = "Niste unijeli sve podatke!";
    }
    
    $provjeraIme = preg_match('/["(){}\'#\\/]/', $ime);
    if ($provjeraIme) {
        $greske[] = "Ime ne smije sadržavati slijedeće znakove: (){}'!#\"\/";
    }

    $provjeraPrezime = preg_match('/["(){}\'#\\/]/', $prezime);
    if ($provjeraPrezime) {
         $greske[] = "Prezime ne smije sadržavati slijedeće znakove: (){}'!#\"\/";
    }
    
    $stmt = $conn->prepare("SELECT idKorisnik FROM Korisnik WHERE korime = ?");
    $stmt->bind_param("s", $korime);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->affected_rows > 0) {
        $greske[] = "Korisničko ime je zauzeto!";
    } 
    
    $provjeraKorime = preg_match('/["(){}\'#\\/]/', $korime);
    if ($provjeraKorime) {
        $greske[] = "Korisničko ime ne smije sadržavati slijedeće znakove: (){}'!#\"\/";
    }

    $provjeraEmail = preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $email);
    if ($email && !$provjeraEmail) {
        $greske[] = "Niste dobro upisali email";
    }

    $stmt = $conn->prepare("SELECT idKorisnik from Korisnik WHERE korime = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->affected_rows > 0) {
         $greske[] = "Email vec postoji!";
    }
    
    $provjera1 = preg_match('/^(?=(.*[A-Z]){2})(?=(.*[a-z]){2})(?=(.*[0-9]){1}).{5,15}$/', $lozinka1);
    if (!$provjera1) {
         $greske[] = "Lozinka mora sadržavat barem dva velika slova, dva mala slova i jedan broj, te mora biti duljine 5 do 15 znakova";
    }

    $provjera2 = preg_match('/["(){}\'#\\/]/', $lozinka1);
    if ($provjera2){
        $greske[] = "Lozinka ne smije sadržavati (){}'!#\"\/";
    }

    if ($lozinka1 != $lozinka2) {
        $greske[] = "Lozinke se ne podudaraju!";
    }

    if (!provjeriRecaptha()) {
        $greske[] = "Recaptcha nije ispravno unesena!";
    }
    
    if(empty($greske)) {
        $kriptirano = crypt($lozinka1);
        $brojPrijave = $_POST['nacinPrijave'];
        $aktivacijskiKod = generirajAktivacijskiKod($korime);
        $idTIP = 3;
        $vrijeme = time();

        $stmt = $conn->prepare("INSERT INTO Korisnik (korime, sifra, ime, prezime, email, lozinkaKriptirana, brojPrijave, idTIP, aktivacijskiKod, aktivacijskoVrijeme) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssiisi", $korime, $lozinka1, $ime, $prezime, $email, $kriptirano, $brojPrijave, $idTIP, $aktivacijskiKod, $vrijeme);

        if($stmt->execute()) {
            $link = 'http://barka.foi.hr/WebDiP/2016_projekti/WebDiP2016x130/aktivacija.php?kod=' . $aktivacijskiKod;
            mail($email, 'Aktivacijski kod zadaca 4', $link);

            setcookie("koristenjeKolacica","1",time() + 30 * 24 * 60 * 60);

            $uspjehi[] = "Provjerite svoj email i aktivirajte račun!";
        } else {
            $greske[] = "Došlo je do greške prilikom unosa novog korisnika u bazu.";
        }
    }

    $db->zatvoriDB();
}

function generirajAktivacijskiKod($korime)
{
    $kod = (string)time() .$korime;
    return $kod;
}

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Registracija');
if (empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
$smarty->assign('greske', $greske);
$smarty->assign('uspjehi', $uspjehi);

$smarty->display('registracija.tpl');
?>