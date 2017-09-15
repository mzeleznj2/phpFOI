<?php
/*
 * The MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
  *
 * @author Jurica Ševa <jurica.seva@foi.hr>
 */

include 'classes/Baza.class.php';
include './classes/Sesija.class.php';
include './classes/ConfigArray.php';
include './classes/CRUD.class.php';

#objekti za bazu i forme
$baza = new baza();
$sesija = new Sesija();

/*
 * KONFIGURACIJSKE VARIJABLE
 * ime aktivne skripte = ime tablice u bazi
 * $aktivnaSkripta -> trenutno aktivna skripta
 * $tablica -> ime tablice u bazi podataka na kojoj $aktivanSkripta radi CRDU kontrole (ovisno o prosljeđenom parametru)
 */
$aktivnaSkripta = basename($_SERVER['PHP_SELF']); //aktivna skripta
$tipKorisnika = $sesija::provjeriSesiju();
echo $tipKorisnika;

#PROVJERA SESIJE
if(!in_array($aktivnaSkripta, $preskociSesija) && ($tipKorisnika == null)){
    header("Location: prijava.php");
} else {
    #kreiranje CRUD objekta
    $crud  = new CRUD($_SESSION['ID'],$_SESSION['tip']);
}

#KONTROLA NA TABLICU ILI STATIČNU STRANICU
if (!array_key_exists($aktivnaSkripta,$preskociTablica)){
    list ($tablica,$ekstenzija) = explode(".", $aktivnaSkripta); //ime aktivne tablice
    $opis ="DESCRIBE {$tablica}";
    $tablicaStruktura = $baza->selectDB($opis); //struktura aktivne tablice  
    #$naziv = $crudForm::$imena[$tablica];
} else {
    $naziv = $preskociTablica[$aktivnaSkripta];
}



?>
<html>
    <head>
        <meta charset="utf-8"> 
        <title><?php echo $naziv; ?></title>
        <link rel="stylesheet" type="text/css" media="screen and (min-width: 480px)" href="CSS/pozicioiniranje.css" />
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 480px)" href="CSS/pozicioiniranje_small.css" />
        <link href="CSS/global.css" rel="stylesheet" type="text/css" >
        <!-- <link rel="stylesheet" type="text/css" href="CSS/izbornikVodoravno.css"> -->
        <link rel="stylesheet" type="text/css" media="screen and (min-width: 730px)" href="CSS/izbronikOkomito.css" /> <!-- ako piše min-device-width onda to je baš device rezolucija-->
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 730px)" href="CSS/izbronikOkomito_small.css" />
    </head>
    <body>
        <header>
        STAVITI SLIKU
        </header>
        <?php
            if(!in_array($aktivnaSkripta, $preskociSesija)){
                $crud::kreirajOkomitiMeni();
            }

        ?>
        <section id='sadrzaj'>