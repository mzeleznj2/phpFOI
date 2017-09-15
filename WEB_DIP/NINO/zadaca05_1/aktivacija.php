<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'classes/Baza.class.php';

#objekti za bazu i forme
$baza = new baza();

if(isset($_GET['kljuc'])){
    $kljuc = mysql_escape_string($_GET['kljuc']);
    $upit = "update korisnici set korisnici_status = 1 where korisnici_email= '{$kljuc}'";
    #echo $upit."<br />";
    $rezultat = $baza::updateDB($upit);
    if ($rezultat){
        header("Location: korisnici.php");
    } else {   
        header("Location: greska.php?idGreske=2");
    }
    
} else {
    header("Location: registracija.php");
}
?>