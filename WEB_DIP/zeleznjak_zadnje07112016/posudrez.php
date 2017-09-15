<?php
include('dbconnect.php');
include('zaglavlje.php');

PeriodAktivnosti($skripta);

if($_SESSION['strurl']!=basename($_SERVER['SCRIPT_NAME'])){
$_SESSION['sort']='';
$_SESSION['strurl']=basename($_SERVER['SCRIPT_NAME']);
}
DBConnect();
$korisniciArr = SviKorisnici();
$knjigeArr = PopisKnjiga();


if(isset($_GET['posudi'])){
	ZapisiUDnevnik("Knjiga posudjena",$skripta,$aktivni_korisnik_id);
	$id=$_GET['posudi'];
	$idknjiga=$_GET['knjiga'];
	$detalji = "select datumOd, datumDo from rezervacije where idRezervacija = ".$id;
	$ex2 = DBQuery($detalji);
	
	list($datumod,$datumdo)=mysqli_fetch_array($ex2);
	$datumPos=date("Y-m-d H:i:s");
	$posudi = "insert into posudbe values ('','$datumPos','$datumod','$datumdo',null,'$idknjiga','$aktivni_korisnik_id','$id')";
	$ex3 = DBQuery($posudi);
	
	$azurKnjiga = "update knjiga set brPosudbi = brPosudbi + 1, kolicina = kolicina - 1 where idKnjiga = ".$idknjiga;
	$ex3 = DBQuery($azurKnjiga);
	ZapisiUDnevnik("Ažurirana količina knjige za posudbu",$skripta,$aktivni_korisnik_id);
	
	header("Location: posudrez.php?posudbe=1");
}


if(isset($_GET['odobri'])){
	
	$id=$_GET['odobri'];
	$idkor=$_GET['kor'];
	$idknjiga=$_GET['knjiga'];
	
	$odobri = "update rezervacije set statusRez = 1 where idRezervacija = ".$id;
	$ex = DBQuery($odobri);
	
	$detalji = "select datumRez, datumOd, datumDo from rezervacije where idRezervacija = ".$id;
	$ex2 = DBQuery($detalji);
	
	list($datumRez,$datumod,$datumdo)=mysqli_fetch_array($ex2);
	
	$kordetalji = $korisniciArr[$idkor];
	$korisniknaziv = $kordetalji[1];
	$korisnikmail = $kordetalji[2];

	ZapisiUDnevnik("Posudba knjige odobrena",$skripta,$aktivni_korisnik_id);
	//print_r($korisniciArr);
	$naslov = "Potvrda o odobrenju rezervacije";
	$poruka = "Poštovana/i g. ".$korisniknaziv.",";
	$poruka.="<br/>Upravo vam je odobrena rezervacija pod brojem: ".$id;
	$poruka.="<br/>Knjiga: ".$knjigeArr[$idknjiga];
	$poruka.="<br/>Datum od: ".date("d.m.Y",strtotime($datumod));
	$poruka.="<br/>Datum do: ".date("d.m.Y",strtotime($datumdo));
	$razlika = strtotime($datumdo)-strtotime($datumod);
	$brdana = floor($razlika/(60*60*24));
	$poruka.="<br/>Broj dana: ".$brdana;
	$poruka.="<p>Možete kreirati posudbu!</p>";
	$poruka.="<p>S osobitim poštovanjem!</p>";
	
	MailRezervacija($naslov,$korisnikmail,$poruka);
	
	header("refresh: 1; url=posudrez.php");
	
}


if(isset($_GET['odbij'])){
	ZapisiUDnevnik("Rezervacija knjige odbijena",$skripta,$aktivni_korisnik_id);
	$id=$_GET['odbij'];
	$idkor=$_GET['kor'];
	$idknjiga=$_GET['knjiga'];
	
	$odobri = "update rezervacije set statusRez = 2 where idRezervacija = ".$id;
	$ex = DBQuery($odobri);
	
	$detalji = "select datumRez, datumOd, datumDo from rezervacije where idRezervacija = ".$id;
	$ex2 = DBQuery($detalji);
	
	list($datumRez,$datumod,$datumdo)=mysqli_fetch_array($ex2);
	
	$kordetalji = $korisniciArr[$idkor];
	$korisniknaziv = $kordetalji[1];
	$korisnikmail = $kordetalji[2];

	
	//print_r($korisniciArr);
	$naslov = "Potvrda o odbijanju rezervacije";
	$poruka = "Poštovana/i g. ".$korisniknaziv.",";
	$poruka.="<br/>Upravo vam je odbijena rezervacija pod brojem: ".$id;
	$poruka.="<br/>Knjiga: ".$knjigeArr[$idknjiga];
	$poruka.="<br/>Datum od: ".date("d.m.Y",strtotime($datumod));
	$poruka.="<br/>Datum do: ".date("d.m.Y",strtotime($datumdo));
	$razlika = strtotime($datumdo)-strtotime($datumod);
	$brdana = floor($razlika/(60*60*24));
	$poruka.="<br/>Broj dana: ".$brdana;
	$poruka.="<p>Možete pokušati sa nekom drugom rezervacijom!</p>";
	$poruka.="<p>S osobitim poštovanjem!</p>";
	
	MailRezervacija($naslov,$korisnikmail,$poruka);
	
	header("refresh: 1; url=posudrez.php");
	
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

if($_SERVER['QUERY_STRING']=="" || isset($_GET['rezervacije'])){
ZapisiUDnevnik("Ispis svih rezervacija",$skripta,$aktivni_korisnik_id);
$sqlstr = "select idRezervacija from rezervacije";
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);


$rezervacije = "select
  rez.idRezervacija,
rez.datumRez,
  rez.datumOd,
  rez.datumDo,
  rez.odobravatelj,
  case 
  when rez.statusRez = 0 then 'U obradi'
  when rez.statusRez = 1 then 'Odobrena'
  when rez.statusRez = 2 then 'Odbijena'
  end as 'status',
  
  DATEDIFF(rez.datumDo,rez.datumOd) as 'br_dana',
  knj.idKnjiga,
  knj.naziv,
  kat.zanr,
  kor.idKorisnik,
  concat(kor.ime,' ',kor.prezime)
from rezervacije rez, knjiga knj, kategorija kat, korisnik kor, knjiznica knjiz
where rez.idKnjiga = knj.idKnjiga
  and rez.idKorisnik = kor.idKorisnik
  and knj.kategorijaID = kat.idKategorija
  and kat.idKnjiznica = knjiz.idKnjiznica";
  
  if($aktivni_korisnik_tip==2){
  $rezervacije.=" and knjiz.moderatorID = ".$aktivni_korisnik_id;
  }
  if($aktivni_korisnik_tip==3){
	$rezervacije.=" and (kor.idKorisnik = ".$aktivni_korisnik_id." or rez.odobravatelj=".$aktivni_korisnik_id.")";
  }
$_SESSION['url']='';

if(isset($_GET['sort'])){
	
	if($_GET['sort']=='dasc'){
		$_SESSION['sort']=" order by rez.datumRez asc";
	}
	if($_GET['sort']=='ddesc'){
		$_SESSION['sort']=" order by rez.datumRez desc";
	}
	if($_GET['sort']=='kasc'){
		$_SESSION['sort']=" order by knj.naziv asc";
	}
	if($_GET['sort']=='kdesc'){
		$_SESSION['sort']=" order by knj.naziv desc";
	}
	
	ZapisiUDnevnik("Sortiranje ispisa rezervacija",$skripta,$aktivni_korisnik_id);
	$_SESSION['url']=$_SERVER['QUERY_STRING'];
}
else
{
	if(!isset($_SESSION['sort'])){
	$_SESSION['sort']='';	
	}

}
$rezervacije.=$_SESSION['sort'];
$rezervacije.=" limit ".$velpod;

if(isset($_GET['stranica'])){
$rezervacije = $rezervacije . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
$aktivna = $_GET['stranica'];
}
else
{
$aktivna = 1;
}
echo "<h2>Ispis rezervacija</h2>";
// echo "<br>Upit: ".$rezervacije;
// echo "<br>Aktivni kroisnik tip: ".$aktivni_korisnik_tip;

$qu = mysqli_query($dbc,$rezervacije);

	$up = "&#9650";
	$down = "&#9660";
	$datzup = "<a href='posudrez.php?sort=zasc' title='Sort Ascending'>$up</a>";
	$datdown = "<a href='posudrez.php?sort=zdesc' title='Sort Descending'>$down</a>";
	$knjup = "<a href='posudrez.php?sort=kasc' title='Sort Ascending'>$up</a>";
	$knjdown = "<a href='posudrez.php?sort=kdesc' title='Sort Descending'>$down</a>";
	$tablica = "<div class='datagrid'>";
	$tablica.="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th>ID rezervacije</th><th>Datum rezervacije <br>$datzup $datdown</th><th>Datum od</th><th>Datum do</th><th>Status</th><th>Broj dana</th><th>Knjiga <br>$knjup $knjdown</th>";
	$tablica.="<th>Žanr</th><th>Član</th>";

	$tablica.="<th>Radnja</th>";	

	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($id,$datumrez,$datumod,$datumdo,$odobravatelj,$status,$brdana,$idknjiga,$nazivknjiga,$zanr,$idclan,$imeclan)=mysqli_fetch_array($qu)){
		$datumrez=date("d.m.Y",strtotime($datumrez));
		$datumod=date("d.m.Y",strtotime($datumod));
		$datumdo=date("d.m.Y",strtotime($datumdo));
		$odobri = "<a href='posudrez.php?odobri=$id&kor=$idclan&knjiga=$idknjiga' title='Odobri'><img src='img/approve.png' width='16px' height='16px'></a>";
		$uri = $_SERVER['QUERY_STRING'];
		$odbij = "<a href='posudrez.php?odbij=$id&kor=$idclan&knjiga=$idknjiga' title='Odbij'><img src='img/delete.png' width='16px' height='16px'></a>";
		$posudi = "<a href='posudrez.php?posudi=$id&knjiga=$idknjiga' title='Posudi'><img src='img/borrow.png' width='25px' height='25px'></a>";

	$red++;
	if($red%2==0){
		$redclass="dark";
	}
	else
	{
		$redclass="light";
	}
	$tablica.="<tr class='$redclass'>";	
	$tablica.="<td>$id</td><td>$datumrez</td><td>$datumod</td><td>$datumdo</td><td title=\"$odobravatelj\">$status</td><td>$brdana</td><td>$nazivknjiga</td>";
	$tablica.="<td>$zanr</td><td>$imeclan</td>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<td>";
	if($status=="Odobrena"){
		$tablica.="$odbij";
	}
	elseif($status=="U obradi")
	{
	$tablica.="$odobri $odbij";	
	}
	else
	{
	$tablica.="$odobri";	
	}
	$tablica.="</td>";	
	}
	else
	{
		if($status=="Odobrena" && PostojanjeRezervacije($idclan,$idknjiga,"posudbe")==false && $idclan==$aktivni_korisnik_id){
			$tablica.="<td>$posudi</td>";
		}
		elseif($status=="Odobrena" && PostojanjeRezervacije($idclan,$idknjiga,"posudbe")==true)
		{
			$tablica.="<td>Posuđena";
					if($odobravatelj>0){
							$kordetalji = $korisniciArr[$odobravatelj];
							$korisniknaziv = $kordetalji[1];
		 $tablica.=" od ".$korisniknaziv;
		}
			$tablica.="</td>";
		}
		elseif($status=="U obradi" && ($odobravatelj!=null || $odobravatelj!="") && $idclan!=$aktivni_korisnik_id)
		{
			$tablica.="<td>$odobri $odbij</td>";
		}
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
$tablica.="<li><a href=\"posudrez.php?stranica=" .$prethodna . "\"><span>Prethodna</span></a></li>";	
}
//$tablica.="<li><a href='#'><span>Prethodna</span></a></li>";
//$tablica.="<li><a href='#'><span>Stranice:</span></a></li>";
for($a=1;$a<=$br_strana;$a++){
	$tablica.="<li><a";
	if($aktivna==$a){
		$tablica.=" class='active'";
	}
	$tablica.=" href='posudrez.php?stranica=$a'>$a</a></li>";
}
if($aktivna < $br_strana){
$sljedeca = $aktivna + 1;
$tablica.="<li><a href=\"posudrez.php?stranica=" .$sljedeca . "\"><span>Slijedeća</span></a></li>";	
}
$tablica.="</ul>";
$tablica.="</div>";
$tablica.="</td>";
$tablica.="</tr>";
$tablica.="</tfoot>";	
$tablica.="</table>";
$tablica.="</div>";

echo $tablica;
}


if(isset($_GET['posudbe'])){
	
ZapisiUDnevnik("Ispis svih posudbi",$skripta,$aktivni_korisnik_id);

$sqlstr = "select idPosudba from posudbe";
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);


$posudbe = "select
  pos.idPosudba,
  pos.datumPosudbe,
  pos.datumOd,
  pos.datumDo,
  DATEDIFF(pos.datumDo,pos.datumOd) as 'br_dana',
  knj.idKnjiga,
  knj.naziv,
  kat.zanr,
  kor.idKorisnik,
  concat(kor.ime,' ',kor.prezime)
from posudbe pos, knjiga knj, kategorija kat, korisnik kor, knjiznica knjiz
where pos.idKnjiga = knj.idKnjiga
  and pos.idKorisnik = kor.idKorisnik
  and knj.kategorijaID = kat.idKategorija
  and kat.idKnjiznica = knjiz.idKnjiznica";
  
    if($aktivni_korisnik_tip==2){
  $posudbe.=" and knjiz.moderatorID = ".$aktivni_korisnik_id;
  }
  // if($aktivni_korisnik_tip==3){
	// $posudbe.=" and kor.idKorisnik = ".$aktivni_korisnik_id;
  // }
$_SESSION['url']='';

if(isset($_GET['sort'])){
	
	if($_GET['sort']=='dasc'){
		$_SESSION['sort']=" order by pos.datumPosudbe asc";
	}
	if($_GET['sort']=='ddesc'){
		$_SESSION['sort']=" order by pos.datumPosudbe desc";
	}
	if($_GET['sort']=='kasc'){
		$_SESSION['sort']=" order by knj.naziv asc";
	}
	if($_GET['sort']=='kdesc'){
		$_SESSION['sort']=" order by knj.naziv desc";
	}
	
	
	$_SESSION['url']=$_SERVER['QUERY_STRING'];
}
else
{
	if(!isset($_SESSION['sort'])){
	$_SESSION['sort']='';	
	}

}
$posudbe.=$_SESSION['sort'];
$posudbe.=" limit ".$velpod;

if(isset($_GET['stranica'])){
$posudbe = $posudbe . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
$aktivna = $_GET['stranica'];
}
else
{
$aktivna = 1;
}
echo "<h2>Popis posudbi:</h2>";
//echo "<br>Upit: ".$posudbe;
$qu = mysqli_query($dbc,$posudbe);

	$up = "&#9650";
	$down = "&#9660";
	$datzup = "<a href='posudrez.php?sort=zasc' title='Sort Ascending'>$up</a>";
	$datdown = "<a href='posudrez.php?sort=zdesc' title='Sort Descending'>$down</a>";
	$knjup = "<a href='posudrez.php?sort=kasc' title='Sort Ascending'>$up</a>";
	$knjdown = "<a href='posudrez.php?sort=kdesc' title='Sort Descending'>$down</a>";
	$tablica = "<div class='datagrid'>";
	$tablica.="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th>ID posudbe</th><th>Datum posudbe <br>$datzup $datdown</th><th>Datum od</th><th>Datum do</th><th>Broj dana</th><th>Knjiga <br>$knjup $knjdown</th>";
	$tablica.="<th>Žanr</th><th>Posudio Član</th>";
//	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<th>Radnja</th>";	
	$tablica.="<th>Status knjige</th>";	
//	}
	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($id,$datumrez,$datumod,$datumdo,$brdana,$idknjiga,$nazivknjiga,$zanr,$idclan,$imeclan)=mysqli_fetch_array($qu)){
		$datumrez=date("d.m.Y",strtotime($datumrez));
		$datumod=date("d.m.Y",strtotime($datumod));
		$datumdo=date("d.m.Y",strtotime($datumdo));
		$odobri = "<a href='posudrez.php?odobri=$id&kor=$idclan&knjiga=$idknjiga' title='Odobri'><img src='img/approve.png' width='16px' height='16px'></a>";
		$uri = $_SERVER['QUERY_STRING'];
		$odbij = "<a href='posudrez.php?odbij=$id' title='Odbij'><img src='img/delete.png' width='16px' height='16px'></a>";
		
		$rez = "<a href='knjiga.php?rezerviraj=$idknjiga&odobravatelj=$idclan' title='Rezerviraj'><img src='img/reserve.png' width='16px' height='16px'></a>";
		$rezotk = "<a href='knjiga.php?rezotkazi=$id' title='Otkaži rezervaciju'><img src='img/cancel.png' width='16px' height='16px'></a>";

	$red++;
	if($red%2==0){
		$redclass="dark";
	}
	else
	{
		$redclass="light";
	}
	$tablica.="<tr>";	
	$tablica.="<td>$id</td><td>$datumrez</td><td>$datumod</td><td>$datumdo</td><td>$brdana</td><td>$nazivknjiga</td>";
	$tablica.="<td>$zanr</td><td>$imeclan</td>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<td>";
	$tablica.="$odobri $odbij";
	$tablica.="</td>";	
	}
	if($aktivni_korisnik_tip==3 && (PostojanjeRezervacije($aktivni_korisnik_id,$idknjiga,"rezervacije")==false) && ($aktivni_korisnik_id!=$idclan)){
	$tablica.="<td>";
	$tablica.="$rez";
	$tablica.="</td>";	
	}
	else
	{
		$tablica.="<td>Posudjena";

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

}

$imetbl = "tablica".$aktivna;
$_SESSION[$imetbl]=$tablica;

echo "<p><a href=\"posudrez.php?pdf=1&aktivna=$aktivna\" target=\"_blank\">Pretvori u pdf</p>";	
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

$pdf->Write(0, 'Popis posudbi/rezervacija', '', 0, 'L', true, 0, false, false, 0);

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
include('podnozje.php');
DBClose();
?>