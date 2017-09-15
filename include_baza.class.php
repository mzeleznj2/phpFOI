<?php

class Baza {
    const server = "localhost";
    const korisnik = "WebDiP2016x130";
    const lozinka = "admin_Nmib";
    const baza = "WebDiP2016x130";

    private $veza;

    function spojiDB() {
        $this->veza = new mysqli(self::server, self::korisnik, self::lozinka, self::baza);
        if ($this->veza->connect_errno) {
            echo "Neuspješno spajanje na bazu: " . $this->veza->connect_errno;
        }

        $this->veza->set_charset("utf8");

        return $this->veza;
    }

    function zatvoriDB() {
        $this->veza->close();
    }
}

