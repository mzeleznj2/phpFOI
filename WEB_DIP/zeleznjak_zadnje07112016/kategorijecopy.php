
<?php
include('dbconnect.php');
include('zaglavlje.php');

PeriodAktivnosti($skripta);

if($_SESSION['strurl']!=basename($_SERVER['SCRIPT_NAME'])){
$_SESSION['sort']='';
$_SESSION['strurl']=basename($_SERVER['SCRIPT_NAME']);
}
$_SESSION['uriparams']=$_SERVER['REQUEST_URI'];
// echo "<br>URL: ".$_SESSION['strurl'];
// echo "<br>Skripta: ".basename($_SERVER['SCRIPT_NAME']);

DBConnect();
$sqlstr = "select idKategorija from kategorija";
if(isset($_POST['katpretraga'])){
	$pojam=$_POST['pojam'];
	$sqlstr = $sqlstr." where zanr like '%$pojam%'";
}
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);

$_SESSION['brstrana']=$br_strana;

//echo "<br>Redovi: ".$redovi;
$kategorije = "select 
kat.idKategorija,
  kat.zanr,
  kat.datAzur,
  concat(knjig.naziv,', ',knjig.adresa)
from kategorija kat, knjiznica knjig where kat.idKnjiznica = knjig.idKnjiznica";

if(isset($_POST['katpretraga'])){
	$pojam=$_POST['pojam'];
	$kategorije = $kategorije." and kat.zanr like '%$pojam%'";
}
$_SESSION['url']='';

if(isset($_GET['sort'])){
	
	if($_GET['sort']=='zasc'){
		$_SESSION['sort']=" order by kat.zanr asc";
	}
	if($_GET['sort']=='zdesc'){
		$_SESSION['sort']=" order by kat.zanr desc";
	}
	if($_GET['sort']=='kasc'){
		$_SESSION['sort']=" order by concat(knjig.naziv,', ',knjig.adresa) asc";
	}
	if($_GET['sort']=='kdesc'){
		$_SESSION['sort']=" order by concat(knjig.naziv,', ',knjig.adresa) desc";
	}
	
	
	$_SESSION['url']=$_SERVER['QUERY_STRING'];
}
else
{
	if(!isset($_SESSION['sort'])){
	$_SESSION['sort']='';	
	}

}
$kategorije.=$_SESSION['sort'];
$kategorije.=" limit ".$velpod;

if(isset($_GET['stranica'])){
$kategorije = $kategorije . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
$aktivna = $_GET['stranica'];
}
else
{
$aktivna = 1;
}
$_SESSION['aktivna']=$aktivna;
echo "<h3 class='naslov'>";
if(isset($_SESSION['korime'])){
	echo "Vi ste: ".$_SESSION['korime'];
}
else
{
	echo "Niste prijavljeni";
}
echo "</h3>";

echo "<h2>Ispis kategorija</h2>";
echo "<form action='kategorije.php' method='POST'>";
echo "<p>Upišite žanr: <input type='text' name='pojam' id='pojam' onkeyup=\"VratiPopisKategorija()\"></p>";
echo "<p><input type='submit' class='gumb' name='katpretraga' value='Traži'>";
echo "</form>";
$qu = mysqli_query($dbc,$kategorije);

	$up = "&#9650";
	$down = "&#9660";
	$nazup = "<a href='kategorije.php?sort=zasc' title='Sort Ascending'>$up</a>";
	$nazdown = "<a href='kategorije.php?sort=zdesc' title='Sort Descending'>$down</a>";
	$godup = "<a href='kategorije.php?sort=kasc' title='Sort Ascending'>$up</a>";
	$goddown = "<a href='kategorije.php?sort=kdesc' title='Sort Descending'>$down</a>";
	$tablica = "<div class='datagrid'>";
	$tablica.="<table>";
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
$tablica.="<ul>";
if($aktivna != 1) { 
$prethodna = $aktivna - 1;
$tablica.="<li><a href=\"kategorije.php?stranica=" .$prethodna . "\"><span>Prethodna</span></a></li>";	
}
//$tablica.="<li><a href='#'><span>Prethodna</span></a></li>";
//$tablica.="<li><a href='#'><span>Stranice:</span></a></li>";
for($a=1;$a<=$br_strana;$a++){
	$tablica.="<li><a";
	if($aktivna==$a){
		$tablica.=" class='active'";
	}
	$tablica.=" href='kategorije.php?stranica=$a'>$a</a></li>";
}
if($aktivna < $br_strana){
$sljedeca = $aktivna + 1;
$tablica.="<li><a href=\"kategorije.php?stranica=" .$sljedeca . "\"><span>Slijedeća</span></a></li>";	
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
	echo "<p><a href='kategorija.php?unos=1'>Unos</a></p>";
}

echo "<p><a href='kategorije.php?pdf=1&aktivna=$aktivna' target='_blank'>Pretvori u pdf</a></p>";	
$_SESSION['skriptastat']=$skripta;
echo "<p><a href=\"statknjige.php\">Statistika posjećenosti stranice</a></p>";	

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

$pdf->Write(0, 'Popis kategorija', '', 0, 'L', true, 0, false, false, 0);

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