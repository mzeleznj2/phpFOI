<?php

class Baza{
    const server="localhost";
    const baza="WebDiP2013_096";
    const korisnik="WebDiP2013_096";
    const lozinka="admin_sYKk";
    
    function spojiDB(){
        $mysqli= new mysqli(self::server, self::korisnik,  self::lozinka, self::baza);
        if($mysqli->connect_errno){
            $poruka="GRESKA: BAZA -> Neuspjesno spajanje na bazu: ". $mysqli->connect_errno.", ". $mysqli->connect_error;
            header("Location: greske.php?pogreska=$poruka");
        }
        return $mysqli;
    }
    
    function selectDB($upit){
        $veza =  self::spojiDB();
        $rezultat = $veza->query($upit) or trigger_error("Greska kod upita {$upit} - ".
                "Greska: ".$veza->error." ".E_USER_ERROR);
        if(!$rezultat){
            $rezultat=null;
        }
        $veza->close();
        return $rezultat;
    }
    
    function updateDB($upit){        
        $veza = self::spojiDB();
        if($rezultat=$veza->query($upit)){
            $veza->close(); 
            return $rezultat;
        }
        else{
            $veza->close();
            return null;
        }              
    }
}

?>
