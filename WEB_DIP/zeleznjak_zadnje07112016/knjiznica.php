<?php
include('dbconnect.php');
include('zaglavlje.php');

PeriodAktivnosti($skripta);

if($_SESSION['strurl']!=basename($_SERVER['SCRIPT_NAME'])){
$_SESSION['sort']='';
$_SESSION['strurl']=basename($_SERVER['SCRIPT_NAME']);
}
DBConnect();

if(isset($_POST['frmKnjiz'])){
	ZapisiUDnevnik("Unos/ažuriranje knjižnica",$skripta,$aktivni_korisnik_id);
	$idKnjiz = $_POST['knjiz'];
	
	$upit = "select idKnjiznica, naziv, adresa from knjiznica where idKnjiznica = '$idKnjiz'";
	$ex = DBQuery($upit);

	if($ex){
	list($id,$naziv,$adresa)=mysqli_fetch_array($ex);

	$_SESSION['idknjiz']=$id;
	$_SESSION['nazivknjiz']=$naziv;
	$_SESSION['adresaknjiz']=$adresa;
	
	}
	else
	{
		die("greska: ".mysqli_error($dbc));
	}
	header("Location: index.php");
}



if(isset($_GET['brisi'])){
	ZapisiUDnevnik("Brisanje knjižnice",$skripta,$aktivni_korisnik_id);
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



if(isset($_GET['unos']) || isset($_GET['azuriraj'])){
	ZapisiUDnevnik("Unos/ažuriranje",$skripta,$aktivni_korisnik_id);
	if(isset($_GET['azuriraj'])){
		$idknjiz = $_GET['azuriraj'];
		
		$upit = "select 
		idKnjiznica, naziv, adresa, kapacitet, moderatorID, slika from knjiznica where idKnjiznica = '$idknjiz'";
		$qu = DBQuery($upit);
		list($id,$naziv,$adresa,$kapacitet,$moderator,$slika)=mysqli_fetch_array($qu);
	}
	else
	{
	$id=0;
	$naziv="";
	$adresa="";
	$kapacitet="";
	$moderator="";
	$slika="";
	}
	?>
	<h2>Unesite podatke o knjižnici</h2>

<form method="post" action="knjiznica.php" name="knjiznica" enctype="multipart/form-data" onsubmit="return ValidKnjiznicaForm(this)">
<div id="forme">	
			<table>
			<tbody>
			<input type="hidden" name="novi" value="<?php echo $id;?>"/>
			<input type="hidden" name="photo" value="<?php echo $slika;?>"/>
				
				<tr>
				<td>Naziv:</td><td> <input type="text" name="NazivKnjiznica" id="NazivKnjiznica" value="<?php echo $naziv;?>" size="35"><label id="lbNazivKnjiznica"></label></td>
				</tr>
				<tr>
				<td>Adresa:</td><td> <input type="text" name="AdresaKnjiznica" id="AdresaKnjiznica" value="<?php echo $adresa;?>" placeholder="Adresa 1, Grad" size="25"><label id="lbAdresaKnjiznica"></label></td>
				</tr>
				<tr>
				<td>Kapacitet:</td><td> <input type="text" name="KapacitetKnjiznica" id="KapacitetKnjiznica" value="<?php echo $kapacitet;?>" size="10"><label id="lbKapacitetKnjiznica"></label></td>
				</tr>
				<tr>
				<td>Moderator:</td><td>
				<select name="ModeratorKnjiznica" id="ModeratorKnjiznica">
					<?php
					$moderatori = Moderatori();
					foreach($moderatori as $idmod=>$moderatorime){
					echo "<option value='$idmod'";
					if($moderator==$idmod){
						echo " selected";
					}
					echo ">$moderatorime</option>";
					}
					?>
				</select>
				</td>
				</tr>
				<tr>
				<td><label for="slika">Slika:</label></td><td><input type="file" name="slika" id="slika"/></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" class="gumb" name="FrmKnjiznica" value="Unesi"/></td>
				</tr>
				</tbody>
			</table>
			</div>
		</form>	
<?php	
}

if(isset($_POST['FrmKnjiznica'])){
	
		$id=$_POST['novi'];
		
			$novaknj = $_POST['NazivKnjiznica'];
			$adresaknj = $_POST['AdresaKnjiznica'];
			$kapacknj = $_POST['KapacitetKnjiznica'];
			$modknj = $_POST['ModeratorKnjiznica'];
			
			$postojeca = $_POST['photo'];
			$mjesto = "knjiznice/";	

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
				$slika = "knjiznice/nophoto.jpg";
			}
			
		}
			
			

			
		

		$dat = date("Y-m-d H:i:s");	
		
		if($id==0){
			
			$knjiznica = "insert into knjiznica values ('','$novaknj','$adresaknj','$kapacknj','$modknj','$slika','$dat')";
		}
		else
		{
			$knjiznica = "update knjiznica set naziv='$novaknj', adresa ='$adresaknj', kapacitet='$kapacknj', moderatorID ='$modknj', slika='$slika', datAzur='$dat' where idKnjiznica = '$id'";
		}
		
		$ex = DBQuery($knjiznica);
		
		if($ex){
			$poruka = "Uspješan unos podataka!";
			poruka($poruka);
			header("refresh: 0; url=".$_SESSION['uriparams']);
		}
		else
		{
			die("Greška: ".mysqli_error($dbc));
		}
		
	
}


if(isset($_POST['FrmKnjizniceCSV'])){
	
			$mjesto = "knjiznice/";	

			$ime_dat = basename($_FILES['datoteka']['name']);
			
			if($ime_dat != ""){
			$datoteka = $mjesto.$ime_dat;	
			$stavi = move_uploaded_file($_FILES['datoteka']['tmp_name'],$datoteka);
			}
			$dat = date("Y-m-d H:i:s");
			$otvori = fopen($datoteka,'r');

			while(!feof($otvori)){
				
				$podatak = fgets($otvori);
				echo $podatak;
				$novi = explode(";",$podatak);
				if(count($novi)>1){
				//echo "<br>Niz:";
				//print_r($novi);
				if($podatak != "" && $podatak!=null)
				$naziv = $novi[0];
				
				$adresa = $novi[1];
				$kapacitet = $novi[2];
				//$moderator= $novi[3];
				//$slika = $novi[4];
				
				if(PostojanjeKnjizniceCSV($naziv)==true){
				$unoscsv = "update knjiznica set adresa='$adresa',kapacitet='$kapacitet',moderatorID='$aktivni_korisnik_id',slika='',datAzur='$dat' where naziv='$naziv'";	
				}
				else
				{
				$unoscsv = "insert into knjiznica values ('','$naziv','$adresa','$kapacitet','$aktivni_korisnik_id','','$dat')";
				}
				echo "<br>Upit: ".$unoscsv;
				$ex = DBQuery($unoscsv);
				if(!$ex){
					die("Greška: ".mysqli_error($dbc));
				}
				}

			}
	header("Location: knjiznice.php");
}


if(isset($_GET['unoscsv'])){
	?>
	<h2>Unčitajte podatke o knjižnici</h2>
	<form method="post" action="knjiznica.php" name="knjiznicacsv" enctype="multipart/form-data">	
	<div id="forme">
			<table>
			<tbody>
				<tr>
				<td><label for="csv">Učitajte csv datoteku:</label></td><td><input type="file" name="datoteka" id="datoteka"/></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="FrmKnjizniceCSV" value="Učitaj"/></td>
				</tr>
			</tbody>
			</table>
		</div>
	</form>	
	<?php
}


DBClose();
include('podnozje.php');
?>