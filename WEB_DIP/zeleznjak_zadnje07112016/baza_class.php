<?php

class Baza
{
    // protected $server = 'localhost';
    // protected $korisnik = 'WebDiP2015x092';
    // protected $lozinka = 'admin_hL7u';
    // protected $baza = 'WebDiP2015x092';
	
	 protected $server = 'localhost';
    protected $korisnik = 'phpuser';
    protected $lozinka = '12345';
    protected $baza = 'WebDiP2015x092';

    private $veza = null;
    private $greska = '';


    function spojiDB()
    {
        $this->veza = new mysqli($this->server, $this->korisnik, $this->lozinka, $this->baza);
        if ($this->veza->connect_errno) {
            echo 'Neuspješno spajanje na bazu: ' . $this->veza->connect_errno . ', ' . $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        }
        $this->veza->set_charset('utf8');
        if ($this->veza->connect_errno) {
            echo 'Neuspješno postavljanje znakova za bazu: ' . $this->veza->connect_errno . ', ' . $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        }
        return $this->veza;
    }

    function selectDB($upit)
    {
        $rezultat = $this->veza->query($upit);
        if ($this->veza->connect_errno) {
            echo 'Greška kod upita: - ' . $this->veza->connect_errno . ', ' . $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        }
        if (!$rezultat) {
            $rezultat = null;
        }
        return $rezultat;
    }

    function updateDB($upit, $skripta = '')
    {
        $rezultat = $this->veza->query($upit);
        if ($this->veza->connect_errno) {
            echo 'Greška kod upita: - ' . $this->veza->connect_errno . ', ' .
                $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        } else {
            if ($skripta != '') {
                header('Location: $skripta');
            }
        }

        return $rezultat;
    }

    function zatvoriDB()
    {
        $this->veza->close();
    }

    function pogreskaDB()
    {
        if ($this->greska != '') {
            return true;
        } else {
            return false;
        }
    }
}

?>