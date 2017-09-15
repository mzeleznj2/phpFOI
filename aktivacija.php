<?php

include("include_baza.class.php");

if (isset($_GET['kod']) && !empty($_GET['kod']))
    {
        $db = new Baza();
        $conn = $db->spojiDB();

        $vrijeme = time() - 5 * 60 * 60;
        $stmt = $conn->prepare("SELECT idKorisnik FROM Korisnik WHERE aktivacijskiKod = ? AND aktivacijskoVrijeme > ?");
        $stmt->bind_param("ss", $_GET['kod'], $vrijeme);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();

        if($stmt->affected_rows == 1) {
            $stmt = $conn->prepare("UPDATE Korisnik SET aktivan = 1 WHERE aktivacijskiKod = ?");
            $stmt->bind_param("s", $_GET['kod']);
            $stmt->execute();
            $db->zatvoriDB();

            header("location: prijava.php");
        } else {
            $db->zatvoriDB();
            echo "Greška! Aktivacijski link je pogrešan!";
        }

    }
