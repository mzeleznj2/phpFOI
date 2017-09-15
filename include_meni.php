<?php
function kreiranjeIzbornika() {
    $tip = isset($_SESSION['tip']) ? $_SESSION['tip'] : 0;
    $meni="";
        switch ($tip){
            case 0:
                $meni="<li><a href=\"index.php\"> Početna</a></li>"
                    ."<li> <a href=\"https://barka.foi.hr/WebDiP/2016_projekti/WebDiP2016x130/prijava.php\"> Prijava</a></li>"
                    ."<li><a href=\"registracija.php\"> Registracija</a></li>"
                    ."<li><a href=\"programi_gost.php\"> Programi</a></li>"
                    ."<li><a href=\"dokumentacija.html\"> Dokumentacija</a></li>"
                    ."<li><a href=\"o_autoru.html\"> O autoru</a></li>";
                break;
            case 1:
                $meni= "<li><a href=\"index.php\"> Početna </a></li>"
                    ."<li><a href=\"korisnici.php\">Korisnici</a></li>"
                 ."<li><a href=\"odjava.php\"> Odjava</a></li>";
                break;
            case 2:
                $meni="<li><a href=\"index.php\"> Početna </a></li>"
                     ."<li><a href=\"odjava.php\"> Odjava</a></li>";
                break;
            case 3:
                $meni="<li><a href=\"index.php\"> Početna </a></li>"
                    ."<li><a href=\"programi.php\"> Programi</a></li>"
                    ."<li><a href=\"evidencija.php\"> Evidencija</a></li>"
                    ."<li><a href=\"bodovi.php\"> Bodovi</a></li>"
                    ."<li><a href=\"kuponi.php\"> Kuponi</a></li>"
                    ."<li><a href=\"kosarica.php\"> Košarica</a></li>"
                    ."<li><a href=\"odjava.php\"> Odjava</a></li>";
                break;
        }
        
    return $meni;
}