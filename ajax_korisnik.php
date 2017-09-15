<?php
include("include_baza.class.php");

if(isset($_POST['korisnik'])) {
    $db = new Baza();
    $conn = $db->spojiDB();

    $stmt = $conn->prepare("SELECT idKorisnik FROM Korisnik WHERE korime = ?");
    $stmt->bind_param("s", $_POST['korisnik']);
    $stmt->execute();
    $stmt->store_result();

    if( $stmt->affected_rows > 0 ) {
        echo "1";
    }
}