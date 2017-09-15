
<?php
include('dbconnect.php');
include('zaglavlje.php');

PeriodAktivnosti($skripta);
echo "<h3 class='naslov'>";
if(isset($_SESSION['korime'])){
	echo "Vi ste: ".$_SESSION['korime'];
}
else
{
	echo "Niste prijavljeni";
}
echo "</h3>";

if($_SERVER['QUERY_STRING']==""){
	echo "<h2>Izbornik</h2>";
	echo "<ol>";
	echo "<li><a href='admin.php?stranicenje=1'>Podesi straničenje</a></li>";
	echo "<li><a href='admin.php?sesija=1'>Podesi vrijeme trajanja aktivnosti sesije</a></li>";
	echo "<li><a href='admin.php?cookie=1'>Podesi trajanje cookie</a></li>";
	echo "<li><a href='http://barka.foi.hr/WebDiP/pomak_vremena/vrijeme.html' target='_blank'>Podesi vrijeme servera</a></li>";
	echo "<li><a href='admin.php?ucitaj=1'>Učitaj novo vrijeme servera</a></li>";
	echo "</ol>";
	
}

if(isset($_GET['stranicenje'])){
	echo "<h2>Unesite broj podataka po stranici</h2>";
	echo "<table border='0'>";
	echo "<form action='admin.php' method='POST'>";
	echo "<tr>";
	echo "<td>Broj podataka:</td><td><input type='text' name='str' id='str'></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan='2'><input type='submit' name='FrmStr' value='Spremi'>";
	echo "</tr>";
	echo "</form>";
	echo "</table>";
}

if(isset($_POST['FrmStr'])){
	
	$podatak = $_POST['str'];
	$dat="stranice.txt";
	$otvori = fopen($dat,'w');
	fwrite($otvori,$podatak);
	fclose($otvori);
	
	header("Location: admin.php");
}

//sesija
if(isset($_GET['sesija'])){
	echo "<h2>Unesite vrijeme trajanja sesije (u minutama)</h2>";
	echo "<table border='0'>";
	echo "<form action='admin.php' method='POST'>";
	echo "<tr>";
	echo "<td>Vrijeme:</td><td><input type='number' name='ses' id='ses' required></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan='2'><input type='submit' name='FrmSes' value='Spremi'>";
	echo "</tr>";
	echo "</form>";
	echo "</table>";
}

if(isset($_POST['FrmSes'])){
	
	$podatak = $_POST['ses'];
	$podatak = $podatak*60;
	$dat="sesija.txt";
	$otvori = fopen($dat,'w');
	fwrite($otvori,$podatak);
	fclose($otvori);
	
	header("Location: admin.php");
}

if(isset($_GET['cookie'])){
	echo "<h2>Unesite trajanje cookie</h2>";
	echo "<table border='0'>";
	echo "<form action='admin.php' method='POST'>";
	echo "<tr>";
	echo "<td>Trajanje cookie:</td><td><input type='text' name='cook' id='cook'></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan='2'><input type='submit' name='FrmCook' value='Spremi'>";
	echo "</tr>";
	echo "</form>";
	echo "</table>";
}

if(isset($_POST['FrmCook'])){
	
	$podatak = $_POST['cook'];
	$dat="vrijeme.txt";
	$otvori = fopen($dat,'w');
	fwrite($otvori,$podatak);
	fclose($otvori);
	
	header("Location: admin.php");
}

if(isset($_GET['ucitaj'])){
	
$url = "http://barka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=xml";

$sxml = simplexml_load_file($url);

$sati= $sxml->vrijeme->pomak->brojSati;

$vrijeme = $sati.":".date("i").":".date("s");

exec("time ".$vrijeme." PM");
header("Location: admin.php");
}

DBClose();
include('podnozje.php');
?>