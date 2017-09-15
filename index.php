<?php
session_start();

include("include_smarty.php");
include("include_meni.php");

$smarty->assign('meni', kreiranjeIzbornika());
$smarty->assign('title', 'Početna');
if (empty($_COOKIE["koristenjeKolacica"])) {
    $smarty->assign('koristenjeKolacica',1);
}

$smarty->display('index.tpl');

?>