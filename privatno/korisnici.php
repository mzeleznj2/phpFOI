<?php

include '../include_baza.class.php';

$db = new Baza();
$conn = $db->spojiDB();

$stmt = $conn->prepare("SELECT korime, ime, prezime, email, sifra, naziv FROM Korisnik, Tip WHERE Korisnik.idTip = Tip.idTip");
$stmt->bind_result($korime, $ime, $prezime, $email, $sifra, $tip);
$stmt->execute();
?>

<table border=1>
    <tr>
        <td><b>Korisnicko ime</b></td>
        <td><b>Ime</b></td>
        <td><b>Prezime</b></td>
        <td><b>Email</b></td>
        <td><b>Lozinka</b></td>
        <td><b>Tip</b></td>
    </tr>

<?php while ($stmt->fetch()) : ?>
    <tr>
        <td><?php echo $korime ?></td>
        <td><?php echo $ime ?></td>
        <td><?php echo $prezime ?></td>
        <td><?php echo $email ?>/td>
        <td><?php echo $sifra ?></td>
        <td><?php echo $tip ?></td>
    </tr>
<?php endwhile; ?>

</table>