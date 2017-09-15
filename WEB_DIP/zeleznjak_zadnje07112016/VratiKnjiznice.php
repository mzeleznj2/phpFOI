<?php
include('session.php');
include('dbconnect.php');
if(isset($_SESSION['dnevnik'])){
unset($_SESSION['dnevnik']);		
}
$pojam=$_GET['pojam'];

$skr = $_SESSION['skriptastat'];

DBConnect();


$sqlstr = "select 
knj.idKnjiznica,
  knj.naziv,
  knj.adresa,
  knj.kapacitet,
  knj.slika,
  concat(kor.ime,' ',kor.prezime),
  knj.datAzur
from knjiznica knj, korisnik kor where knj.moderatorID = kor.idKorisnik and knj.naziv like '%$pojam%'";

if($aktivni_korisnik_tip==2){
	$sqlstr.=" and knj.moderatorID = ".$aktivni_korisnik_id;	
}

$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);

$_SESSION['brstrana']=$br_strana;

$knjiznice = "select 
knj.idKnjiznica,
  knj.naziv,
  knj.adresa,
  knj.kapacitet,
  knj.slika,
  concat(kor.ime,' ',kor.prezime),
  knj.datAzur
from knjiznica knj, korisnik kor where knj.moderatorID = kor.idKorisnik and knj.naziv like '%$pojam%'";

if($aktivni_korisnik_tip==2){
	$knjiznice.=" and knj.moderatorID = ".$aktivni_korisnik_id;	
}


$_SESSION['knjiznice']=$knjiznice;
$knjiznice.=" limit ".$velpod;

if(isset($_GET['stranica'])){
$knjiznice = $knjiznice . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
$aktivna = $_GET['stranica'];
}
else
{
$aktivna = 1;
}
//echo "<br>Knjiznice: ".$knjiznice;
$qu = mysqli_query($dbc,$knjiznice);

	$tablica="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th width='5%'>ID knjižnica</th><th>Naziv</th><th>Adresa</th><th>Kapacitet</th><th>Datum ažuriranja</th><th>Moderator</th>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<th>Radnja</th>";	
	}
	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($id,$naziv,$adresa,$kapacitet,$slika,$moderator,$datazur)=mysqli_fetch_array($qu)){
		//$koord = vratiKordinate($adresa);
		$koord = "45.8684944,16.1560165";
		$dimenzije = explode(",",$koord);
		$long = $dimenzije[0];
		$lat = $dimenzije[1];
		$datazur=date("d.m.Y H:i:s",strtotime($datazur));
		$azur = "<a href='knjiznica.php?azuriraj=$id'><img src='img/update.png' width='16px' height='16px'></a>";
		$gmap = "<a href='lokacija.php?long=$long&lat=$lat' target='_blank'><img src='img/gmap.png' width='16px' height='16px'></a>";
		$uri = $_SERVER['QUERY_STRING'];
		$brisi = "<a href='#' onclick=\"ProvjeraBrisanjaKategorije('$id','$naziv','$uri')\"><img src='img/delete.png' width='16px' height='16px'></a>";

	$red++;
	if($red%2==0){
		$redclass="dark";
	}
	else
	{
		$redclass="light";
	}
	$tablica.="<tr>";	
	$tablica.="<td>$id</td><td>$naziv</td><td>$adresa</td><td>$kapacitet</td><td>$datazur</td><td>$moderator</td>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<td>";
	$tablica.="$azur $brisi $gmap";
	$tablica.="</td>";	
	}
	else
	{
	$tablica.="<td>";
	$tablica.="$gmap";
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
if($aktivna != 1) { 
$prethodna = $aktivna - 1;
$tablica.="<li><a href=\"knjiznice.php?stranica=" .$prethodna . "\"><span>Prethodna</span></a></li>";	
}
for($a=1;$a<=$br_strana;$a++){
	$tablica.="<li><a";
	if($aktivna==$a){
		$tablica.=" class='active'";
	}
	$tablica.=" href='knjiznice.php?stranica=$a'>$a</a></li>";
}
if($aktivna < $br_strana){
$sljedeca = $aktivna + 1;
$tablica.="<li><a href=\"knjiznice.php?stranica=" .$sljedeca . "\"><span>Slijedeća</span></a></li>";	
}
$tablica.="</ul>";
$tablica.="</div>";
$tablica.="</td>";
$tablica.="</tr>";
$tablica.="</tfoot>";	
$tablica.="</table>";
echo $tablica;
DBClose();
?>