<?php
include('dbconnect.php');
include('zaglavlje.php');

PeriodAktivnosti($skripta);

if($_SERVER['QUERY_STRING']==""){

if($_SESSION['strurl']!=basename($_SERVER['SCRIPT_NAME'])){
$_SESSION['sort']='';
$_SESSION['strurl']=basename($_SERVER['SCRIPT_NAME']);
}

}
DBConnect();


// if($_SERVER['QUERY_STRING']==""){

echo "<h3 class='naslov'>";
if(isset($_SESSION['korime'])){
	echo "Vi ste: ".$_SESSION['korime'];
	//echo "<span class='slika'><img src=".$_SESSION['slika']."></span>";
}
else
{
	echo "Niste prijavljeni";
}
echo "</h3>";

echo "<h2>Ispis sadržaja</h2>";

$skripta=basename($_SERVER['SCRIPT_NAME']);
ZapisiUDnevnik("Ispis knjiga",$skripta,$aktivni_korisnik_id);

$sqlstr = "select idKnjiga from knjiga";
if(isset($_SESSION['idknjiz'])){
	
	$sqlstr .= " where kategorijaID in (select idKategorija from kategorija where idKnjiznica=".$_SESSION['idknjiz'].")";
}

if(isset($_POST['knjigapretraga']) && isset($_SESSION['idknjiz'])){
	$pojam=$_POST['pojam'];
	$sqlstr = $sqlstr." and naziv like '%$pojam%' or autor like '%$pojam%' or opis like '%$pojam%'";
}

if(isset($_POST['knjigapretraga']) && !isset($_SESSION['idknjiz'])){
	$pojam=$_POST['pojam'];
	$sqlstr = $sqlstr." where naziv like '%$pojam%' or autor like '%$pojam%' or opis like '%$pojam%'";
}

$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);


$knjige = "select 
idKnjiga, naziv, ISBN, autor, izdavac, godina, brStranica, kolicina, brPosudbi, opis, slika
from knjiga ";
$_SESSION['url']='';

if(isset($_SESSION['idknjiz'])){
	
	$knjige .= " where kategorijaID in (select idKategorija from kategorija where idKnjiznica=".$_SESSION['idknjiz'].")";
	$skripta=basename($_SERVER['SCRIPT_NAME']);
	ZapisiUDnevnik("Ispis knjiga iz odabrane knjižnice ",$skripta,$aktivni_korisnik_id);
}

if(isset($_POST['knjigapretraga']) && isset($_SESSION['idknjiz'])){
	$pojam=$_POST['pojam'];
	$knjige = $knjige." and naziv like '%$pojam%' or autor like '%$pojam%' or opis like '%$pojam%'";
}

if(isset($_POST['knjigapretraga']) && !isset($_SESSION['idknjiz'])){
	$pojam=$_POST['pojam'];
	$knjige = $knjige." where naziv like '%$pojam%' or autor like '%$pojam%' or opis like '%$pojam%'";
}

if(isset($_GET['sort'])){
	
	if($_GET['sort']=='nasc'){
		$_SESSION['sort']=" order by naziv asc";
	}
	if($_GET['sort']=='ndesc'){
		$_SESSION['sort']=" order by naziv desc";
	}
	if($_GET['sort']=='gasc'){
		$_SESSION['sort']=" order by godina asc";
	}
	if($_GET['sort']=='gdesc'){
		$_SESSION['sort']=" order by godina desc";
	}
	
	
	$_SESSION['url']=$_SERVER['QUERY_STRING'];
}
else
{
	if(!isset($_SESSION['sort'])){
	$_SESSION['sort']='';	
	}

}
$knjige.=$_SESSION['sort'];
$knjige.=" limit ".$velpod;

if(isset($_GET['stranica'])){
$knjige = $knjige . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
$aktivna = $_GET['stranica'];
}
else
{
$aktivna = 1;
}
if(isset($_SESSION['idknjiz'])){
	
	echo "<h2>Gledate popis knjiga iz knjižnice ".$_SESSION['nazivknjiz'].", ".$_SESSION['adresaknjiz'];
}

echo "<form action='knjige.php' method='POST'>";
echo "<p>Upišite naziv ili autora knjige: <input type='text' name='pojam' id='pojam' onkeyup=\"VratiPopisKnjiga()\"></p>";
//echo "<p><input type='submit' class='gumb' name='knjigapretraga' value='Traži'>";
echo "</form>";
//echo "<br>Upit: ".$knjige;
$qu = mysqli_query($dbc,$knjige);

	$up = "&#9650";
	$down = "&#9660";
	$nazup = "<a href='knjige.php?sort=nasc' title='Sort Ascending'>$up</a>";
	$nazdown = "<a href='knjige.php?sort=ndesc' title='Sort Descending'>$down</a>";
	$godup = "<a href='knjige.php?sort=gasc' title='Sort Ascending'>$up</a>";
	$goddown = "<a href='knjige.php?sort=gdesc' title='Sort Descending'>$down</a>";
	$tablica = "<div class='datagrid' id='datagrid'>";
	$tablica.="<table>";
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
if($aktivna != 1) { 
$prethodna = $aktivna - 1;
$tablica.="<li><a href=\"knjige.php?stranica=" .$prethodna . "\"><span>Prethodna</span></a></li>";	
}
for($a=1;$a<=$br_strana;$a++){
	$tablica.="<li><a";
	if($aktivna==$a){
		$tablica.=" class='active'";
	}
	$tablica.=" href='knjige.php?stranica=$a'>$a</a></li>";
}
if($aktivna < $br_strana){
$sljedeca = $aktivna + 1;
$tablica.="<li><a href=\"knjige.php?stranica=" .$sljedeca . "\"><span>Slijedeća</span></a></li>";	
}
$tablica.="</ul>";
$tablica.="</div>";
$tablica.="</td>";
$tablica.="</tr>";
$tablica.="</tfoot>";	
$tablica.="</table>";
$tablica.="</div>";
echo $tablica;

$imetbl = "tablica".$aktivna;
$_SESSION[$imetbl]=$tablica;
if($aktivni_korisnik_tip==1){
	echo "<p><a href='knjiga.php?unos=1'>Unos</a></p>";
	
}

echo "<p><a href=\"knjige.php?pdf=1&aktivna=$aktivna\" target=\"_blank\">Pretvori u pdf</a></p>";	
$_SESSION['skriptastat']=$skripta;
if($aktivni_korisnik_tip==1){
echo "<p><a href=\"statknjige.php\">Statistika posjećenosti stranice</a></p>";	
}


if(isset($_GET['statistika'])){
	
	
}

if(isset($_GET['pdf'])){
	ob_clean();
	require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Nicola Asuni');
// $pdf->SetTitle('TCPDF Example 048');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->Write(0, 'Popis korisnika', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------
if(session_id()==""){
session_start();	
}

$ime="tablica".$_GET['aktivna'];

if(isset($_SESSION[$ime])){
	$tabla = $_SESSION[$ime];
	unset($_SESSION[$ime]);
	unset($_SESSION['aktivna']);
}


$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3</td>
        <td>COL 2 - ROW 1</td>
        <td>COL 3 - ROW 1</td>
    </tr>
    <tr>
        <td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
        <td>COL 3 - ROW 2</td>
    </tr>
    <tr>
       <td>COL 3 - ROW 3</td>
    </tr>

</table>
EOD;



$pdf->writeHTML($tabla, true, false, false, false, ''); $naziv=str_replace("php","pdf",$skripta);


// -----------------------------------------------------------------------------
error_reporting(E_ALL);
//Close and output PDF document
$pdf->Output("$naziv", 'I');
}
DBClose();
include('podnozje.php');
?>