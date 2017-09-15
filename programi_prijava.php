<?php
session_start();

if($_SESSION['tip'] != 3 ) {
    header("location: prijava.php");
}

include("include_baza.class.php");

if(isset($_POST['idProgram']) && isset($_SESSION['idKorisnik'])) {
    $db = new Baza();
    $conn = $db->spojiDB();

    $stmt = $conn->prepare("INSERT INTO Polaznik (idProgram, idKorisnik) VALUES (?, ?)");
    $stmt->bind_param("ii", $_POST['idProgram'], $_SESSION['idKorisnik']);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO Statistika (vrijeme, akcija, idKorisnik) VALUES (?, 1, ?)");
    $stmt->bind_param("ii", time(), $_SESSION['idKorisnik']);
    $stmt->execute();

    header("location: programi.php");
}