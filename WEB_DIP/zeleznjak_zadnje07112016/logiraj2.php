<?php

session_start();

include('dbconnect.php');
// $BP_server = 'localhost';
// $BP_bazaPodataka = 'WebDiP2015x092';
// $BP_korisnik = 'WebDiP2015x092';
// $BP_lozinka = 'admin_hL7u';

	// $dbc = mysqli_connect($BP_server, $BP_korisnik, $BP_lozinka,$BP_bazaPodataka);
	// if(mysqli_connect_errno()) {
		// die('Pogreška! ' . mysqli_connect_error());		
	// }

	// mysqli_set_charset($dbc,"utf8");
	
DBConnect();	
$user = $_POST['korime'];
$pass = $_POST['sifra'];
$pass = md5($pass);
$upit = "select 
idKorisnik, korIme, ime, prezime, adresa, datRod, spol, email, idTip, status, slika
from korisnik where korIme = '$user' and sifra='$pass'";
$spremi = mysqli_query($dbc,$upit);
$red = mysqli_fetch_array($spremi);

$redovi = mysqli_num_rows($spremi);

	if($redovi>0){
				
			$id=$red['idKorisnik'];
			$korime=$red['korIme'];
			$ime = $red['ime'];
			$prezime = $red['prezime'];
			// $adresa = $red['adresa'];
			// $datRod = $red['datRod'];
			// $spol = $red['spol'];
			$email = $red['email'];
			$idTip = $red['idTip'];
			$slika = $red['slika'];
			$status = $red['status'];	
			
			if($status == 0){
				echo 'neakt';
			}
			else
			{
				echo 'true';
								
			}
			
			$_SESSION['idkorisnik']=$id;
			$_SESSION['korime']=$korime;
			$_SESSION['ime']=$ime;
			$_SESSION['prezime']=$prezime;
			$_SESSION['email']=$email;
			$_SESSION['idTip']=$idTip;
			$_SESSION['slika']=$slika;			
			$_SESSION['status']=$status;

			$dat="vrijeme.txt";
			$otvori = fopen($dat,'r');
			$vrijeme = trim(fgets($otvori));
			setcookie('Login',$korime,time()+$vrijeme);
			ZapisiPrijave($user,1);
		
		}
	else
	{
		echo 'false';
		ZapisiPrijave($user,0);
	}
	
	DBClose();
?>