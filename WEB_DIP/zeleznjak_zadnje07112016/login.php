<!DOCTYPE html>
<html>
<head>
    <title> Projekt- knjiznica</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Maja Zeleznjak">
    <meta name="keywords" content="FOI, WebDiP">
    <link rel="stylesheet" type="text/css" href="css/mzeleznj2.css"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript" src="js/javascript.js"></script>
	<script type="text/javascript">

	$(document).ready(function(){
	
   $("#login").click(function(){
	   
		korime=$("#korime").val();
        sifra=$("#sifra").val();

         $.ajax({
            type: "POST",
           url: "logiraj2.php",
            data: "korime="+korime+"&sifra="+sifra,


            success: function(html){
			//alert("HTML: "+html)
			  if(html=='true')
              {
				window.location.href="index.php";				 
              }
			  else if(html=='neakt'){
				 $("#greska").html("Vaš račun nije još aktiviran!") 
			  }
              else
              {
                    $("#greska").html("Pogrešno korisničko ime ili šifra!");
              }
            },
            beforeSend:function()
			{
                 $("#greska").html("Pričekajte...")
            }
        });
         return false;
    });
});
</script>
</head>
<body>
<section>
    <header>
        <h1 class="naslov"> Projekt Knjižnica</h1>
        <div class="prijava">
        </div>
    </header>
</section>

<nav id="meni">
<ul>
<li><a href="index.php">Početna </a></li>
<?php
include ('session.php');
$skripta=basename($_SERVER['SCRIPT_NAME']);
switch($aktivni_korisnik_tip){
	
	case 1:
	?>
            <li><a href="admin.php">Admin zona</a></li>
            <li><a href="statistikalike.php">Statistika like knjiga</a></li>
            <li><a href="statistikalikekateg.php">Statistika like kategorija</a></li>
            <li><a href="dnevnik.php">Dnevnik</a></li>
            <li><a href="clanovi.php">Ispis korisnika</a></li>
			<li><a href="kategorije.php">Kategorije</a></li>
			<li><a href="knjige.php">Knjige</a></li>
			<li><a href="knjigetop10.php">Top 10 posudjenih knjiga</a></li>
			<li><a href="knjiznice.php">Knjižnice</a></li>
			<li><a href="posudrez.php?rezervacije=1">Rezervacije</a></li>
			<li><a href="posudrez.php?posudbe=1">Posudbe</a></li>
			<li><a href="dokumentacija.html">Dokumentacija</a></li>
			<li><a href="o_autoru.html">O autoru</a></li>

	<?php
	break;
	case 2:
	?>
            
            <li><a href="clanovi.php">Ispis korisnika</a></li>
			<li><a href="knjige.php">Knjige</a></li>
			<li><a href="knjigetop10.php">Top 10 posudjenih knjiga</a></li>
			<li><a href="kategorije.php">Kategorije</a></li>
			<li><a href="knjiznice.php">Knjižnice</a></li>
			<li><a href="posudrez.php?rezervacije=1">Rezervacije</a></li>
			<li><a href="posudrez.php?posudbe=1">Posudbe</a></li>
			<li><a href="dokumentacija.html">Dokumentacija</a></li>
			<li><a href="o_autoru.html">O autoru</a></li>
	<?php
	break;
	case 3:
	?>
            <li><a href="clanovi.php">Ispis korisnika</a></li>
			<li><a href="kategorije.php">Kategorije</a></li>
			<li><a href="knjige.php">Knjige</a></li>
			<li><a href="knjigetop10.php">Top 10 posudjenih knjiga</a></li>
			<li><a href="posudrez.php?rezervacije=1">Rezervacije</a></li>
			<li><a href="posudrez.php?posudbe=1">Posudbe</a></li>
			<li><a href="dokumentacija.html">Dokumentacija</a></li>
			<li><a href="o_autoru.html">O autoru</a></li>
	<?php
	break;
	default:
	?>
			<li><a href="knjiznice.php">Knjižnice</a></li>
            <li><a href="knjigetop10.php">Top 10 posudjenih knjiga</a></li>
            <li><a href="dokumentacija.html">Dokumentacija</a></li>
			<li><a href="o_autoru.html">O autoru</a></li>
			
		    
    
<?php
	
}
			if(!isset($_SESSION['korime'])){
				echo '<li><a href="login.php">Prijava</a></li>';
				echo '<li><a href="clan.php?reg=1">Registracija</a></li>';
			}
			else
			{
				echo '<li><a href="odjava.php">Odjava</a></li>';
				
				
			}
			?>
</ul>
</nav>
<?php

if(session_id()==""){
	session_start();
}
	$user="";
	if(isset($_COOKIE['Login'])){
		
		$user = $_COOKIE['Login'];
	}
	//action="logiraj.php" method="POST"
	if(empty($_SESSION['korime'])){
	?>
	<div id="forme">
	<form>
	<!--
          <fieldset>
		  <legend>Prijava</legend>
		  -->
		  <table border="0">
          <tr>
            <td><label for="korime">Korisničko ime:</td>
              <td><input type="text" name="korime" id="korime" value="<?php echo $user; ?>" /></td>
            </label>
		  </tr>
		  <tr>
            <td><label for="lozinka">Lozinka:</td>
              <td><input type="password" name="sifra" id="sifra" value="" /></td>
            </label>
		  </tr>
		  <tr>
            <td><label for="zapamtime"></td>
              <td><input class="checkbox" type="checkbox" name="zapamtime" id="zapamtime" checked="checked" />
              Zapamti me</label></td>
			</tr>
			<tr>
              <td><input type="submit" name="login" id="login" value="Prijava" /></td>
              <td><input type="reset" name="reset" id="reset" value="Poništi" /></td>
			</tr>			
			<tr>
              <td colspan='2'><a href='clan.php?zaboravljena=1'>Zaboravljena lozinka?</a></td>
			</tr>
			</table>
			</form>
			<!--
          </fieldset>
 -->		  
</div>		  
        
		<div id="greska"></div>
		
		<?php
		}
		else
		{
			echo "vi ste: ".$_SESSION['korime'];
		}
		?>
<footer id="footer">
    <a href="http://validator.w3.org/check?uri=http://barka.foi.hr/WebDiP/2015/zadaca_01/mzeleznj2/"><img
            src="./img/HTML5.png" height="50" width="50" alt="valid_html"/></a>
    <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://barka.foi.hr/WebDiP/2015/zadaca_01/mzeleznj2"><img
            src="./img/CSS3.png" height="50" width="50" alt="valid_css"/> </a>
    <p> Vrijeme potrebno za izradu aktivnog dokumenta: 8h</p>
    <p>&copy; 2016 M.Zeleznjak</p>
</footer>
</body>
</html>