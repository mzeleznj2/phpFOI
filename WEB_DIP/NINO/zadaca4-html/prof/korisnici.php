<?PHP
include_once './baza.class.php';
    $baza=new Baza();
$tablica = "korisnici";
$upitAktivni = "SELECT * FROM $tablica WHERE {$tablica}_status='1';";
$podaci = $baza->selectDB($upitAktivni);
$ispis="<table><thead><th>Ime</th><th>Prezime</th><th>Email</th><th>Detalji</th></thead>";

while($red = $podaci->fetch_array()){
    $ispis.="<tr>";
    $ispis.="<td>".$red['korisnici_naziv']."</td>";
    $ispis.="<td>".$red['korisnici_prezime']."</td>";
    $ispis.="<td>".$red[2]."</td>";
    $ispis.="<td><a href=\"detalji.php?idKorisnika={$red[0]}\">Detalji</a></td>";
    $ispis.="</tr>";
}

$ispis=$ispis."<tbody>";
$ispis.="</tbody></table>";
echo $ispis;
?>
