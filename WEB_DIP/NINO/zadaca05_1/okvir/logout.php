<?php
include_once('aplikacijskiOkvir.php');

dnevnik_zapis("Odjava korisnika");

session_start();
unset($_SESSION["PzaWeb"]);
session_destroy();
header("Location: index.php");

?>