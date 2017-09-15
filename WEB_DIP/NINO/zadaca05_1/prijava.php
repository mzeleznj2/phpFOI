<?php
/*
 * The MIT License
 *
 * Copyright 2014 Jurica Ševa <jurica.seva@foi.hr>.
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
 *
 * @author Jurica Seva <jurica.seva@foi.hr>
 */
#include '_headerLogika.php';
include_once('./okvir/korisnik.php');
include_once('./okvir/bazaPodataka.php'); 
include_once('./okvir/autentikacija.php');
include_once('./okvir/provjeraKorisnika.php');
include './classes/ConfigArray.php';

#PRIJAVA NA SUSTAV I REDIKRECIJA NA POČETNU STRANU
#KORISTIMO OKVIR SA PREDAVANJA
if(isset($_POST['f_user'])){
    
    $f_user = $_POST["f_user"];
    $f_pass = $_POST["f_pass"];
    
    $korisnik = autentikacija($f_user, $f_pass);
    
    #print_r($korisnik);

    if ($korisnik->get_status() == 1) {
        session_start();
        $_SESSION["PzaWeb"] = $korisnik;
        $adresa = 'korisnici.php';
        header("Location: $adresa");
        exit();
    } else {
        $adresa = 'error.php?e=p';
        header("Location: $adresa" . $korisnik->get_status());
        exit();
    }  
}

$aktivnaSkripta = basename($_SERVER['PHP_SELF']); //aktivna skripta
$naziv = "Prijava korisnika";
include '_headerHTML.php';

?>
<article>
<form action='<?php echo $aktivnaSkripta; ?>' method='POST'>
    <label for="korisnickoIme">Korisničko ime</label>
        <input type='text' name='f_user' /><br />
    <label for="lozinka">Lozinka</label>
        <input type='password' name='f_pass' /><br />
    <input type='submit' value='Prijavi se' />
</form>
</article>
<article>
    Registriraj se <a href='registracija.php'>ovdje</a>
</article>
<?php
include '_footer.php';
?>
