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
if(isset($_POST['rezervacija'])){
	
	$skripta=basename($_SERVER['SCRIPT_NAME']);
	ZapisiUDnevnik("Podnesena rezervacija knjige",$skripta,$aktivni_korisnik_id);
	
	$idknjiga=$_POST['idknjiga'];
	$datumod = $_POST['datumod'];
	$datumdo = $_POST['datumdo'];
	$datumRez = date("Y-m-d H:i:s");
	
	if(ProvjeraTermina($idknjiga, $datumod,$datumdo)==true){
		$poruka="Knjiga je već posuđena u tom terminu!";
		
		$skripta=basename($_SERVER['SCRIPT_NAME']);
		ZapisiUDnevnik("Knjiga je već rezervirana",$skripta,$aktivni_korisnik_id);
		
		poruka($poruka);
		header("refresh: 1; url=posudrez.php?posudbe=1");
		exit;
	}
	
	$odobravatelj=$_POST['odobravatelj'];
	
	if($odobravatelj>0){
	$rez = "insert into rezervacije values ('','$datumRez','$datumod','$datumdo','0','$idknjiga','$aktivni_korisnik_id','$odobravatelj')";
	ZapisiUDnevnik("Knjiga rezervirana od korisnika",$skripta,$aktivni_korisnik_id);	
	}
	else
	{
	$rez = "insert into rezervacije values ('','$datumRez','$datumod','$datumdo','0','$idknjiga','$aktivni_korisnik_id',null)";
	ZapisiUDnevnik("Knjiga rezervirana od moderatora",$skripta,$aktivni_korisnik_id);
	}
	
	$ex = DBQuery($rez);
	if($odobravatelj>0){
	$kordetalji = $korisniciArr[$odobravatelj];
	$korisniknaziv = $kordetalji[1];
	$korisnikmail = $kordetalji[2];
	}
	
	$naslov = "Potvrda o novoj rezervaciji knjige";
	
	$poruka = "Poštovana/i g. ".$aktivni_korisnik_ime.",";
	$poruka.="<br/>Upravo ste rezervirali slijedeće: ";
	$poruka.="<br/>Knjiga: ".$knjigeArr[$idknjiga];
	$poruka.="<br/>Datum od: ".date("d.m.Y",strtotime($datumod));
	$poruka.="<br/>Datum do: ".date("d.m.Y",strtotime($datumdo));
	$razlika = strtotime($datumdo)-strtotime($datumod);
	$brdana = floor($razlika/(60*60*24));
	$poruka.="<br/>Broj dana: ".$brdana;
	
	if($odobravatelj>0){
		$poruka.="<p>Odobrenje čeka kod: ".$korisniknaziv."</p>";
	}
	$poruka.="<p>Potvrdu o odobrenju ili neodobrenju rezervacije dobit ćete uskoro!</p>";
	$poruka.="<p>S osobitim poštovanjem!</p>";
	MailRezervacija($naslov,$aktivni_korisnik_email,$poruka);
	ZapisiUDnevnik("Mail obavijest poslana o rezervaciji",$skripta,$aktivni_korisnik_id);
	
	// echo "<br>Mail: ".$aktivni_korisnik_email;
	// echo "<br>Poruka: ".$poruka;
	if($odobravatelj>0){
	header("refresh: 1; url=posudrez.php");	
	}
	else
	{
	header("refresh: 1; url=knjige.php");	
	}
	
	
}


if(isset($_GET['like'])){
	
	$idknjiga = $_GET['like'];
	
	if(isset($_GET['prvi'])){
	$like = "insert into statknjiga values ('',1,'$idknjiga','$aktivni_korisnik_id')";	
	}
	else
	{
	$like = "update statknjiga set svidja= 1 where idKnjiga='$idknjiga' and idKorisnik = '$aktivni_korisnik_id'";
	}
	
	
	$ex = DBQuery($like);
	
	header("Location: knjige.php");
}


if(isset($_GET['unlike'])){
	
	$idknjiga = $_GET['unlike'];
	
	if(isset($_GET['prvi'])){
	$unlike = "insert into statknjiga values ('',0,'$idknjiga','$aktivni_korisnik_id')";	
	}
	else
	{
	$unlike = "update statknjiga set svidja= 0 where idKnjiga='$idknjiga' and idKorisnik = '$aktivni_korisnik_id'";
	}
	$ex = DBQuery($unlike);
	
	header("Location: knjige.php");
}

if(isset($_GET['rezerviraj'])){
	
	$idKnjiga = $_GET['rezerviraj'];
	
	if(isset($_GET['odobravatelj'])){
		$odobravatelj=$_GET['odobravatelj'];
	}
	else
	{
		$odobravatelj=0;
	}

	
	?>
	<h1>Unesite podatke o rezervaciji</h1>

<form method="post" action="knjiga.php" name="knjiga" enctype="multipart/form-data" onsubmit="return ValidRezervacijaForm(this)">	
			<table>
			<tbody>
			<input type="hidden" name="idknjiga" value="<?php echo $idKnjiga;?>"/>
			<input type="hidden" name="odobravatelj" value="<?php echo $odobravatelj;?>"/>
				<tr>
					<td><label for="datumod">Datum od:</label></td>
					<td><input type="date" name="datumod" id="datumod" value=""/><label id="lbRezDatumOd"></label></td>
				</tr>
				<tr>
					<td><label for="datumdo">Datum do:</label></td>
					<td><input type="date" name="datumdo" id="datumdo" value=""/><label id="lbRezDatumDo"></label></td>
				</tr>				
				<tr>
					<td colspan="2"><input type="submit" name="rezervacija" value="Rezerviraj"/></td>
				</tr>
				</tbody>
			</table>
		</form>	
<?php	
ZapisiUDnevnik("Unos podataka o rezervaciji",$skripta,$aktivni_korisnik_id);	
}

if(isset($_GET['rezotkazi'])){
	$idknjiga=$_GET['rezotkazi'];
	
	$rez = "select idRezervacija from rezervacije where idKnjiga = ".$idknjiga;
	$ex = DBQuery($rez);
	list($idrez)=mysqli_fetch_array($ex);
	$otk = "delete from rezervacije where idRezervacija = ".$idrez;
	$ex = DBQuery($otk);
	
	header("Location: knjige.php");
}


if(isset($_GET['brisi'])){
	$idknjiga = $_GET['brisi'];
	$knjiga = $_GET['knjiga'];
	$bris = "delete from knjiga where idKnjiga = '$idknjiga'";
	$ex = DBQuery($bris);
	
	if($ex){
		$poruka = "Knjiga pod nazivom ".$knjiga." uspješno izbrisana!";
		poruka($poruka);
		header("refresh: 0; url=".$_SESSION['uriparams']);
	}
	
}


if(isset($_GET['unos']) || isset($_GET['azuriraj'])){
	ZapisiUDnevnik("Unos/ažuriranje knjige",$skripta,$aktivni_korisnik_id);
	if(isset($_GET['azuriraj'])){
		$idknjiga = $_GET['azuriraj'];
		
		$upit = "select 
		idKnjiga, naziv, ISBN, autor, izdavac, godina, brStranica, kolicina, brPosudbi, kategorijaID, opis
		from knjiga where idKnjiga = '$idknjiga'";
		$qu = DBQuery($upit);
		list($id,$naziv,$isbn,$autor,$izdavac,$godina,$kolicina,$stranice,$posudbe,$kateg,$opis)=mysqli_fetch_array($qu);
	}
	else
	{
	$id=0;
	$naziv="";
	$isbn="";
	$autor="";
	$izdavac="";
	$godina="";
	$kolicina="";
	$stranice="";
	$kateg="";
	$opis="";
	}
	?>
	<h1>Unesite podatke o knjizi</h1>

<form method="post" action="knjiga.php" name="knjiga" enctype="multipart/form-data" onsubmit="return ValidKnjigaForm(this)">	
			<table>
			<tbody>
			<input type="hidden" name="novi" value="<?php echo $id;?>"/>
				<tr>
					<td><label for="naziv">Naziv:</label></td>
					<td><input type="text" name="naziv" id="naziv" value="<?php echo $naziv;?>"/><label id="lbKnjigaNaziv"></label></td>
				</tr>
				<tr>
					<td><label for="isbn" >ISBN:</label></td>
					<td><input type="text" name="isbn" id="isbn" value="<?php echo $isbn;?>"/><label id="lbKnjigaISBN"></label></td>
				</tr>
				<tr>
					<td><label for="autor" >Autor:</label></td>
					<td><input type="text" name="autor" id="autor" value="<?php echo $autor;?>"/><label id="lbKnjigaAutor"></label></td>
				</tr>
				<tr>
					<td><label for="izdavac">Izdavač:</label></td>
					<td><input type="text" name="izdavac" id="izdavac" value="<?php echo $izdavac;?>"/><label id="lbKnjigaIzdavac"></label></td>
				</tr>				
				<tr>
					<td><label for="godina">Godina:</label></td>
					<td><input type="number" name="godina" id="godina" value="<?php echo $godina;?>"/><label id="lbKnjigaGodina"></label></td>
				</tr>
				<tr>
					<td><label for="kolicina">Količina:</label></td>
					<td><input type="number" name="kolicina" id="kolicina" value="<?php echo $kolicina;?>"/><label id="lbKnjigaKolicina"></label></td>
				</tr>
				<tr>
					<td><label for="stranice">Broj stranica:</label></td>
					<td><input type="number" name="stranice" id="stranice" value="<?php echo $stranice;?>"/><label id="lbKnjigaStrana"></label></td>
				</tr>
				<tr>
				<td><label for="tip">Kategorija:</label></td>
					<td>
					<select name="kategorija" id="kategorija" onchange="DodavanjeKategorije()">
					<?php
					$kategorije = PopisKategorija();
					foreach($kategorije as $idkat=>$naziv){
						echo "<option value='$idkat'";
						if($idkat == $kateg){
							echo " selected";
						}
						echo ">$naziv</option>";
					}
					?>
					<option value="nk">Dodaj novu...</option>
					</select>
					</td>
				</tr>
				<tr id="KatSkr" style="display: none;">
				<td>Nova kategorija:</td><td> <input type="text" name="NazivKategorija" id="NazivKategorija"><label id="lbNovaKategorija"></label></td>
				</tr>
				<tr>
					<td><label for="opis">Opis:</label></td>
					<td><textarea name="opis" id="opis" rows="10" cols="30"><?php echo $opis;?></textarea><label id="lbKnjigaOpis"></label></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="knjiga" value="Spremi"/></td>
				</tr>
				</tbody>
			</table>
		</form>	
<?php	
}

if(isset($_POST['knjiga'])){
	
		$id=$_POST['novi'];
		$naziv = $_POST['naziv'];
		$isbn = $_POST['isbn'];
		$autor = $_POST['autor'];
		$izdavac = $_POST['izdavac'];
		$godina = $_POST['godina'];
		$kolicina = $_POST['kolicina'];
		$brstrana = $_POST['stranice'];
		$kategorija = $_POST['kategorija'];
		$opis=$_POST['opis'];
		$dat = date("Y-m-d H:i:s");
		
		if(!empty($_POST['NazivKategorija'])){
			$novakat=$_POST['NazivKategorija'];
			$idknjiz = $_SESSION['idknjiz'];
			$katunos = "insert into kategorija values ('','$novakat','$idknjiz','$dat')";
			$ex = DBQuery($katunos);
			$kategorija=mysqli_insert_id($dbc);
		}
		
		if($id==0){
			
			$novi="insert into knjiga values (
			'','$naziv','$isbn','$autor','$izdavac','$godina','$brstrana','$kolicina',0,
			'$kategorija','$opis','$dat')";
		}
		else
		{
			$novi = "update knjiga set naziv='$naziv', ISBN='$isbn', autor='$autor', izdavac='$izdavac',
			godina='$godina', brStranica='$brstrana', opis='$opis',datAzur = '$dat' where idKnjiga='$id'";
		}
		
		$ex = DBQuery($novi);
		
		if($ex){
			$poruka = "Uspješan unos podataka!";
			poruka($poruka);
			header("refresh: 0; url=knjige.php");
		}
		else
		{
			die("Greška: ".mysqli_error($dbc));
		}
	ZapisiUDnevnik("Knjiga ".$naziv." unešena",$skripta,$aktivni_korisnik_id);
}

DBClose();
include('podnozje.php');
?>
