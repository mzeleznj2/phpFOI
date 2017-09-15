<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Knjižnica</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="layout/styles/layout.css" type="text/css" />
<script type="text/javascript" src="layout/scripts/jquery.min.js"></script>
<script type="text/javascript" src="layout/scripts/jquery.slidepanel.setup.js"></script>
<script type="text/javascript" src="layout/scripts/jquery.ui.min.js"></script>
<script type="text/javascript" src="layout/scripts/jquery.tabs.setup.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
</head>
<body>
<?php
include("session.php");
include("dbconnect.php");
if($_SESSION['strurl']!=basename($_SERVER['SCRIPT_NAME'])){
$_SESSION['sort']='';
$_SESSION['strurl']=basename($_SERVER['SCRIPT_NAME']);
}
$_SESSION['uriparams']=$_SERVER['REQUEST_URI'];
// echo "<br>URL: ".$_SESSION['strurl'];
// echo "<br>Skripta: ".basename($_SERVER['SCRIPT_NAME']);
?>
<div class="wrapper col0">
  <div id="topbar">
    <div id="slidepanel">
      <div class="topbox">
        <h2>Knjižnica</h2>
        <p>U funkcionalno uređenim prostorima na tri lokacije, ukupne površine 1.330 m2, smješteno je oko 200.000 jedinica knjižnične građe na različitim medijima. Uz 18 stručnih djelatnika zaposleno je i administrativno te pomoćno osoblje, ukupno 22.</p>
        <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>
      </div>

      <div class="topbox">
        <h2>Administratori</h2>
        <form action="#" method="post">
          <fieldset>
            <legend>Admin forma</legend>
            <label for="teachername">Korisničko ime:
              <input type="text" name="teachername" id="teachername" value="" />
            </label>
            <label for="teacherpass">Lozinka:
              <input type="password" name="teacherpass" id="teacherpass" value="" />
            </label>
            <label for="teacherremember">
              <input class="checkbox" type="checkbox" name="teacherremember" id="teacherremember" checked="checked" />
              Zapamti me</label>
            <p>
              <input type="submit" name="teacherlogin" id="teacherlogin" value="Prijava" />
              &nbsp;
              <input type="reset" name="teacherreset" id="teacherreset" value="Poništi" />
            </p>
          </fieldset>
        </form>
      </div>

      <div class="topbox last">
        <h2>Korisnici</h2>
        <form action="#" method="post">
          <fieldset>
            <legend>Korisnička forma</legend>
            <label for="pupilname">Korisničko ime:
              <input type="text" name="pupilname" id="pupilname" value="" />
            </label>
            <label for="pupilpass">Lozinka:
              <input type="password" name="pupilpass" id="pupilpass" value="" />
            </label>
            <label for="pupilremember">
              <input class="checkbox" type="checkbox" name="pupilremember" id="pupilremember" checked="checked" />
              Zapamti me</label>
            <p>
              <input type="submit" name="pupillogin" id="pupillogin" value="Prijava" />
              &nbsp;
              <input type="reset" name="pupilreset" id="pupilreset" value="Poništi" />
            </p>
          </fieldset>
        </form>
      </div>

      <br class="clear" />
    </div>
   <?php
	if(!isset($_SESSION['korime'])){
	?>
    <div id="loginpanel">
      <ul>
        <li class="left">Prijava &raquo;</li>
        <li class="right" id="toggle"><a id="slideit" href="#slidepanel">Korisnici</a><a id="closeit" style="display: none;" href="#slidepanel">Zatvori panel</a></li>
      </ul>
    </div>
	<?php
	}
	else{
	?>
	<div id="loginpanel">
	<ul>
	<li class="left">Vi ste: <?php echo $_SESSION['korime'];?></li>
	<li class="right"><a href="odjava.php">Odjava</a></li>
	</ul>
	</div>
	<?php
	}
	?>
    <br class="clear" />
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col1">
  <div id="header">
    <div id="logo">
      <h1><a href="index.php">Knjižnica</a></h1>
      <p>Osvježite svoje znanje</p>
    </div>
    <div class="fl_right">
      <ul>
        <li class="last"><a href="#">Pretraga</a></li>
        <li><a href="#">Mapa weba</a></li>
        <?php
		if(!isset($_SESSION['korime'])){
		?>
        <li><a href="knjiga.php?reg=1">Registracija</a></li>
		<?php
		}
		?>
      </ul>
      <p>Tel: xxxxx xxxxxxxxxx | Mail: info@domain.com</p>
    </div>
    <br class="clear" />
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col2">
  <div id="topnav">
    <ul>

      <li><a href="index.php">Home</a></li>
      <li><a href="knjiznice.php">Knjižnice</a>
        <ul>
          <li><a href="knjiznica.php?unos=1">Unos</a></li>
          <li><a href="#">Ispis</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
	  <li><a href="kategorije.php">Kategorije</a>
        <ul>
          <li><a href="kategorija.php?unos=1">Unos</a></li>
          <li><a href="#">Ispis</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
      <li><a href="knjiznice.php">Knjige</a>
        <ul>
          <li><a href="knjiga.php?unos=1">Unos</a></li>
          <li><a href="#">Ispis</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
	   <li><a href="clanovi.php">Članovi</a>
        <ul>
          <li><a href="#">Unos</a></li>
          <li><a href="#">Ispis</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
	   <li class="active"><a href="posudrez.php">Posudbe/Rezervacije</a>
        <ul>
          <li><a href="posudrez.php?rezervacije=1">Rezervacije</a></li>
          <li><a href="posudrez.php?posudbe=1">Posudbe</a></li>
          <li><a href="#">Ažuriranje i brisanje</a></li>
          <li class="last"><a href="#">Suspendisse</a></li>
        </ul>
      </li>
	  <!--
      <li><a href="#">Our Services</a></li>
	  -->
      <li class="last"><a href="lokacije.php">Lokacije</a></li>
    </ul>
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col3">
  <div id="featured_slide">
    <div id="featured_wrap">
      <ul id="featured_tabs">
        <li><a href="#fc1">Gradska knjižnica "Metel Ožegović"<br />
          <span>Trg Slobode 8a, Varaždin</span></a></li>
        <li><a href="#fc2">Gradska knjižnica "Ivanec"<br />
          <span>Ivanečka 8a, Ivanec</span></a></li>
        <li><a href="#fc3">Gradska knjižnica "Nikola Zrinski"<br />
          <span>Trg Republike 4, Čakovec</span></a></li>
        <li class="#last"><a href="#fc4">Gradska Knjižnica "Prelog"<br />
          <span>Glavna ulica 5, Prelog</span></a></li>
		  Stranice:
      </ul>
	  
      <div id="featured_content">
        <div class="featured_box" id="fc1"><img src="images/demo/1.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc2"><img src="images/demo/2.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc3"><img src="images/demo/3.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc4"><img src="images/demo/4.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
      </div>
	  
    </div>
  </div>
  
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col4">
  <div id="container">
<?php
DBConnect();
$sqlstr = "select idKnjiznica from knjiznica";
$ex = DBQuery($sqlstr);
$redovi = mysqli_num_rows($ex);
$dat="stranice.txt";
$otvori = fopen($dat,'r');
$velpod = trim(fgets($otvori));
$br_strana = ceil($redovi/$velpod);


$knjiznice = "select 
knj.idKnjiznica,
  knj.naziv,
  knj.adresa,
  knj.kapacitet,
  knj.slika,
  concat(kor.ime,' ',kor.prezime),
  knj.datAzur
from knjiznica knj, korisnik kor where knj.moderatorID = kor.idKorisnik";
$_SESSION['url']='';

if(isset($_GET['sort'])){
	
	if($_GET['sort']=='kasc'){
		$_SESSION['sort']=" order by knj.kapacitet asc";
	}
	if($_GET['sort']=='kdesc'){
		$_SESSION['sort']=" order by knj.kapacitet desc";
	}
	if($_GET['sort']=='zasc'){
		$_SESSION['sort']=" order by concat(knj.naziv,', ',knj.adresa) asc";
	}
	if($_GET['sort']=='zdesc'){
		$_SESSION['sort']=" order by concat(knj.naziv,', ',knj.adresa) desc";
	}
	
	
	$_SESSION['url']=$_SERVER['QUERY_STRING'];
}
else
{
	if(!isset($_SESSION['sort'])){
	$_SESSION['sort']='';	
	}

}
$knjiznice.=$_SESSION['sort'];
$knjiznice.=" limit ".$velpod;

if(isset($_GET['stranica'])){
$knjiznice = $knjiznice . " OFFSET " . (($_GET['stranica'] - 1) * $velpod);
$aktivna = $_GET['stranica'];
}
else
{
$aktivna = 1;
}

echo "<br>Upit: ".$knjiznice;
$qu = mysqli_query($dbc,$knjiznice);

	$up = "&#9650";
	$down = "&#9660";
	$nazup = "<a href='knjiznice.php?sort=zasc' title='Sort Ascending'>$up</a>";
	$nazdown = "<a href='knjiznice.php?sort=zdesc' title='Sort Descending'>$down</a>";
	$godup = "<a href='knjiznice.php?sort=kasc' title='Sort Ascending'>$up</a>";
	$goddown = "<a href='knjiznice.php?sort=kdesc' title='Sort Descending'>$down</a>";
	$tablica = "<div class='datagrid'>";
	$tablica.="<table>";
	$tablica.="<thead>";
	$tablica.="<tr>";
	$tablica.="<th>ID knjižnica</th><th>Naziv <br>$nazup $nazdown</th><th>Adresa</th><th>Kapacitet <br>$godup $goddown</th><th>Datum ažuriranja</th><th>Moderator</th>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<th>Radnja</th>";	
	}
	$tablica.="</tr>";
	$tablica.="</thead>";
	$tablica.="<tbody>";
	$red=0;
	while(list($id,$naziv,$adresa,$kapacitet,$slika,$moderator,$datazur)=mysqli_fetch_array($qu)){
		$datazur=date("d.m.Y H:i:s",strtotime($datazur));
		$azur = "<a href='knjiznica.php?azuriraj=$id'><img src='images/update.png' width='16px' height='16px'></a>";
		$uri = $_SERVER['QUERY_STRING'];
		$brisi = "<a href='#' onclick=\"ProvjeraBrisanjaKategorije('$id','$naziv','$uri')\"><img src='images/delete.png' width='16px' height='16px'></a>";

	$red++;
	if($red%2==0){
		$redclass="dark";
	}
	else
	{
		$redclass="light";
	}
	$tablica.="<tr>";	
	$tablica.="<td>$id</td><td>$naziv</td><td>$adresa</td><td>$kapacitet</td><td>$datazur</td><td>$moderator</td>";
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	$tablica.="<td>";
	$tablica.="$azur $brisi";
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
$tablica.="<li><a href=\"rezervacije.php?stranica=" .$prethodna . "\"><span>Prethodna</span></a></li>";	
}
for($a=1;$a<=$br_strana;$a++){
	$tablica.="<li><a";
	if($aktivna==$a){
		$tablica.=" class='active'";
	}
	$tablica.=" href='rezervacije.php?stranica=$a'>$a</a></li>";
}
if($aktivna < $br_strana){
$sljedeca = $aktivna + 1;
$tablica.="<li><a href=\"rezervacije.php?stranica=" .$sljedeca . "\"><span>Slijedeća</span></a></li>";	
}
$tablica.="</ul>";
$tablica.="</div>";
$tablica.="</td>";
$tablica.="</tr>";
$tablica.="</tfoot>";	
$tablica.="</table>";
$tablica.="</div>";
DBClose();
?>
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col5">
  <div id="footer">
    <div id="newsletter">
      <h2>Stay In The Know !</h2>
      <p>Please enter your email to join our mailing list</p>
      <form action="#" method="post">
        <fieldset>
          <legend>News Letter</legend>
          <input type="text" value="Enter Email Here&hellip;"  onfocus="this.value=(this.value=='Enter Email Here&hellip;')? '' : this.value ;" />
          <input type="submit" name="news_go" id="news_go" value="GO" />
        </fieldset>
      </form>
      <p>To unsubscribe please <a href="#">click here &raquo;</a></p>
    </div>
    <div class="footbox">
      <h2>Lacus interdum</h2>
      <ul>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Lorem ipsum dolor</a></li>
        <li><a href="#">Suspendisse in neque</a></li>
        <li class="last"><a href="#">Praesent et eros</a></li>
      </ul>
    </div>
    <div class="footbox">
      <h2>Lacus interdum</h2>
      <ul>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Lorem ipsum dolor</a></li>
        <li><a href="#">Suspendisse in neque</a></li>
        <li class="last"><a href="#">Praesent et eros</a></li>
      </ul>
    </div>
    <div class="footbox">
      <h2>Lacus interdum</h2>
      <ul>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Praesent et eros</a></li>
        <li><a href="#">Lorem ipsum dolor</a></li>
        <li><a href="#">Suspendisse in neque</a></li>
        <li class="last"><a href="#">Praesent et eros</a></li>
      </ul>
    </div>
    <br class="clear" />
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col6">
  <div id="copyright">
    <p class="fl_left">Copyright &copy; 2015 - All Rights Reserved - <a href="#">Maja Železnjak</a></p>
    <p class="fl_right">Studij: <a target="_blank" href="http://foi.unizg.hr" title="FOI">FOI</a></p>
    <br class="clear" />
  </div>
</div>
</body>
</html>