<?php
include('dbconnect.php');
include('zaglavlje.php');

PeriodAktivnosti($skripta);

if($_SESSION['strurl']!=basename($_SERVER['SCRIPT_NAME'])){
unset($_SESSION['dnevnik']);
$_SESSION['sort']='';
$_SESSION['strurl']=basename($_SERVER['SCRIPT_NAME']);
}
DBConnect();
$sqlstr = "select idKorisnik from korisnik";
if(isset($_POST['clanpretraga'])){
	$pojam=$_POST['pojam'];
	$sqlstr = $sqlstr." where ime like '%$pojam%' or prezime like '%$pojam%' or adresa like '%$pojam%'";
}
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);

$korisnici = "select 
idKorisnik, korIme, ime, prezime, adresa, datRod, spol, email, idTip, status, slika
from korisnik";
if(isset($_POST['clanpretraga'])){
	$pojam=$_POST['pojam'];
	$korisnici = $korisnici." where ime like '%$pojam%' or prezime like '%$pojam%' or adresa like '%$pojam%'";
}
if(isset($_GET['sort'])){
	
	if($_GET['sort']=='pasc'){
		$_SESSION['sort']=" order by prezime asc";
	}
	if($_GET['sort']=='pdesc'){
		$_SESSION['sort']=" order by prezime desc";
	}
	if($_GET['sort']=='dasc'){
		$_SESSION['sort']=" order by datRod asc";
	}
	if($_GET['sort']=='ddesc'){
		$_SESSION['sort']=" order by datRod desc";
	}
	
	
	$_SESSION['url']=$_SERVER['QUERY_STRING'];
}
else
{
	if(!isset($_SESSION['sort'])){
	$_SESSION['sort']='';	
	}

}
$korisnici.=$_SESSION['sort'];
$korisnici.=" limit ".$velpod;



if(isset($_GET['stranica'])){
$korisnici = $korisnici . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
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

echo "<h2>Ispis članova</h2>";
$qu = mysqli_query($dbc,$korisnici);


	$up = "&#9650";
	$down = "&#9660";
	$pup = "<a href='clanovi.php?sort=pasc' title='Sort Ascending'>$up</a>";
	$pdown = "<a href='clanovi.php?sort=pdesc' title='Sort Descending'>$down</a>";
	$datup = "<a href='clanovi.php?sort=dasc' title='Sort Ascending'>$up</a>";
	$datdown = "<a href='clanovi.php?sort=ddesc' title='Sort Descending'>$down</a>";
	echo "<form action='clanovi.php' method='POST'>";
echo "<p>Upišite ime, prezime ili adresu: <input type='text' name='pojam' id='pojam' onkeyup=\"VratiPopisClanova()\"></p>";
//echo "<p><input type='submit' name='clanpretraga' value='trazi'>";
echo "</form>";
	$tablica = "<div class='datagrid' id='datagrid'>";
	$tablica.="<table>";
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
if($aktivna != 1) { 
$prethodna = $aktivna - 1;
$tablica.="<li><a href=\"clanovi.php?stranica=" .$prethodna . "\"><span>Prethodna</span></a></li>";	
}
//$tablica.="<li><a href='#'><span>Prethodna</span></a></li>";
//$tablica.="<li><a href='#'><span>Stranice:</span></a></li>";
for($a=1;$a<=$br_strana;$a++){
	$tablica.="<li><a";
	if($aktivna==$a){
		$tablica.=" class='active'";
	}
	$tablica.=" href='clanovi.php?stranica=$a'>$a</a></li>";
}
if($aktivna < $br_strana){
$sljedeca = $aktivna + 1;
$tablica.="<li><a href=\"clanovi.php?stranica=" .$sljedeca . "\"><span>Slijedeća</span></a></li>";	
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

echo "<p><a href=\"clanovi.php?pdf=1&aktivna=$aktivna\" target=\"_blank\">Pretvori u pdf</a></p>";	
$_SESSION['skriptastat']=$skripta;
if($aktivni_korisnik_tip==1){
echo "<p><a href=\"statknjige.php\">Statistika posjećenosti stranice</a></p>";	
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