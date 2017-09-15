<?php
define('ADMINISTRATOR', '0');
define('KORISNIK', '1');

$bp_server = 'localhost';
$bp_korisnik = 'WebDiP2013';
$bp_lozinka = 'adminWebDiP';
$bp_baza = 'WebDiP2013';
$bp_znakovi = 'utf8';

function pripremiBazuPodataka() {
    global $bp_server, $bp_korisnik, $bp_lozinka, $bp_baza, $bp_znakovi;

    $dbc = new mysqli($bp_server, $bp_korisnik, $bp_lozinka, $bp_baza);
    if (!$dbc) {
        trigger_error("Problem kod povezivanja na bazu podataka!", E_USER_ERROR);
    }
    
   $dbc->set_charset($bp_znakovi);    
   
   return $dbc;
}
?>