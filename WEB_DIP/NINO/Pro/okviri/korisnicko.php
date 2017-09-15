<?php

    include_once ("../okviri/baza.class.php");
    $baza=new Baza();
    
    $upit="select korisnicko from korisnik;";
    $podaci=$baza->selectDB($upit);
    
    $korisnik = $_GET['korisnik'];
    $postoji = 0;
    
    while ($red=$podaci->fetch_array()){
        if ($red[0] == $korisnik) {
			$postoji = 1;
		}        
    }
	header("Content-Type:application/xml");
	echo '<?xml version="1.0" encoding="utf-8"?><korisnici>';
	echo "<korisnik>$postoji</korisnik>";
	echo "</korisnici>";
	
?>