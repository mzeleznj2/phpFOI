<?php
function autentikacija($user, $pass) {

    $result = -1;
    $dbc = pripremiBazuPodataka();

    $sql = "select korisnici_id, korisnici_prezime, korisnici_naziv, korisnici_lozinka, tipkorisnika_id FROM korisnici where korisnici_email = '$user' and korisnici_status='1'";
    #echo $sql."<br />";
        
    $rs = $dbc->query($sql);
    
    if (!$rs) {
        trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }

    $broj = $rs->num_rows;
    #echo $broj;
    
    $korisnik = new Korisnik();

    if ($broj == 1) {
        list($id, $prezime, $ime, $lozinka, $vrsta) = $rs->fetch_array();
        
        #echo "$id, $prezime, $ime, $lozinka, $vrsta";

        if ($lozinka == $pass) {
            $korisnik->set_podaci($id, $user, $ime, $prezime, $lozinka, $vrsta);

            $result = 1;
        } else {
            $result = 0;
        }
    } else {
        $result = -1;
    }

    $korisnik->set_status($result);

    $dbc->close();

    return $korisnik;
}
?>
