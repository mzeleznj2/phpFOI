<?php
// include("zaglavlje.php");
include("dbconnect.php");
// $skripta=basename($_SERVER['SCRIPT_NAME']);
if(session_id()==""){
	session_start();
}

DBConnect();
$user = $_POST['korime'];
$pass = $_POST['sifra'];
$pass = md5($pass);
$upit = "select 
idKorisnik, korIme, ime, prezime, adresa, datRod, spol, email, idTip, status, slika
from korisnik where korIme = '$user' and sifra='$pass'";
$spremi = mysqli_query($dbc,$upit);
$red = mysqli_fetch_array($spremi);
//$redovi = $red[0];
$redovi = mysqli_num_rows($spremi);
//echo "<br>Redovi: ".$redovi;
//if($spremi){
//echo 'true';
	if($redovi>0){
		
		//while(list($id,$korime,$ime,$prezime,$email,$status, $rola)=mysqli_fetch_array($spremi)){
		list($id,$korime,$ime,$prezime,$adresa,$datrod,$spol,$email,$idTip, $status, $slika)=mysqli_fetch_array($spremi);
		// $idkorisnik = $red['idKorisnik'];
		// ZapisiUDnevnik("Korisnik logiran",$skripta,$idkorisnik);
		// $korime = $red['korIme'];
		// $ime = $red['ime'];
		// $prezime = $red['prezime'];
		// $adresa = $red['adresa'];
		// $datRod = $red['datRod'];
		// $spol = $red['spol'];
		// $email = $red['email'];
		// $idTip = $red['idTip'];
		// $slika = $red['slika'];
		// $status = $red['status'];
		// if($status == 0){
		// $poruka = "Vaš račun nije još aktiviran!";
		// ZapisiUDnevnik("Korisniku ".$korime." nije aktiviran račun",$skripta,$idkorisnik);
		// poruka($poruka);
		 //header("refresh: 1; url=index.php");
		// return false;
		// }
		// else
		// {
			//echo "<br>Redovi33: ".$redovi;
			$_SESSION['idkorisnik']=$id;
			$_SESSION['korime']=$korime;
			$_SESSION['ime']=$ime;
			$_SESSION['prezime']=$prezime;
			$_SESSION['email']=$email;
			$_SESSION['idTip']=$idTip;
			$_SESSION['slika']=$slika;
			echo 'true';
			// $dat="vrijeme.txt";
			// $otvori = fopen($dat,'r');
			// $vrijeme = trim(fgets($otvori));
			// setcookie('Login',$korime,time()+$vrijeme);
			// ZapisiPrijave($user,1);
			// echo "<br>Vi ste: ".$_SESSION['korime'];
			// header("Location: index.php");
			//echo "<br>Redovi: ".$redovi;
		// }
		
		}
		
	//}
	else
	{
		echo 'false';
	}
//}
// else
// {	
	// header("Location: index.php");
	// die("pogreška!".mysqli_error($dbc));
// }

// if($redovi==0)
// {
	// header("Location: index.php");
// $poruka = "Pogrešni podaci!";
// poruka($poruka);
// ZapisiPrijave($user,0);
// }
DBClose();
?>