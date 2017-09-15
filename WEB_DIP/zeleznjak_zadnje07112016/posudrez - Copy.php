<?php
include('dbconnect.php');
include('zaglavlje.php');
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
	echo "<table summary='Popis rezervacija' cellpadding='0' cellspacing='0'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th width='5%'>ID rezervacije</th><th>Datum rezervacije <br>$datzup $datdown</th><th>Datum od</th><th>Datum do</th><th>Status</th><th>Broj dana</th><th>Knjiga <br>$knjup $knjdown</th>";
	echo "<th>Žanr</th><th>Član</th>";

	echo "<th>Radnja</th>";	

	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
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
	echo "<tr class='$redclass'>";	
	echo "<td>$id</td><td>$datumrez</td><td>$datumod</td><td>$datumdo</td><td title=\"$odobravatelj\">$status</td><td>$brdana</td><td>$nazivknjiga</td>";
	echo "<td>$zanr</td><td>$imeclan</td>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	echo "<td>";
	if($status=="Odobrena"){
		echo "$odbij";
	}
	elseif($status=="U obradi")
	{
	echo "$odobri $odbij";	
	}
	else
	{
	echo "$odobri";	
	}
	echo "</td>";	
	}
	else
	{
		if($status=="Odobrena" && PostojanjeRezervacije($idclan,$idknjiga,"posudbe")==false && $idclan==$aktivni_korisnik_id){
			echo "<td>$posudi</td>";
		}
		elseif($status=="Odobrena" && PostojanjeRezervacije($idclan,$idknjiga,"posudbe")==true)
		{
			echo "<td>Posuđena";
					if($odobravatelj>0){
							$kordetalji = $korisniciArr[$odobravatelj];
							$korisniknaziv = $kordetalji[1];
		 echo " od ".$korisniknaziv;
		}
			echo "</td>";
		}
		elseif($status=="U obradi" && ($odobravatelj!=null || $odobravatelj!="") && $idclan!=$aktivni_korisnik_id)
		{
			echo "<td>$odobri $odbij</td>";
		}
	}
	echo "<tr>";
	}
echo "<tr>";
echo "<td colspan='11'>";
echo "Stranice: ";
for($a=1;$a<=$br_strana;$a++){
	echo "  <a href='posudrez.php?stranica=$a'>";
	if($aktivna==$a){
		echo "<strong>";
	}
	echo $a;
	if($aktivna==$a){
		echo "</strong>";
	}
	echo "</a>";
}
echo "</td>";
echo "</tr>";
echo "</tbody>";	
echo "</table>";

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
	echo "<table summary='Popis rezervacija' cellpadding='0' cellspacing='0'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th width='5%'>ID posudbe</th><th>Datum posudbe <br>$datzup $datdown</th><th>Datum od</th><th>Datum do</th><th>Broj dana</th><th>Knjiga <br>$knjup $knjdown</th>";
	echo "<th>Žanr</th><th>Posudio Član</th>";
//	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	echo "<th>Radnja</th>";	
//	}
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
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
	echo "<tr class='$redclass'>";	
	echo "<td>$id</td><td>$datumrez</td><td>$datumod</td><td>$datumdo</td><td>$brdana</td><td>$nazivknjiga</td>";
	echo "<td>$zanr</td><td>$imeclan</td>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	echo "<td>";
	echo "$odobri $odbij";
	echo "</td>";	
	}
	if($aktivni_korisnik_tip==3 && (PostojanjeRezervacije($aktivni_korisnik_id,$idknjiga,"rezervacije")==false) && ($aktivni_korisnik_id!=$idclan)){
	echo "<td>";
	echo "$rez";
	echo "</td>";	
	}
	else
	{
		echo "<td>Posudjena";

		echo "</td>";
	}
	echo "<tr>";
	}
echo "<tr>";
echo "<td colspan='11'>";
echo "Stranice: ";
for($a=1;$a<=$br_strana;$a++){
	echo "  <a href='posudrez.php?stranica=$a'>";
	if($aktivna==$a){
		echo "<strong>";
	}
	echo $a;
	if($aktivna==$a){
		echo "</strong>";
	}
	echo "</a>";
}
echo "</td>";
echo "</tr>";
echo "</tbody>";	
echo "</table>";

}
include('podnozje.php');
DBClose();
?>