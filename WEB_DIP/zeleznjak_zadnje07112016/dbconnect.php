<?php
$skripta=basename($_SERVER['SCRIPT_NAME']);
$BP_server = 'localhost';
$BP_bazaPodataka = 'WebDiP2015x092';
$BP_korisnik = 'WebDiP2015x092';
$BP_lozinka = 'admin_hL7u';
$dbc = null;
$db = null;

function DBConnect() {
	global $dbc;
	global $db;
	global $BP_server;
	global $BP_bazaPodataka;
	global $BP_korisnik;
	global $BP_lozinka;

	$dbc = mysqli_connect($BP_server, $BP_korisnik, $BP_lozinka,$BP_bazaPodataka);
	if(mysqli_connect_errno()) {
		die('Pogreška! ' . mysqli_connect_error());		
	}

	mysqli_set_charset($dbc,"utf8");
}

function DBQuery($sql) {
	global $dbc;
	$rs = mysqli_query($dbc,$sql);
	if(! $rs) {
		die('Pogreška! ' . mysqli_error($dbc));
	}
	return $rs;
}
	
function DBClose(){
	global $dbc;
	if(is_resource($dbc)){
	mysqli_close($dbc);
	}
}


function poruka($poruka){
	
	echo "<script>";
	echo "alert('$poruka')";
	echo "</script>";
}

function ZapisiPrijave($idKor,$uspj){
global $dbc;
DBConnect();

$dosad = "select uspjesno, datumPrijave from prijave where korime = '$idKor' order by datumPrijave desc limit 4";
$spremi = mysqli_query($dbc,$dosad);
$neuspjesnih=0;//brojac neuspjesnih prijava...
while(list($uspjesno,$datPrijave)=mysqli_fetch_array($spremi)){
if($uspjesno==1){
break;
}
else
{
$neuspjesnih++;
}
}



$datum = date("Y-m-d H:i:s");
$unesi="insert into prijave values ('','$idKor','$uspj','$datum','')";
$spremi = mysqli_query($dbc,$unesi);
if($uspj==0){
$neuspjesnih++;
}

// $poruka = "Dosad neuspješnih: ".$neuspjesnih;
// poruka($poruka);
if($neuspjesnih==4){
$deaktiviraj = "update korisnik set status = 0 where korIme='$idKor'";
$spremi = mysqli_query($dbc,$deaktiviraj);
$poruka = "Vaš račun je deaktiviran";
poruka($poruka);
header("refresh 1: url=index.php");
}


header("refresh: 1; url=index.php");
}


function PosaljiMail($kor_ime,$email,$aktivacijski_kljuc,$rokAkt){

				$server = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				$to = $email;
				$subject = "Registracija!";
				$body = "Dobro dosli ".$kor_ime ." na naš server!<br><br>
				Vas link za aktivaciju je sljedeci:<br>".
				$server.="?user=$kor_ime&kljuc=$aktivacijski_kljuc&akt=1";
				$body.="<br><br>Rok za aktivaciju je: ".date("d.m.Y H:i:s",strtotime($rokAkt));
				
						$headers          = 'MIME-Version: 1.0' . "\r\n";
						$headers         .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
						$headers         .= 'To: <' .$email. ">\r\n";
						$headers         .= "From: Knjiznica <info@knjiznica.com>" . "\r\n";
						
				$body = "<label class='spanmail'>".$body."</label>";
				if (mail($to, $subject, $body,$headers)){
					$poruka = "E-mail sa aktivacijskim linkom poslan je na vasu mail adresu";
					poruka($poruka);
					//header("refresh: 0; url=index.php");
				}
				else
				{
					$poruka = "Poruka nije poslana…";
					poruka($poruka);
				}

			echo "<br>Server: <a href='$server'>$server</a>";
			}
			
function vratiKordinate($address){
 
$address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern
 
$url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
//$url = "http://localhost/zeleznjak/educational/primjer.json";
 
$response = file_get_contents($url);
 
$json = json_decode($response,TRUE); //generate array object from the response from the web
 
return ($json['results'][0]['geometry']['location']['lat'].",".$json['results'][0]['geometry']['location']['lng']);
 
}


function PopisKategorija(){
	
global $dbc;
DBConnect();

$kategorije = "select * from kategorija";
$ex = DBQuery($kategorije);

$katArr = array();
while(list($id,$zanr)=mysqli_fetch_array($ex)){
	$katArr[$id]=$zanr;	
}

DBClose();	
return $katArr;	
}


function PopisKnjiznica(){
	
global $dbc;
DBConnect();

$knjiznice = "select idKnjiznica, naziv, adresa from knjiznica";
if(isset($_SESSION['idTip'])){
	if($_SESSION['idTip']==2){
		$knjiznice.=" where moderatorID = ".$_SESSION['idkorisnik'];
	}
}
$ex = DBQuery($knjiznice);

$knjigArr = array();
while(list($id,$naziv,$adresa)=mysqli_fetch_array($ex)){
	$mjesto = substr($adresa,strpos($adresa,",")+1,strlen($adresa));
	$knjigArr[$id]=$naziv." / ".$mjesto;	
}

DBClose();	
return $knjigArr;	
}

function Moderatori(){
	
global $dbc;
DBConnect();

$moderatori = "select idKorisnik, korIme, concat(ime,' ',prezime) from korisnik where idTip = 2";
$ex = DBQuery($moderatori);

$modArr = array();
while(list($id,$korime,$naziv)=mysqli_fetch_array($ex)){
	$modArr[$id]=$naziv;	
}

DBClose();	
return $modArr;	
}


function SviKorisnici(){
	
global $dbc;
DBConnect();

$moderatori = "select idKorisnik, korIme, concat(ime,' ',prezime), email from korisnik";
$ex = DBQuery($moderatori);

$korArr = array();
$temp = array();
while(list($id,$korime,$naziv, $email)=mysqli_fetch_array($ex)){
	//$korArr[$id]=$naziv;	
	 $temp = array($korime,$naziv,$email);
	$korArr[$id]=$temp;	
	//array_push($korArr,array($id,$korime,$naziv,$email));
}

DBClose();	
return $korArr;	
}

function PopisKnjiga(){
	
global $dbc;
DBConnect();

$kategorije = "select idKnjiga, naziv, autor from knjiga";
$ex = DBQuery($kategorije);

$knjArr = array();
while(list($id,$naziv,$autor)=mysqli_fetch_array($ex)){
	$knjArr[$id]=$naziv.", ".$autor;	
}

DBClose();	
return $knjArr;	
}

function MailRezervacija($naslov,$primatelj,$poruka){
	
	$naslov = "Podaci o rezervaciji knjige!";
	$headers          = 'MIME-Version: 1.0' . "\r\n";
	$headers         .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers         .= 'To: Primatelj '.".$primatelj." . "\r\n";
	$headers         .= "From: Knjižnica Online <knjiznica@knjiznica.net>" . "\r\n";
	$posalji = mail($primatelj,$naslov,$poruka,$headers);
	
	if($posalji){
		$poruka = "Obavijest poslana!";
	}
	else
	{
		$poruka = "Obavijest nije poslana!";
	}
	
	poruka($poruka);
	
}

function PostojanjeRezervacije($idkor,$idknjiga,$tablica){
	
	global $dbc;
	DBConnect();
	
	$rezpost = "select * from ".$tablica." where idKnjiga='$idknjiga' and idKorisnik='$idkor'";
	$ex = DBQuery($rezpost);
	
	if(mysqli_num_rows($ex)>0){
		return true;
	}
	else
	{
		return false;
	}
	
}


function PostojanjeKnjizniceCSV($naziv){
	
	global $dbc;
	DBConnect();
	
	$upit = "select * from knjiznica where naziv='$naziv'";
	$ex = DBQuery($upit);
	
	if(mysqli_num_rows($ex)>0){
		return true;
	}
	else
	{
		return false;
	}
	
}

function ProvjeraTermina($idknjiga, $datumod,$datumdo){
	
	global $dbc;
	DBConnect();
	
	$terpost = "select count(*)
  from rezervacije where idKnjiga = '$idknjiga'  and 
  ((datumOd >= '$datumod' and datumOd <= '$datumdo') or (datumDo >= '$datumod' and datumDo <= '$datumdo'))";
	$ex = DBQuery($terpost);
	$red = mysqli_fetch_array($ex);
	$broj = $red[0];
	if($broj>0){
		return true;
	}
	else
	{
		return false;
	}
}

function ZapisiUDnevnik($poruka,$skripta,$korisnik){
	
	global $dbc;
	DBConnect();
	$datum = date("Y-m-d H:i:s");
	$dnevnik = "insert into dnevnik values ('','$datum','$poruka','$skripta','$korisnik')";
	$ex = DBQuery($dnevnik);
	
}

function PretvoriUpdf(){	
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 048');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

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

$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------
session_start();
if(isset($_SESSION['tablica'])){
	
	$tabla = $_SESSION['tablica'];
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

function ProvjeriLike($idkor,$idstav,$tablica,$like){
	
	global $dbc;
	DBConnect();
	
	if($tablica=="statknjiga"){
		$like = "select * from statknjiga where idKnjiga = ".$idstav." and idKorisnik=".$idkor." and svidja = ".$like;
	}
	else
	{
		$like = "select * from statkategorija where idKategorija = ".$idstav." and idKorisnik=".$idkor." and svidja = ".$like;
	}
	
	$ex = DBQuery($like);
	$red = mysqli_num_rows($ex);

	if($red>0){
		return true;
	}
	else
	{
		return false;
	}
	
}

function provjeriRecaptha()
{

    $input  = $_POST['g-recaptcha-response'];
    $secret = '6Leb7h4TAAAAACI_e0b9MEJhqIzBsLrLHFkz-Kqn';

    $url  = 'https://www.google.com/recaptcha/api/siteverify';
    $data = ['secret' => $secret, 'response' => $input];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $result  = file_get_contents($url, false, $context);

    if ($result === false) {
        echo 'Greska!';
    }

    $odgovor = json_decode($result);
    if ($odgovor->success == 'true') {
        return true;
    }

    return false;
}

function PeriodAktivnosti($skripta){

				if(session_id()==""){
					session_start();
				}
				
					$dat="sesija.txt";
					$otvori = fopen($dat,'r');
					$propis = trim(fgets($otvori));
					fclose($otvori);

				if(!isset($_SESSION['start'])){
					$_SESSION['start'] = time();			//postavljam pocetno vrijeme	13:30
					$pocetak = $_SESSION['start'];	//spremam pocetno vrijeme prethodnog pristupa
					//		echo "<br>Prvi pristup: ".$_SESSION['start'];
				}
				else
				{
					$_SESSION['timeout'] = time();	//postavljam vrijeme ponovnog pristupa
					//			echo "<br>Prvi pristup: ".$_SESSION['start'];
					$nakon = $_SESSION['timeout'];	//spremam vrijeme ponovnog pristupa	13:45 - to je sad novo vrijeme
					//			echo "<br>Sljedeci pristup: ".$_SESSION['timeout'];
					$pocetak = $_SESSION['start'];
					ProvjeriVrijemeIsteka($pocetak,$nakon,$propis,$skripta);	//pozivam funkciju koja provjerava vrijeme neaktivnosti

				}


			}


			function ProvjeriVrijemeIsteka($pocetak,$nakon,$neaktivan,$skripta){
				$razlika = $nakon - $pocetak;
				//global $skripta;
				if($razlika > $neaktivan){
					ZapisiUDnevnik("Prekoračeno vrijeme neaktivnosti: ".($razlika-$neaktivan)." sek",$skripta,$_SESSION['idkorisnik']);
					$poruka = "Prekoračili ste dozvoljeno vrijeme neaktivnosti! Morate se ponovno ulogirati!";
					session_destroy();
					poruka($poruka);
					header("refresh: 1; url='login.php'");					
				}
				else
				{
					$_SESSION['start'] = $_SESSION['timeout'];
				}

			}
?>