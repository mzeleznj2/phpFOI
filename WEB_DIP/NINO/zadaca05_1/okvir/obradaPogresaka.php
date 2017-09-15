<?php
include_once('postavke.php');

set_error_handler('obradaPogresaka');

function obradaPogresaka($errno, $errstr, $errfile, $errline, $errcontext) {
  echo "Desila se pogreška kod izvršavanja!<br>";
  echo "Datoteka: $errfile<br>";
  echo "Linija: $errline<br>";
  echo "Opis: $errstr<br>";
  echo "Kod: $errno<br>";
  exit;
}
?>
