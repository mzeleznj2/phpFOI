<?php

    include_once ("../okviri/baza.class.php");
    $baza=new Baza();
    
    $upit="select registracija from vozilo;";
    $podaci=$baza->selectDB($upit);
    
    $red=$podaci->fetch_array();
    $struktura="[\"".$red[0]."\"";
    while ($red=$podaci->fetch_array()){
            $struktura.=",\"".$red[0]."\"";
                   
    }
    $struktura.="]";
    
    echo $struktura;
?>