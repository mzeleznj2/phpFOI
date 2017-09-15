<?php
include('session.php');
include('dbconnect.php');

$pojam=$_GET['pojam'];

DBConnect();
$sqlstr = "select idKorisnik from korisnik where ime like '%$pojam%' or prezime like '%$pojam%' or adresa like '%$pojam%'";
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);

$_SESSION['brstrana']=$br_strana;

$korisnici = "select idKorisnik, korIme, ime, prezime, adresa, datRod, spol, email, idTip, status, slika from korisnik where ime like '%$pojam%' or prezime like '%$pojam%' or adresa like '%$pojam%'";

$qu = mysqli_query($dbc,$korisnici);

	$up = "&#9650";
	$down = "&#9660";
	$pup = "<a href='clanovi.php?sort=pasc' title='Sort Ascending'>$up</a>";
	$pdown = "<a href='clanovi.php?sort=pdesc' title='Sort Descending'>$down</a>";
	$datup = "<a href='clanovi.php?sort=dasc' title='Sort Ascending'>$up</a>";
	$datdown = "<a href='clanovi.php?sort=ddesc' title='Sort Descending'>$down</a>";
	$tablica ="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th>ID kor</th><th>Korisničko ime</th><th>Ime</th><th>Prezime</th><th>Adresa</th><th>Datum</th><th>E-mail</th>";
	$tablica.="<th>Tip</th>";
	$tablica.="<th>Status</th>";
	if($aktivni_korisnik_tip==1){
	$tablica.="<th>Radnja</th>";	
	}
	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($id,$korime,$ime,$prezime,$adresa,$datum,$spol,$email,$tip,$status,$slika)=mysqli_fetch_array($qu)){
		$datum = date("d.m.Y",strtotime($datum));
		$azur = "<a href='clan.php?azuriraj=$id'><img src='img/update.png' width='16px' height='16px' title='Ažuriraj'></a>";
		$brisi = "<a href='#' onclick=\"ProvjeraBrisanjaKorisnika('$id','$korime')\"><img src='images/delete.png' width='16px' height='16px' title='Briši'></a>";
		$akt = "<a href='clan.php?user=$korime&akt=1'><img src='img/activate.png' width='16px' height='16px' title='Aktiviraj račun'></a>";
		$deakt = "<a href='clan.php?deakt=$id'><img src='img/deactivate.png' width='16px' height='16px' title='Deaktiviraj račun'></a>";
		if($tip==1){
			$tip="Administrator";
		}
		elseif($tip==2){
			$tip="Moderator";
		}
		else
		{
			$tip="Član";
		}
		
		if($status==1){
			$stat="Aktivan";
		}
		else
		{
			$stat="Neaktivan";
		}
	$red++;
	if($red%2==0){
		$redclass="dark";
	}
	else
	{
		$redclass="light";
	}
	$tablica.="<tr>";	
	$tablica.="<td>$id</td><td>$korime</td><td>$ime</td><td>$prezime</td><td>$adresa</td><td>$datum</td><td>$email</td>";
	$tablica.="<td>$tip</td><td>$stat</td>";
	if($aktivni_korisnik_tip==1){
	$tablica.="<td>";
	$tablica.="$azur $brisi";
	if($status==0){
		$tablica.="$akt";
	}
	else
	{
		$tablica.="$deakt";
	}
	$tablica.="</td>";	
	}
	$tablica.="</tr>";
	}
$tablica.="</tbody>";
$tablica.="<tfoot>";
$tablica.="<tr>";
$tablica.="<td colspan='11'>";
$tablica.="<div id=\"paging\">";
$tablica.="<ul>";
$tablica.="<li>";
// if($aktivna != 1) { 
// $prethodna = $aktivna - 1;
// $tablica.="<li><a href=\"kategorije.php?stranica=" .$prethodna . "\"><span>Prethodna</span></a></li>";	
// }
////$tablica.="<li><a href='#'><span>Prethodna</span></a></li>";
////$tablica.="<li><a href='#'><span>Stranice:</span></a></li>";
// for($a=1;$a<=$br_strana;$a++){
	// $tablica.="<li><a";
	// if($aktivna==$a){
		// $tablica.=" class='active'";
	// }
	// $tablica.=" href='kategorije.php?stranica=$a'>$a</a></li>";
// }
// if($aktivna < $br_strana){
// $sljedeca = $aktivna + 1;
// $tablica.="<li><a href=\"kategorije.php?stranica=" .$sljedeca . "\"><span>Slijedeća</span></a></li>";	
// }
$tablica.="</li>";
$tablica.="</ul>";
$tablica.="</div>";
$tablica.="</td>";
$tablica.="</tr>";
$tablica.="</tfoot>";	
$tablica.="</table>";
echo $tablica;
DBClose();
?>