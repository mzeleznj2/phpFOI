<?php

    include_once ("okviri/korisnik.class.php");  
    include_once ("okviri/meni.php");  
    include_once ("okviri/postavi_vrijeme.php");
    $korisnik=new Korisnik();
    
    session_start();
    if (!isset($_SESSION["prijava"])) {
        header("Location: zabranjeno.php?e=2");
        exit();
    }
    $korisnik=$_SESSION["prijava"];
    $tip=$korisnik->get_tip();
    $imeprezime=$korisnik->get_ime_prezime();
    
    if ($tip>1) {
        header("Location: zabranjeno.php?e=2");
        exit();
    }
    
    spremi_uDB();
    header("Location: promjena_vremena.php");
    

?>