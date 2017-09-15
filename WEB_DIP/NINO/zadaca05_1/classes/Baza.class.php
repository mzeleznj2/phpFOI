<?php
/*
 * The MIT License
 *
 * Copyright 2014 Jurica Ševa <jurica.seva@foi.hr>.
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
 * Klasa za rad s bazom podataka
 *
 * @author Jurica Ševa <jurica.seva@foi.hr>
 */

class baza {
    
    /*
     *Podaci za spajanje na bazu LOKALNO
     */
    const server = "localhost";
    const baza = "WebDiP2013";
    const korisnik = "WebDiP2013";
    const lozinka = "adminWebDiP";    
    
    /*  PODACI ZA ARKU
     * 
     *  const server = "localhost";
     *  const baza = "WebDiP2013";
     *  const korisnik = "WebDiP2013";
     *  const lozinka = "adminWebDiP";   
     */
    
    /*
     * FUNKCIJE BAZE
     */
    function spojiDB(){        
        /*
        *Spajanje na bazu
        */
        
        $mysqli = new mysqli(self::server, self::korisnik, self::lozinka, self::baza);
        if ($mysqli->connect_errno) {
            echo "Neuspješno spajanje na bazu: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            #header redirekt na upravljanje greškama;
        }
        return $mysqli;
     
    }
    
    function prekiniDB($veza){
         /*
        *Prekidanje veze prema bazi
        */
        $veza->close();
        
    }

    function selectDB($upit){
        /*
         * Pokriva operacije select koji vraćaju određeni broj redova iz baze
         * Vraća se podatak formata resultset
         */
        #$veza = $this->spojiDB();
        $veza = self::spojiDB();
        $rezultat = $veza->query($upit) or trigger_error("Greška kod upita: {$upit} - Greška: ".$veza->error.''.E_USER_ERROR);
        
        if(!$rezultat){
            $rezultat = null;
        }
        
        self::prekiniDB($veza);
        return $rezultat;
    }    
    
    function updateDB($upit, $skripta=''){
        /*
         * Pokriva operacije insert, update, delete koji ne zathijevaju povrat rezultata upita iz baze već samo verifikaciju uspjeha operacije
         */
        $veza = self::spojiDB();
        if ($rezultat = $veza->query($upit)) {           
            #printf("Vraćeno redova %d rows.\n", $rezultat->num_rows);
            /* free result set */
            self::prekiniDB($veza);
            #$veza->close();
            if ($skripta != ''){
                header("Location: {$skripta}");
            } else {
                return $rezultat;
            }
            
        } else {
            echo "Pogreška: ".$veza->error;
            self::prekiniDB($veza);
            return $rezultat;
        }        
     
    }

}

?>