<?php
ob_start();	
if(session_id()==""){
	session_start();
}
	$aktivni_korisnik=0;
	$aktivni_korisnik_id = 0;
	$aktivni_korisnik_tip=-1;
	if(isset($_SESSION['korime'])) {
		$aktivni_korisnik=$_SESSION['korime'];
		$aktivni_korisnik_ime=$_SESSION['ime']." ".$_SESSION['prezime'];
		$aktivni_korisnik_tip=$_SESSION['idTip'];
		$aktivni_korisnik_id = $_SESSION['idkorisnik'];
		$aktivni_korisnik_email = $_SESSION['email'];
		$slika=$_SESSION['slika'];
	}
	
?>
