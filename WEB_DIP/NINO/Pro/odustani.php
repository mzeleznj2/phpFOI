<?php
    include_once ("okviri/baza.class.php");
    $baza=new Baza();
    
    $kod=$_REQUEST["karta"];
    
    if($kod==-1){
        header("Location: unosKazna.php");
        exit();
    }
    
    $upit="DELETE FROM  karta  WHERE  kod='$kod';";
    $baza->updateDB($upit);
    header("Location: kupnja.php");
?>