<?php
include('session.php');
include('dbconnect.php');
if(isset($_SESSION['dnevnik'])){
unset($_SESSION['dnevnik']);		
}
$kor=$_GET['pojam'];

$skr = $_SESSION['skriptastat'];

DBConnect();
$sqlstr = "select dn.idDnevnik, dn.datumVrijeme, dn.poruka, dn.skripta, kor.korIme from dnevnik dn, korisnik kor
where dn.idKorisnik = kor.idKorisnik and dn.skripta = '$skr' and kor.korIme like '$kor'";
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);

$_SESSION['brstrana']=$br_strana;

$dnevnik = "select dn.idDnevnik, dn.datumVrijeme, dn.poruka, dn.skripta, kor.korIme from dnevnik dn, korisnik kor
where dn.idKorisnik = kor.idKorisnik and dn.skripta = '$skr' and kor.korIme like '$kor'";
$_SESSION['dnevnik']=$dnevnik;
$dnevnik.=" limit ".$velpod;

if(isset($_GET['stranica'])){
$dnevnik = $dnevnik . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
$aktivna = $_GET['stranica'];
}
else
{
$aktivna = 1;
}

$qu = mysqli_query($dbc,$dnevnik);

	$tablica="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th width='5%'>ID dnevnik</th><th>Datum i vrijeme</th><th>Poruka</th><th>Skripta</th><th>Korisnik</th>";

	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($id,$datum,$poruka,$skripta,$korisnik)=mysqli_fetch_array($qu)){		
	$datum = date("d.m.Y H:i:s",strtotime($datum));
	$tablica.="<tr>";	
	$tablica.="<td>$id</td><td>$datum</td><td>$poruka</td><td>$skripta</td><td>$korisnik</td>";
	$tablica.="</tr>";
	}
$tablica.="</tbody>";
$tablica.="<tfoot>";
$tablica.="<tr>";
$tablica.="<td colspan='5'>";
$tablica.="<div id=\"paging\">";
$tablica.="<ul>";
$tablica.="<li>";
if($aktivna != 1) { 
$prethodna = $aktivna - 1;
$tablica.="<li><a href=\"statknjige.php?stranica=" .$prethodna . "\"><span>Prethodna</span></a></li>";	
}
//$tablica.="<li><a href='#'><span>Prethodna</span></a></li>";
//$tablica.="<li><a href='#'><span>Stranice:</span></a></li>";
for($a=1;$a<=$br_strana;$a++){
	$tablica.="<li><a";
	if($aktivna==$a){
		$tablica.=" class='active'";
	}
	$tablica.=" href='statknjige.php?stranica=$a'>$a</a></li>";
}
if($aktivna < $br_strana){
$sljedeca = $aktivna + 1;
$tablica.="<li><a href=\"statknjige.php?stranica=" .$sljedeca . "\"><span>Slijedeća</span></a></li>";	
}
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