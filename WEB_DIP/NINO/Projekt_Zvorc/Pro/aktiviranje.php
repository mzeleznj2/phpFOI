<?php

    include_once ("okviri/baza.class.php");
    $baza=new Baza();
    
    $kor=$_REQUEST["kor"];    
    $upit="select ime, prezime, vrijeme from korisnik WHERE idkorisnika ='$kor';";
    $podaci=$baza->selectDB($upit);
    if($podaci){
        $red=$podaci->fetch_array();
        $ime=$red[0];
        $prezime=$red[1];                
    }
    else{
        header("Location: zabranjeno.php?e=2");
        exit();
    }
    
    $upit="UPDATE korisnik SET aktivan = '1', kod = '0' WHERE idkorisnika ='$kor';";
    if(!$baza->updateDB($upit)){
        echo "Greska";
    }
        
    header("Location: uspjesno.php?e=3");
    exit();    
?>


