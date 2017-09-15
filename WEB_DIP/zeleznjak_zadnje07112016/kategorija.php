<?php
include('dbconnect.php');
include('zaglavlje.php');


PeriodAktivnosti($skripta);
DBConnect();


if(isset($_GET['brisi'])){
	$idkateg = $_GET['brisi'];
	$kategorija = $_GET['kategorija'];
	$bris = "delete from kategorija where idKategorija = '$idkateg'";
	$ex = DBQuery($bris);
	
	if($ex){
		$poruka = "Kategorija pod nazivom ".$kategorija." uspješno izbrisana!";
		poruka($poruka);
		header("refresh: 0; url=".$_SESSION['strurl']);
	}
	
}


if(isset($_GET['like'])){
	
	$idkateg = $_GET['like'];
	
	if(isset($_GET['prvi'])){
	$like = "insert into statkategorija values ('',1,'$idkateg','$aktivni_korisnik_id')";	
	}
	else
	{
	$like = "update statkategorija set svidja= 1 where idKategorija='$idkateg' and idKorisnik = '$aktivni_korisnik_id'";
	}
	
	
	$ex = DBQuery($like);
	
	header("Location: kategorije.php");
}


if(isset($_GET['unlike'])){
	
	$idkateg = $_GET['unlike'];
	
	if(isset($_GET['prvi'])){
	$unlike = "insert into statkategorija values ('',0,'$idkateg','$aktivni_korisnik_id')";	
	}
	else
	{
	$unlike = "update statkategorija set svidja= 0 where idKategorija='$idkateg' and idKorisnik = '$aktivni_korisnik_id'";
	}
	$ex = DBQuery($unlike);
	
	header("Location: kategorije.php");
}

if(isset($_GET['unos']) || isset($_GET['azuriraj'])){
	ZapisiUDnevnik("Unos/ažuriranje kategorija",$skripta,$aktivni_korisnik_id);
	if(isset($_GET['azuriraj'])){
		$idkateg = $_GET['azuriraj'];
		
		$upit = "select 
		idKategorija, zanr, idKnjiznica from kategorija where idKategorija = '$idkateg'";
		$qu = DBQuery($upit);
		list($id,$naziv,$knjiznica)=mysqli_fetch_array($qu);
	}
	else
	{
	$id=0;
	$naziv="";
	$knjiznica="";
	}
	?>
	<h1>Unesite podatke o kategoriji</h1>

<form method="post" action="kategorija.php" name="kategorija" enctype="multipart/form-data" onsubmit="return ValidKategorijaForm(this)">	
			<table>
			<tbody>
			<input type="hidden" name="novi" value="<?php echo $id;?>"/>
				<tr>
					<td><label for="naziv">Naziv:</label></td>
					<td><input type="text" name="naziv" id="naziv" value="<?php echo $naziv;?>"/><label id="lbNazivKategorija"></label></td>
				</tr>				
				<tr>
				<td><label for="tip">Knjižnica:</label></td>
					<td>
					<select name="knjiznicaodb" id="knjiznicaodb" onchange="DodavanjeKnjiznice()">
					<?php
					$knjiznice = PopisKnjiznica();
					foreach($knjiznice as $idknjiz=>$naziv){
						echo "<option value='$idknjiz'";
						if($idknjiz == $knjiznica){
							echo " selected";
						}
						echo ">$naziv</option>";
					}
					?>
					<option value="nkat">Dodaj novu...</option>
					</select>
					<label id="lbKnjiznica"></label></td>
				</tr>
				<tr id="KnjigSkr" style="display: none;">
				<td>Nova knjižnica:</td><td> <input type="text" name="NazivKnjiznica" id="NazivKnjiznica"><label id="lbNazivKnjiznica"></label></td>
				</tr>
				<tr id="AdresaSkr" style="display: none;">
				<td>Adresa:</td><td> <input type="text" name="AdresaKnjiznica" id="AdresaKnjiznica"><label id="lbAdresaKnjiznica"></label></td>
				</tr>
				<tr id="KapSkr" style="display: none;">
				<td>Kapacitet:</td><td> <input type="text" name="KapacitetKnjiznica" id="KapacitetKnjiznica"><label id="lbKapacitetKnjiznica"></label></td>
				</tr>
				<tr id="ModSkr" style="display: none;">
				<td>Moderator:</td><td>
				<select name="ModeratorKnjiznica" id="ModeratorKnjiznica">
					<?php
					$moderatori = Moderatori();
					foreach($moderatori as $idmod=>$moderator){
					echo "<option value='$idmod'>$moderator</option>";
					}
					?>
				</select>
				<label id="lbModeratorKnjiznica"></label></td>
				</tr>
				<tr id="SlikaSkr" style="display: none;">
				<td><label for="slika">Slika:</label></td><td><input type="file" name="slika" id="slika"/></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="FrmKategorija" value="Unesi"/></td>
				</tr>
				</tbody>
			</table>
		</form>	
<?php	
}

if(isset($_POST['FrmKategorija'])){
	
		$id=$_POST['novi'];
		$naziv = $_POST['naziv'];
		$idKnjiz = $_POST['knjiznicaodb'];
		$dat = date("Y-m-d H:i:s");	
		if(!empty($_POST['NazivKnjiznica'])){
			
			$novaknj = $_POST['NazivKnjiznica'];
			$adresaknj = $_POST['AdresaKnjiznica'];
			$kapacknj = $_POST['KapacitetKnjiznica'];
			$modknj = $_POST['ModeratorKnjiznica'];
			
			$mjesto = "knjiznice/";	

			$ime_dat = basename($_FILES['slika']['name']);
			
			if($ime_dat != ""){
			$slika = $mjesto.$ime_dat;	
			$stavi = move_uploaded_file($_FILES['slika']['tmp_name'],$slika);
			}
			
			$knjiznica = "insert into knjiznica values ('','$novaknj','$adresaknj','$kapacknj','$modknj','$slika','$dat')";
			$ex = DBQuery($knjiznica);
			$idKnjiz = mysqli_insert_id($dbc);
		}

		
		
		if($id==0){
			
			$novi="insert into kategorija values ('','$naziv','$idKnjiz','$dat')";
		}
		else
		{
			$novi = "update kategorija set zanr='$naziv', idKnjiznica='$idKnjiz', datAzur='$dat' where idKategorija='$id'";
		}
		
		$ex = DBQuery($novi);
		
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

DBClose();
include('podnozje.php');
?>