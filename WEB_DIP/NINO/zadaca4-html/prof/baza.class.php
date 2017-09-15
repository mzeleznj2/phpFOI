<?php

class Baza {

    const server = "localhost";
    const baza = "WebDiP2013";
    const korisnik = "WebDiP2013";
    const lozinka = "adminWebDiP";

    private function spojiDB() {
        $mysqli = new mysqli(self::server, self::korisnik, self::lozinka, self::baza);
        if ($mysqli->connect_errno) {
            echo "Neuspješno spajanje na bazu: " . $mysqli->connect_errno . ", " . $mysqli->connect_error;
        }
        return $mysqli;
    }

    function selectDB($upit) {
        
        $veza = $this->spojiDB();
        $rezultat = $veza->query($upit) or trigger_error("Greška kod upita {$upit} - "
                        . "Greška: " . $veza->error . " " . E_USER_ERROR);
        if (!$rezultat) {
            $rezultat = null;
        }
        $veza->close();
        return $rezultat;
    }

    function updateDB($upit, $skripta = '') {
        $veza = self::spojiDB();
        if ($rezultat = $veza->query($upit)) {
            $veza->close();
            if ($skripta != '') {
                header("Location: $skripta");
            } else {
                return $rezultat;
            }
        } else {
            $veza->close();
            return null;
        }
    }
}

?>