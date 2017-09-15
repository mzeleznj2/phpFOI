<?php
include('dbconnect.php');
include('zaglavlje.php');

PeriodAktivnosti($skripta);

if($_SESSION['strurl']!=basename($_SERVER['SCRIPT_NAME'])){
$_SESSION['sort']='';
$_SESSION['strurl']=basename($_SERVER['SCRIPT_NAME']);
}
DBConnect();

if(isset($_SESSION['knjiznice'])){
$sqlstr=$_SESSION['knjiznice'];		
}
else{
$sqlstr = "select idKnjiznica from knjiznica";

	if($aktivni_korisnik_tip==2){
		$sqlstr.=" where moderatorID = ".$aktivni_korisnik_id;	
	}

}
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);


if(isset($_SESSION['knjiznice'])){
$knjiznice=$_SESSION['knjiznice'];		
}
else{

$knjiznice = "select 
knj.idKnjiznica,
  knj.naziv,
  knj.adresa,
  knj.kapacitet,
  knj.slika,
  concat(kor.ime,' ',kor.prezime),
  knj.datAzur
from knjiznica knj, korisnik kor where knj.moderatorID = kor.idKorisnik";

if($aktivni_korisnik_tip==2){
	$knjiznice.=" and knj.moderatorID = ".$aktivni_korisnik_id;	
}

$_SESSION['url']='';

if(isset($_GET['sort'])){
	
	if($_GET['sort']=='kasc'){
		$_SESSION['sort']=" order by knj.kapacitet asc";
	}
	if($_GET['sort']=='kdesc'){
		$_SESSION['sort']=" order by knj.kapacitet desc";
	}
	if($_GET['sort']=='zasc'){
		$_SESSION['sort']=" order by concat(knj.naziv,', ',knj.adresa) asc";
	}
	if($_GET['sort']=='zdesc'){
		$_SESSION['sort']=" order by concat(knj.naziv,', ',knj.adresa) desc";
	}
	
	
	$_SESSION['url']=$_SERVER['QUERY_STRING'];
}
else
{
	if(!isset($_SESSION['sort'])){
	$_SESSION['sort']='';	
	}

}
$knjiznice.=$_SESSION['sort'];

}

$knjiznice.=" limit ".$velpod;

if(isset($_GET['stranica'])){
$knjiznice = $knjiznice . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
$aktivna = $_GET['stranica'];
}
else
{
$aktivna = 1;
}

echo "<h3 class='naslov'>";
if(isset($_SESSION['korime'])){
	echo "Vi ste: ".$_SESSION['korime'];
}
else
{
	echo "Niste prijavljeni";
}
echo "</h3>";

echo "<h2>Popis knjižnica:</h2>";
ZapisiUDnevnik("Ispis knjižnica",$skripta,$aktivni_korisnik_id);


echo "<form action='knjiznice.php' method='POST'>";
echo "<p>Upišite naziv: <input type='text' name='pojam' id='pojam' onkeyup=\"VratiTrazKnjiznice()\"></p>";
//echo "<p><input type='submit' class='gumb' name='statpretraga' value='Traži'>";
echo "</form>";

$qu = mysqli_query($dbc,$knjiznice);

	$up = "&#9650";
	$down = "&#9660";
	$nazup = "<a href='knjiznice.php?sort=zasc' title='Sort Ascending'>$up</a>";
	$nazdown = "<a href='knjiznice.php?sort=zdesc' title='Sort Descending'>$down</a>";
	$godup = "<a href='knjiznice.php?sort=kasc' title='Sort Ascending'>$up</a>";
	$goddown = "<a href='knjiznice.php?sort=kdesc' title='Sort Descending'>$down</a>";
	$tablica = "<div class='datagrid' id='datagrid'>";
	$tablica.="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th width='5%'>ID knjižnica</th><th>Naziv <br>$nazup $nazdown</th><th>Adresa</th><th>Kapacitet <br>$godup $goddown</th><th>Datum ažuriranja</th><th>Moderator</th>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<th>Radnja</th>";	
	}
	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($id,$naziv,$adresa,$kapacitet,$slika,$moderator,$datazur)=mysqli_fetch_array($qu)){
		$koord = vratiKordinate($adresa);
		//$koord = "45.8684944,16.1560165";
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
$tablica.="</div>";
echo $tablica;
if($aktivni_korisnik_tip==1){
	echo "<p><a href='knjiznica.php?unos=1'>Unos</a></p>";
	echo "<p><a href='knjiznica.php?unoscsv=1'>Unos csv datoteke</a></p>";
}
$imetbl = "tablica".$aktivna;
$_SESSION[$imetbl]=$tablica;


echo "<p><a href=\"$skripta?reset=1\">Reload</p>";	
echo "<p><a href=\"knjiznice.php?pdf=1&aktivna=$aktivna\" target=\"_blank\">Pretvori u pdf</p>";	
$_SESSION['skriptastat']=$skripta;
echo "<p><a href=\"statknjige.php\">Statistika posjećenosti stranice</a></p>";	


if(isset($_GET['reset'])){
	
	if(isset($_SESSION['knjiznice'])){
		unset($_SESSION['knjiznice']);		
	}
	header("Location: knjiznice.php");
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

$pdf->Write(0, 'Popis knjižnica', '', 0, 'L', true, 0, false, false, 0);

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