<?php
/*
 * The MIT License
 *
 * Copyright 2014 Matija Novak <matija.novak@foi.hr>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * Klasa za upravljanje sa sesijama
 *
 * @author Matija Novak <matija.novak@foi.hr>
 */
class Sesija {

    const ID = "ID";
    const MAIL = "mail";
    const KOR_IME = "username";
    const IME = "ime";
    const PREZIME = "prezime";
    const TIP = "tip";
    const SESSION_NAME = "prijava_sesija";

    static function kreirajSesiju($id, $kor_ime, $ime, $prezime, $mail, $tip) {
        session_name(self::SESSION_NAME);

        /*
         * RADI NA PHP >= 5.4
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
         * 
         */
        
        if(session_id() == ""){
            session_start();
        }

        $_SESSION[self::ID] = $id;
        $_SESSION[self::MAIL] = $mail;
        $_SESSION[self::KOR_IME] = $kor_ime;
        $_SESSION[self::IME] = $ime;
        $_SESSION[self::PREZIME] = $prezime;
        $_SESSION[self::TIP] = $tip;
    }

    /**
     * @return ID logiranog korisnika ili null ako nema sesije 
     */
    static function provjeriSesiju() {
        session_name(self::SESSION_NAME);

        /*
         * RADI NA PHP >= 5.4
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
         * 
         */
        
        if(session_id() == ""){
            session_start();
        }

        if (isset($_SESSION[self::ID])) {
            $id = $_SESSION[self::ID];
        } else {
            return null;
        }
        return $id;
    }

    /**
     * Odjavljuje korisnika tj. briše sesiju
     */
    static function obrisiSesiju() {
        session_name(self::SESSION_NAME);

        /*
         * RADI NA PHP >= 5.4
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
         * 
         */
        
        if(session_id() == ""){
            session_start();
        }
        
        session_unset();
        session_destroy();
    }
    
    

}
