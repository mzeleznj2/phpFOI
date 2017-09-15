<?php include ('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> Projekt- knjiznica</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Maja Zeleznjak">
    <meta name="keywords" content="FOI, WebDiP">
    <link rel="stylesheet" type="text/css" href="css/mzeleznj2.css"/>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript" src="js/javascript.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
	<script type="text/javascript">
	
	
	</script>
	
</head>
<body>
<section>
    <header>
        <h1 class="naslovpr"> Projekt Knjižnica</h1>
        <div class="prijava">
        </div>
    </header>
</section>

<nav id="meni">
<ul>
<li><a href="index.php">Početna </a></li>
<?php
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