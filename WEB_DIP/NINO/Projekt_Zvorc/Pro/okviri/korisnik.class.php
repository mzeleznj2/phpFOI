<?php

class Korisnik {

    private $id;
    private $korisnicko;
    private $ime;
    private $prezime;
    private $lozinka;
    private $tip;
    private $prijavljen_od;
    private $brojac;
    private $adresa;

    public function Korisnik() {
        
    }

    public function postavi($id, $korisnicko, $ime, $prezime, $lozinka, $tip) {
        $this->id = $id;
        $this->korisnicko = $korisnicko;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->lozinka = $lozinka;
        $this->tip = $tip;
        $this->prijavljen_od = time();
        $this->brojac = 0;
        $this->adresa = $_SERVER["REMOTE_ADDR"];
    }

    public function set_brojac($br) {
        $this->brojac = $br;
    }

    public function get_brojac() {
        return $this->brojac;
    }

    public function get_kor_ime() {
        return $this->korisnicko;
    }

    public function get_ime_prezime() {
        return $this->ime . " " . $this->prezime;
    }

    public function get_prezime() {
        return $this->prezime;
    }

    public function get_ime() {
        return $this->ime;
    }

    public function get_tip() {
        return $this->tip;
    }

    public function get_prijavljen_od() {
        return date("d.m.Y H:i:s", $this->prijavljen_od);
    }

    public function get_aktivan() {
        return time() - $this->prijavljen_od;
    }

    public function get_adresa() {
        return $this->adresa;
    }   
    
    public function get_id(){
        return $this->id;
    }
}

?>
