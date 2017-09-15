<?php
include('dbconnect.php');
include('zaglavlje.php');


PeriodAktivnosti($skripta);

DBConnect();

if(isset($_GET['akt'])){

$idKor = $_GET['user'];
//ZapisiUDnevnik("Aktiviran račun korisnika ".$idkor,$skripta,$aktivni_korisnik_id);
$akt="update korisnik set status=1 where korIme = '$idKor'";
$spremi = mysqli_query($dbc,$akt);
$zadnjaPrijava = "select idPrijave from prijave where uspjesno = 0 and korime='$idKor' order by datumPrijave desc limit 1";
$spremi = mysqli_query($dbc,$zadnjaPrijava);
$red = mysqli_fetch_array($spremi);
$idPrijave = $red['idPrijave'];
$poruka = "Račun aktiviran ";
$poruka.=date("d.m.Y H:i:s");
$azurPrijava = "update prijave set uspjesno=1, poruka='$poruka' where korime='$idKor' and idPrijave='$idPrijave'";
//echo "<br>Upit: ".$azurPrijava;
$spremi = mysqli_query($dbc,$azurPrijava);
if($spremi){
$poruka= "Račun ".$idKor." uspješno aktiviran!";
poruka($poruka);
header("refresh: 1; url=clanovi.php");
}
else
{
die("greska: ".mysqli_error($dbc));
}
}

if(isset($_GET['brisi'])){
	$idKor = $_GET['brisi'];
	$korisnik = $_GET['kor_ime'];
	$bris = "delete from korisnik where idKorisnik = '$idKor'";
	$ex = DBQuery($bris);
	
	if($ex){
		$poruka = "Korisnik ".$korisnik." uspješno izbrisan!";
		poruka($poruka);
		header("refresh: 0; url=clanovi.php");
	}
	
}

if(isset($_POST['zaboravljena'])){
	
	$email = $_POST['email'];
	
	$sifra = "select sif.obicnasif, kor.email from sifre sif, korisnik kor where kor.idKorisnik = sif.idkor and kor.email = '$email'";
	$ex = DBQuery($sifra);
	
	list($sif)=mysqli_fetch_array($ex);
	$porukam = "Poštovani, vaša nova šifra je: ".$sif;
	$posalji = mail($email,"Zaboravljena sifra",$porukam);
	if($posalji){
		$poruka = "Šifra vam je poslana na mail!";
	}
	else
	{
		$poruka = "Poruka nije poslana";
	}
	poruka($poruka);
	header("refresh: 1; url=login.php");
	//echo "Poruka: ".$porukam;
}

if(isset($_GET['zaboravljena'])){
	
echo "<form action='clan.php' method='POST'>";
echo "<p>Upišite vaš email: <input type='email' name='email'></p>";
echo "<p><input type='submit' name='zaboravljena' value='Posalji'>";
echo "</form>";
	
}

if(isset($_GET['reg']) || isset($_GET['azuriraj'])){
	
	if(isset($_GET['azuriraj'])){
		ZapisiUDnevnik("Ažuriranje korisnika",$skripta,$aktivni_korisnik_id);
		$idkor = $_GET['azuriraj'];
		
		$upit = "select 
		idKorisnik, korIme, sifra, sifrap, ime, prezime, adresa, datRod, spol, email, idTip, status, mobitel, slika
		from korisnik where idKorisnik = '$idkor'";
		//echo "<br>upit: ".$upit;
		$qu = DBQuery($upit);
		list($id,$korime,$sifra,$sifrap,$ime,$prezime,$adresa,$datum,$spol,$email,$tip,$status,$mob,$slika)=mysqli_fetch_array($qu);
	}
	else
		//ZapisiUDnevnik("Unos novog korisnika",$skripta,$aktivni_korisnik_id);
	{
	$id=0;
	$korime="";
	$sifra="";
	$sifrap="";
	$ime="";
	$prezime="";
	$datum="";
	$adresa="";
	$spol="";
	$email="";
	$tip="";
	$status="";
	$mob="";
	$slika="";
	}
	?>
	<h1>Unesite podatke</h1>

<form method="post" action="clan.php" enctype="multipart/form-data" onsubmit="return ValidKorisnikForm(this)">	
			<table>
			<tbody>
			<input type="hidden" name="novi" value="<?php echo $id;?>"/>
			<input type="hidden" name="photo" value="<?php echo $slika;?>"/>
				<tr>
					<td><label for="kor_ime">Korisničko ime:</label></td>
					<td><input type="text" name="kor_ime" id="kor_ime" <?php if($korime!=""){echo "readonly='readonly'";}?> value="<?php echo $korime;?>"/><label id="lbkorisnik"></label></td>
				</tr>
				<tr>
					<td><label for="lozinka" >Lozinka:</label></td>
					<td><input type="password" name="lozinka" id="lozinka" value="<?php echo $sifra;?>"/><label id="lbkorisnikSifra"></label></td>
				</tr>
				<tr>
					<td><label for="lozinkap" >Lozinka opet:</label></td>
					<td><input type="password" name="lozinkap" id="lozinkap" value="<?php echo $sifrap;?>"/><label id="lbkorisnikSifrap"></label></td>
				</tr>
				<tr>
					<td><label for="ime">Ime:</label></td>
					<td><input type="text" name="ime" id="ime" value="<?php echo $ime;?>"/><label id="lbkorisnikIme"></label></td>
				</tr>				
				<tr>
					<td><label for="prezime">Prezime:</label></td>
					<td><input type="text" name="prezime" id="prezime" value="<?php echo $prezime;?>"/><label id="lbkorisnikPrezime"></label></td>
				</tr>
				<tr>
					<td><label for="adresa">Adresa:</label></td>
					<td><input type="text" name="adresa" id="adresa" placeholder="Adresa 1, Grad" value="<?php echo $adresa;?>"/><label id="lbkorisnikAdresa"></label></td>
				</tr>
				<tr>
					<td><label for="datrod">Datum rođenja:</label></td>
					<td><input type="date" name="datrod" id="datrod" value="<?php echo $datum;?>"/><label id="lbkorisnikDatrod"></label></td>
				</tr>
				<tr>
				<td><label for="spol">Spol:</label></td>
				<td>
					<input type="radio" name="spol[]" id="spol" <?php if($spol=="M"){echo " checked";}?> value="M"/> Muški<br/>
					<input type="radio" name="spol[]" id="spol" <?php if($spol=="Z"){echo " checked";}?> value="Z"/> Ženski<br/><label id="lbkorisnikSpol"></label>					
					</td>
				</tr>
				<?php
				if($id>0){
				?>
				<tr>
					<td><label for="tip">Tip:</label></td>
					<td>
					<select name="tip" id="tip">
					<option value="1" <?php if($tip==1){echo " selected";}?>>Administrator</option>
					<option value="2" <?php if($tip==2){echo " selected";}?>>Moderator</option>
					<option value="2" <?php if($tip==3){echo " selected";}?>>Korisnik</option>
					</select>
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td><label for="email">E-mail:</label></td>
					<td><input type="email" name="email" id="email" value="<?php echo $email;?>"/><label id="lbkorisnikEmail"></label></td>
				</tr>
				<tr>
					<td><label for="mob">Mobitel:</label></td>
					<td><input type="mob" name="mob" id="mob" placeholder="09x xxx xxxx" value="<?php echo $mob;?>"/><label id="lbkorisnikMobitel"></label></td>
				</tr>
				<tr>
					<td><label for="slika">Slika:</label></td>
					<td><input type="file" name="slika" id="slika"/></td>
				</tr>

				<tr>
				<td><label for="slikarec">Recaptcha:</label></td>
				<td class="g-recaptcha" data-sitekey="6Leb7h4TAAAAALvUW1yxckRyPN6d9_4-4LJudwyc"></td>
				</tr>

				<tr>
					<td colspan="2"><input type="submit" name="korisnik" value="Pošalji"/></td>
				</tr>
				</tbody>
			</table>
		</form>	
<?php	
}

if(isset($_POST['korisnik'])){
	
		$id=$_POST['novi'];
		$kor_ime = $_POST['kor_ime'];
		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$obicna = $_POST['lozinka'];
		$lozinka = md5($_POST['lozinka']);
		$lozinkap = md5($_POST['lozinkap']);
		$adresa = $_POST['adresa'];
		if($id>0){
			$tip=$_POST['tip'];
		}
		//$lokacija = vratiKordinate($adresa);
		$lokacija = "45.8015981,15.9020405";
		$datrod = $_POST['datrod'];
		$spol = $_POST['spol'];
		$email = $_POST['email'];
		$rokAkt = date("Y-m-d H:i:s",strtotime('+12 hours'));
		$mob = $_POST['mob'];
		
		$string_mix = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
		$aktivacijski_kljuc = '';
		for($a=0;$a<50;$a++){
			$poz = rand(0,strlen($string_mix)-1);
			$aktivacijski_kljuc = $aktivacijski_kljuc.substr($string_mix,$poz,1);
		}
		
		$postojeca = $_POST['photo'];
		
		$mjesto = "korisnici/";	

		$ime_dat = basename($_FILES['slika']['name']);
		
		if($ime_dat != ""){
		$slika = $mjesto.$ime_dat;	
		$stavi = move_uploaded_file($_FILES['slika']['tmp_name'],$slika);
		}
		else
		{
			if($postojeca != ""){
				$slika = $postojeca;
			}
			else
			{
				$slika = "korisnici/nophoto.jpg";
			}
			
		}
		//ZapisiUDnevnik("Unešen novi korisnik ".$kor_ime,$skripta,$aktivni_korisnik_id); && provjeriRecaptha()==true
		if($id==0){
			
			$novi="insert into korisnik values ('','$kor_ime','$lozinka','$lozinkap','$ime','$prezime','$adresa','$datrod','$spol','$email',3,0,'$rokAkt','$aktivacijski_kljuc','$lokacija','$mob','$slika')";
			
			$new = mysqli_insert_id($dbc);
			$sifspremi = "insert into sifre values ('$new','$obicna','$lozinka')";
			DBQuery($sifspremi);
		}
		else
		{
			//ZapisiUDnevnik("Ažuriran korisnik ".$kor_ime,$skripta,$aktivni_korisnik_id);
			$novi = "update korisnik set sifra='$lozinka', sifrap='$lozinkap', ime='$ime', prezime='$prezime',
			adresa='$adresa', datRod='$datrod', spol='$spol', email='$email', idTip='$tip', mobitel='$mob', slika='$slika' where idKorisnik='$id'";
		}
		
		$ex = DBQuery($novi);
		
		if($ex){
			$poruka = "Uspješan unos podataka!";
			poruka($poruka);
			if($id==0){
			PosaljiMail($kor_ime,$email,$aktivacijski_kljuc,$rokAkt);
			}
			header("refresh: 0; url=index.php");
		}
		else
		{
			die("Greška: ".mysqli_error($dbc));
		}
	
}

if(isset($_GET['aktiviraj'])){
	
				$user = $_GET['user'];
				$kljuc = $_GET['kljuc'];
				
				$rok = "select rokAktivacije from korisnik where korIme='$user' and regKljuc='$kljuc'";
				$spremi = DBQuery($rok);
				
				ZapisiUDnevnik("Aktiviran korisnički račun ".$user,$skripta,$aktivni_korisnik_id);
				
				$red = mysqli_fetch_array($spremi);
				$rokAkt = $red[0];
				$trenDat = date("d.m.Y H:i:s");
				$rokstamp = strtotime($rokAkt);
				$trenstamp = strtotime($trenDat);
				
				if($trenstamp>$rokstamp){
					$poruka = "Vrijeme za aktivaciju racuna isteklo! Morate napraviti novu registraciju!";
					poruka($poruka);
					$brisiKor = "delete from korisnik where korIme = '$user'";
					$spremi = DBQuery($brisiKor);
					header("refresh: 1; url=index.php");
					exit();
				}
				
				$aktiviraj = "update korisnik set status=1 where korIme='$user' and regKljuc='$kljuc'";
				$spremi = DBQuery($aktiviraj);
				if($spremi){

					$poruka = "Cestitke ".$user.", vas račun je aktiviran uspješno!";
					poruka($poruka);
					header("refresh: 1; url=index.php");

				}
				else
				{
					$poruka = "Greška: ".mysqli_error($dbc);
					die($poruka);

				}
	
}

DBClose();
include('podnozje.php');
?>
