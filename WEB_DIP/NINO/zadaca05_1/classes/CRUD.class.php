<?php
/*
 * The MIT License
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
 * @author Jurica Ševa <jurica.seva@foi.hr>
 */
class CRUD {
    
    private static $korisnikID;
    private static $tipKorisnika;
    
    #IMENOVANJA
     public static $imena = array(
         'korisnici' => "Korisnici",
         'prijava' => "Prijava korisnika",
         'odjava' => "Odjava korisnika",
     );      
    
   function __construct($sesijaID='',$korisnikTip='') {       
       self::$korisnikID = $sesijaID;
       self::$tipKorisnika = $korisnikTip;
   }    
   
    
    function kreirajOkomitiMeni(){       
        
        $preskociDatoteke = Array("_footer.php","_header.php", "prijava.php","odjava.php","greske.php","aktivacija.php","registracija.php","editiraj.php","_headerHTML.php","_headerLogika.php","error.php");
        $dopušteniLinkovi = Array();
        $sadrzaj = glob("*.php");
        
        #neregistrirani korisnik
        if(self::$tipKorisnika == null){
            $dopušteniLinkovi = Array();
        }
        
        #običan korisnik
        if(self::$tipKorisnika == 1){
            $dopušteniLinkovi = Array("korisnici.php");
        }
        
        #moderator
        if(self::$tipKorisnika == 2){
            $dopušteniLinkovi = Array("korisnici.php");
        }
        
        #administrator
        if(self::$tipKorisnika == 3){
            $dopušteniLinkovi = array_merge($dopušteniLinkovi,$sadrzaj);
        }        
        
        #KREIRANJE IZBORNIKA ZA SVE FUNKCIONALNE PHP SKRIPTE
        #echo "Sesija: ".$sesijaID;
        $meni = "<nav id='meni'><ul>"
                . "<li class='active'><a href='index.php'>Početna stranica</a></li>";
        
        #DINAMIČNO GENERIRANJE IZBORNIKA SA POTREBNIM PREIMENOVANJIMA
        foreach($sadrzaj as $datoteka){
            if (!in_array($datoteka,$preskociDatoteke) && in_array($datoteka,$dopušteniLinkovi)){
            #if (!in_array($datoteka,$preskociDatoteke)){
                list($ime, $ekstenzija) = explode(".", $datoteka);
                (self::$tipKorisnika > 1 ) ? $meni .= "<li class='has-sub'>" : $meni .= "<li class='last'>";
                        $meni .= "<a href='{$datoteka}'><span>".self::$imena[$ime]."</span></a>";
                        if(self::$tipKorisnika > 1){
                        $meni .="<ul>"
                                    . "<li class='last'>"
                                        . "<a href='{$datoteka}?idAkcija=1'>Unesi novi podatak</a>"
                                    . "</li>"
                                . "</ul>";                        
                        }
                        $meni .= "</li>";                
            }            
        }
        
        (self::$tipKorisnika != null) ? $meni .= "<li class='active'><a href='odjava.php'>Odjava</a></li>" : $meni .= "<li class='active'><a href='prijava.php'>Prijava</a></li>";
        $meni .= "</nav>";
        echo $meni;
    }
    
    function kreirajTablicu($imeTablice,$status){
        $baza = new baza();
        #PRIKAZ PODATAKA IZ TABLICE, AKTIVNI I PASIVNI REDOVI
        $upit = "select * from $imeTablice where {$imeTablice}_status='{$status}'";
        $podaciTablica = $baza->selectDB($upit);
        
        if($podaciTablica->num_rows > 0){

        $tablica = "<table>";
        ($status == 1) ? $tablica .= "<caption>Aktivni redovi</caption>" : $tablica .= "<caption>Pasivni redovi</caption>";
        $tablica .= "<thead><tr><th>Ime</th><th>Prezime</th><th>Email</th><th>Detalji</th><th>Promijeni</th><th>Obriši</th></tr><thead><tbody>";
        
        while ($red = $podaciTablica->fetch_array()){
            #echo $red['korisnici_naziv'];
            $tablica .= "<tr>"
                    . "<td>{$red['korisnici_naziv']}</td>"
                    . "<td>{$red['korisnici_prezime']}</td>"
                    . "<td>{$red[2]}</td>"
                    . "<td><a href='detalji.php?idKorisnika={$red[0]}'>Detalji</a></td>";
                    
            (self::$tipKorisnika == 3  || self::$korisnikID == $red[0]) ? $tablica .= "<td><a href='editiraj.php?akcija=2&idKorisnika={$red[0]}'>Promijeni zapis</a></td>" : $tablica .= "<td></td>";
            
            (self::$tipKorisnika == 3 || self::$korisnikID == $red[0]) ? $tablica .= "<td><a href='editiraj.php?akcija={$status}&idKorisnika={$red[0]}'>Promijeni status</a></td>" : $tablica .= "<td></td>";
        }

        $tablica .= "</tbody></table>   ";

        echo $tablica; 
        }
    }
    
    function promijeniStanjeZapis($imeTablice,$idZapisa,$status){
        
        $baza = new baza();

        $upit = "UPDATE {$imeTablice} SET {$imeTablice}_status = '{$status}' where {$imeTablice}_id = '{$idZapisa}'";
        $baza->updateDB($upit, $imeTablice.".php");
    }
}

?>