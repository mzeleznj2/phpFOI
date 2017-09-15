<?php
session_start();

include("include_smarty.php");
include("include_baza.class.php");
include("include_meni.php");

$greske = [];
$uspjehi = [];

if (!empty($_POST)) {
    $db = new Baza();
    $conn = $db->spojiDB();

    $email = $_POST ['email'];

    $stmt = $conn->prepare("SELECT idKorisnik FROM Korisnik WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->affected_rows  == 1) {
        $randomLozinka = substr(md5(rand()), 0, 10);
        $lozinkaKriptirana = crypt($randomLozinka, hash("sha256", uniqid("",true)));

        $stmt = $conn->prepare("UPDATE Korisnik SET sifra = ?, lozinkaKriptirana = ? WHERE email = ?");
        $stmt->bind_param("sss", $randomLozinka, $lozinkaKriptirana, $email);
        $stmt->execute();

        mail($email, 'Vaša nova lozinka je: ', $randomLozinka);

        $uspjehi[]= "Nova lozinka poslana vam je na mail!";
        
    } else {
        $greske[] = "Takav email ne postoji!";
    }

    $db->zatvoriDB();
}

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Promjena lozinke');
if (empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}
$smarty->assign('greske', $greske);
$smarty->assign('uspjehi', $uspjehi);

$smarty->display('promjena_lozinke.tpl');
?>
