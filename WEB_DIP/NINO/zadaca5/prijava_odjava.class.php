<?php


class PrijavaOdjava{
    
    const ID = "ID";
    const MAIL = "mail";
    const KOR_IME = "username";
    const IME = "ime";
    const PREZIME = "prezime";
    const TIP = "tip";
    const SESSION_NAME = "prijava_sesija";

    function validacija($kor, $loz){
        $result = -1;
        $baza=new Baza();

        $upit = "select idkorisnika, ime, prezime, lozinka, email, tip FROM korisnik where korisnicko = '$kor' and aktivan='1';";
        $rezultat = $baza->selectDB($upit);

        if (!$rezultat) {
            trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
        }

        $broj = $rezultat->num_rows;
        $korisnik = new Korisnik();
        
        if ($broj == 1) {
            list($id, $ime, $prezime, $lozinka, $email, $vrsta) = $rezultat->fetch_array();
            
            if ($lozinka == $loz) {
                $korisnik->set_podaci($id, $kor, $ime, $prezime, $lozinka, $vrsta);
                $result = 1;
            } 
            else {
                $result = 0;
            }
        } else {
            $result = -1;
        }

        $korisnik->set_status($result);
        return $korisnik;
    }
    
    function kreiranjeSesije($id, $mail, $kor_ime, $ime, $prezime, $tip){
        session_name(self::SESSION_NAME);
        
        if(session_id() == ""){
            session_start();
        }
        $_SESSION[self::ID] = $id;
        $_SESSION[self::MAIL] = $mail;
        $_SESSION[self::KOR_IME] = $kor_ime;
        $_SESSION[self::IME] = $ime;
        $_SESSION[self::PREZIME] = $prezime;
        $_SESSION[self::TIP] = $tip;
        return;
    }
    
    function brisanjeSesije(){
        session_name(self::SESSION_NAME);

        if(session_id() == ""){
            session_start();
        }
        
        session_unset();
        session_destroy();
    }
             
}

?>