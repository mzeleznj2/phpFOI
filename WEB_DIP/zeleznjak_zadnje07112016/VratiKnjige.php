<?php
include('session.php');
include('dbconnect.php');

$pojam=$_GET['pojam'];

DBConnect();
$sqlstr = "select idKnjiga from knjiga where naziv like '%$pojam%' or autor like '%$pojam%' or opis like '%$pojam%'";
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);

$_SESSION['brstrana']=$br_strana;

$knjige = "select 
idKnjiga, naziv, ISBN, autor, izdavac, godina, brStranica, kolicina, brPosudbi, opis, slika
from knjiga where naziv like '%$pojam%' or autor like '%$pojam%' or opis like '%$pojam%'";

$qu = mysqli_query($dbc,$knjige);

	$up = "&#9650";
	$down = "&#9660";
	$nazup = "<a href='knjige.php?sort=nasc' title='Sort Ascending'>$up</a>";
	$nazdown = "<a href='knjige.php?sort=ndesc' title='Sort Descending'>$down</a>";
	$godup = "<a href='knjige.php?sort=gasc' title='Sort Ascending'>$up</a>";
	$goddown = "<a href='knjige.php?sort=gdesc' title='Sort Descending'>$down</a>";
	$tablica="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th>ID knjiga</th><th>Naziv $nazup $nazdown</th><th>ISBN</th><th>Autor</th><th>Izdavač</th><th>Godina $godup $goddown</th><th>Broj strana</th>";
	$tablica.="<th>Količina</th><th>Posudbe</th>";
	//$tablica.="<th>Slika</th>";
	$tablica.="<th>Radnja</th>";	
	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($id,$naziv,$isbn,$autor,$izdavac,$godina,$brstr,$kolicina,$posudbe,$opis,$slika)=mysqli_fetch_array($qu)){
		$azur = "<a href='knjiga.php?azuriraj=$id'><img src='img/update.png' width='16px' height='16px'></a>";
		$uri = $_SERVER['QUERY_STRING'];
		$brisi = "<a href='#' onclick=\"ProvjeraBrisanjaKnjige('$id','$naziv','$uri')\"><img src='img/delete.png' width='16px' height='16px'></a>";
		
		$rez = "<a href='knjiga.php?rezerviraj=$id' title='Rezerviraj'><img src='img/reserve.png' width='16px' height='16px'></a>";
		$rezotk = "<a href='knjiga.php?rezotkazi=$id' title='Otkaži rezervaciju'><img src='img/cancel.png' width='16px' height='16px'></a>";
		$pos = "<a href='knjiga.php?posudi=$id'><img src='img/update.png' width='16px' height='16px'></a>";
		echo "<span id='pop-up' style='position: absolute; display:none;'><img src='$slika'/></span>";
		if(ProvjeriLike($aktivni_korisnik_id,$id,"statknjiga",1)==true){
			$like = "<img src='img/like.png' width='16px' height='16px'>";
			$unlike = "<a href='knjiga.php?unlike=$id' title='Ne sviđa mi se'><img src='img/unlike.png' width='16px' height='16px'></a>";
		}
		elseif(ProvjeriLike($aktivni_korisnik_id,$id,"statknjiga",0)==true){
			$like = "<a href='knjiga.php?like=$id' title='Sviđa mi se'><img src='img/like.png' width='16px' height='16px'></a>";
			$unlike = "<img src='img/unlike.png' width='16px' height='16px'>";
		}
		else
		{
			$like = "<a href='knjiga.php?like=$id&prvi=1' title='Sviđa mi se'><img src='img/like.png' width='16px' height='16px'></a>";
			$unlike = "<a href='knjiga.php?unlike=$id&prvi=1' title='Ne sviđa mi se'><img src='img/unlike.png' width='16px' height='16px'></a>";;
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
	$tablica.="<td>$id</td><td><a href='#' id='image'>$naziv</a></td><td>$isbn</td><td>$autor</td><td>$izdavac</td><td>$godina</td><td>$brstr</td>";
	$tablica.="<td>$kolicina</td><td>$posudbe</td>";
	//$tablica.="<td><img src='$slika'></td>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<td>";
	$tablica.="$azur $brisi $like $unlike";
	$tablica.="</td>";	
	}
	else
	{
		$tablica.="<td>";
		if(PostojanjeRezervacije($aktivni_korisnik_id,$id,"rezervacije")==true){
		
		$tablica.="$rezotk";
		}
		else
		{

		$tablica.="$rez";
			
		}	
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