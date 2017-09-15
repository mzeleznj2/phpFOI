<?php
include('session.php');
include('dbconnect.php');

$pojam=$_GET['pojam'];

DBConnect();
$sqlstr = "select idKategorija from kategorija where zanr like '%$pojam%'";
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);

$_SESSION['brstrana']=$br_strana;

$kategorije = "select 
kat.idKategorija,
  kat.zanr,
  kat.datAzur,
  concat(knjig.naziv,', ',knjig.adresa)
from kategorija kat, knjiznica knjig where kat.idKnjiznica = knjig.idKnjiznica and kat.zanr like '%$pojam%'";

$qu = mysqli_query($dbc,$kategorije);

	$up = "&#9650";
	$down = "&#9660";
	$nazup = "<a href='kategorije.php?sort=zasc' title='Sort Ascending'>$up</a>";
	$nazdown = "<a href='kategorije.php?sort=zdesc' title='Sort Descending'>$down</a>";
	$godup = "<a href='kategorije.php?sort=kasc' title='Sort Ascending'>$up</a>";
	$goddown = "<a href='kategorije.php?sort=kdesc' title='Sort Descending'>$down</a>";
	$tablica="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th>ID kategorija</th><th>Naziv <br>$nazup $nazdown</th><th>Datum ažuriranja</th><th>Knjižnica <br>$godup $goddown</th>";
	$tablica.="<th>Radnja</th>";	
	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($id,$naziv,$datazur,$knjiznica)=mysqli_fetch_array($qu)){
		$datazur=date("d.m.Y H:i:s",strtotime($datazur));
		$azur = "<a href='kategorija.php?azuriraj=$id'><img src='img/update.png' width='16px' height='16px'></a>";
		$uri = $_SERVER['QUERY_STRING'];
		$brisi = "<a href='#' onclick=\"ProvjeraBrisanjaKategorije('$id','$naziv','$uri')\"><img src='img/delete.png' width='16px' height='16px'></a>";
		if(ProvjeriLike($aktivni_korisnik_id,$id,"statkategorija",1)==true){
			$like = "<img src='img/like.png' width='16px' height='16px'>";
			$unlike = "<a href='kategorija.php?unlike=$id' title='Ne sviđa mi se'><img src='img/unlike.png' width='16px' height='16px'></a>";
		}
		elseif(ProvjeriLike($aktivni_korisnik_id,$id,"statkategorija",0)==true){
			$like = "<a href='kategorija.php?like=$id' title='Sviđa mi se'><img src='img/like.png' width='16px' height='16px'></a>";
			$unlike = "<img src='images/unlike.png' width='16px' height='16px'>";
		}
		else
		{
			$like = "<a href='kategorija.php?like=$id&prvi=1' title='Sviđa mi se'><img src='img/like.png' width='16px' height='16px'></a>";
			$unlike = "<a href='kategorija.php?unlike=$id&prvi=1' title='Ne sviđa mi se'><img src='img/unlike.png' width='16px' height='16px'></a>";;
		};

	$tablica.="<tr>";	
	$tablica.="<td>$id</td><td>$naziv</td><td>$datazur</td><td>$knjiznica</td>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<td>";
	$tablica.="$azur $brisi $like $unlike";
	$tablica.="</td>";	
	}
	else
	{
	$tablica.="<td>";
    $tablica.="$like $unlike";
	$tablica.="</td>";	
	}
	$tablica.="</tr>";
	}
$tablica.="</tbody>";
$tablica.="<tfoot>";	
$tablica.="<tr>";
$tablica.="<td colspan='11'>";
$tablica.="<div id=\"paging\">";
// $tablica.="<ul>";
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
// $tablica.="</ul>";
$tablica.="</div>";
$tablica.="</td>";
$tablica.="</tr>";
$tablica.="</tfoot>";	
$tablica.="</table>";
echo $tablica;
DBClose();
?>