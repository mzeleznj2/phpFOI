﻿
<?php
include('dbconnect.php');
include('zaglavlje.php');

PeriodAktivnosti($skripta);
if($_SESSION['strurl']!=basename($_SERVER['SCRIPT_NAME'])){
$_SESSION['sort']='';
$_SESSION['strurl']=basename($_SERVER['SCRIPT_NAME']);
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

$skr = $_SESSION['skriptastat'];
echo "<h2>Ispis statistike posjećenosti za skriptu ".$skr."</h2>";

echo "<form action='statknjige.php' method='POST'>";
echo "<p>Upišite korisnika: <input type='text' name='korisnik' id='korisnik' onkeyup=\"VratiStatistike()\"></p>";
//echo "<p><input type='submit' class='gumb' name='statpretraga' value='Traži'>";
echo "</form>";
DBConnect();


if(isset($_SESSION['dnevnik'])){
$sqlstr=$_SESSION['dnevnik'];		
}
else{
$sqlstr = "select dn.idDnevnik, dn.datumVrijeme, dn.poruka, dn.skripta, kor.korIme from dnevnik dn, korisnik kor
where dn.idKorisnik = kor.idKorisnik and dn.skripta = '$skr'";
}

// if(isset($_POST['statpretraga'])){
	// $kor = $_POST['korisnik'];
	// $sqlstr.=" and kor.korIme like '$kor'";
// }
//echo "<br>Upit: ".$sqlstr;
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);


if(isset($_SESSION['dnevnik'])){
$dnevnik=$_SESSION['dnevnik'];		
}
else{
$dnevnik = "select dn.idDnevnik, dn.datumVrijeme, dn.poruka, dn.skripta, kor.korIme from dnevnik dn, korisnik kor
where dn.idKorisnik = kor.idKorisnik and dn.skripta = '$skr'";	
}

$_SESSION['url']='';

if(isset($_GET['sort'])){
	
	if($_GET['sort']=='zasc'){
		$_SESSION['sort']=" order by dn.datumVrijeme asc";
	}
	if($_GET['sort']=='zdesc'){
		$_SESSION['sort']=" order by dn.datumVrijeme desc";
	}
	
	
	$_SESSION['url']=$_SERVER['QUERY_STRING'];
}
else
{
	if(!isset($_SESSION['sort'])){
	$_SESSION['sort']='';	
	}

}

$dnevnik.=$_SESSION['sort'];


$dnevnik.=" limit ".$velpod;

if(isset($_GET['stranica'])){
$dnevnik = $dnevnik . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
$aktivna = $_GET['stranica'];
}
else
{
$aktivna = 1;
}
//echo "<br>Upit: ".$dnevnik;
$qu = mysqli_query($dbc,$dnevnik);
	$up = "&#9650";
	$down = "&#9660";
	$nazup = "<a href='statknjige.php?sort=zasc' title='Sort Ascending'>$up</a>";
	$nazdown = "<a href='statknjige.php?sort=zdesc' title='Sort Descending'>$down</a>";
	
	$tablica = "<div class='datagrid' id='datagrid'>";
	$tablica.="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th width='5%'>ID dnevnik</th><th>Datum i vrijeme $nazup $nazdown</th><th>Poruka</th><th>Skripta</th><th>Korisnik</th>";

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
if($aktivna != 1) { 
$prethodna = $aktivna - 1;
$tablica.="<li><a href=\"statknjige.php?stranica=" .$prethodna . "\"><span>Prethodna</span></a></li>";	
}
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

echo "<p><a href=\"$skripta?reset=1\">Reload</p>";	
echo "<p><a href=\"$skripta?pdf=1&aktivna=$aktivna\" target=\"_blank\">Pretvori u pdf</p>";	

if(isset($_GET['reset'])){
	
	if(isset($_SESSION['dnevnik'])){
		unset($_SESSION['dnevnik']);		
	}
	header("Location: statknjige.php");
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

$pdf->Write(0, 'Popis aktivnosti iz dnevnika', '', 0, 'L', true, 0, false, false, 0);

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