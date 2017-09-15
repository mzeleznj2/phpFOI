<?php 
    include_once ("okviri/baza.class.php");
    include_once ("okviri/korisnik.class.php");
    include_once ("okviri/postavi_vrijeme.php");
    $baza=new Baza();
    $korisnik=new Korisnik();
    
    session_start();
    if (!isset($_SESSION["prijava"])) {
        header("Location: zabranjeno.php?e=2");
        exit();
    }
    $korisnik=$_SESSION["prijava"];
    $id=$korisnik->get_id();
    
    $upit="select pomak from pomak;";
    $podaci=$baza->selectDB($upit);
    $red=$podaci->fetch_array();
    $vrijeme_servera = time();

    $vrijeme_sustava = $vrijeme_servera + ($red[0] * 60 * 60); 
    $vrijeme=date('Y-m-d H:i:s', $vrijeme_sustava);
    $upit="insert into prijava VALUES('default','$id','6','$vrijeme');";
    $baza->updateDB($upit);
    
    unset($_SESSION["prijava"]);  
    session_destroy();

    header("Location: prijava.php");

?>
