<?php

    include_once ("../okviri/baza.class.php");
    $baza=new Baza();
    
    $upit="select ime, prezime from korisnik;";
    $podaci=$baza->selectDB($upit);
    
    $red=$podaci->fetch_array();
    $struktura="[\"".$red[0]." ".$red[1]."\"";
    while ($red=$podaci->fetch_array()){
            $struktura.=",\"".$red[0]." ".$red[1]."\"";
                   
    }
    $struktura.="]";
    
    echo $struktura;
?>