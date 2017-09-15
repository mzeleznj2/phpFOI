<?php

include('session.php');
include('dbconnect.php');
//include('zaglavlje.php');
DBConnect();

	//ZapisiUDnevnik("Unos/ažuriranje knjižnica",$skripta,$aktivni_korisnik_id);
	$idKnjiz = $_GET['knjiz'];
	
		$upit = "select idKnjiznica, naziv, adresa from knjiznica where idKnjiznica = '$idKnjiz'";
		$ex = DBQuery($upit);

		if($ex){
		list($id,$naziv,$adresa)=mysqli_fetch_array($ex);

		$_SESSION['idknjiz']=$id;
		$_SESSION['nazivknjiz']=$naziv;
		$_SESSION['adresaknjiz']=$adresa;

		//echo "<a href=\"#\"><strong>Knjižnica:</strong>".$_SESSION['nazivknjiz'].", ".$_SESSION['adresaknjiz']."</a>";
		
		}
		else
		{
			die("greska: ".mysqli_error($dbc));
		}
	
	
	//echo $upit;
DBClose();
?>