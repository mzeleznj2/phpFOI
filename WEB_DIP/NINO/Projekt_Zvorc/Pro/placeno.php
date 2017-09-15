<?php

    include_once ("okviri/baza.class.php");
    include_once ("okviri/korisnik.class.php");
    include_once ("okviri/meni.php");
    include_once ("okviri/postavi_vrijeme.php");
    
    $baza=new Baza();
    $korisnik=new Korisnik();
    
    session_start();
    if (!isset($_SESSION["prijava"])) {
        header("Location: zabranjeno.php?e=2");
        exit();
    }
    $korisnik=$_SESSION["prijava"];
    $tip=$korisnik->get_tip();
    $imeprezime=$korisnik->get_ime_prezime();
    $id=$korisnik->get_id();
    
    $idkarte=$_REQUEST["kod"];
    
    $upit="select pomak from pomak;";
    $podaci=$baza->selectDB($upit);
    $red=$podaci->fetch_array();
    $vrijeme_servera = time();

    $vrijeme_sustava = $vrijeme_servera + ($red[0] * 60 * 60);
    $placeno=date('Y-m-d', $vrijeme_sustava);
    
    $upit="UPDATE kazna SET placeno = '$placeno' WHERE idkazne ='$idkarte';";
    if(!$baza->updateDB($upit)){
        echo "Greska";
    }
    
    $vrijeme=date('Y-m-d H:i:s');
    $upit="insert into prijava VALUES('default','$id','5','$vrijeme');";
    $baza->updateDB($upit);
    
     header("Location: uspjesno.php?e=2");
?>

