<?php

    include_once ("okviri/korisnik.class.php");  
    include_once ("okviri/meni.php");  
    include_once ("okviri/postavi_vrijeme.php");
    $korisnik=new Korisnik();
    session_start();
    if (isset($_SESSION["prijava"])) {
        $korisnik=$_SESSION["prijava"];
        $tip=$korisnik->get_tip();
        $imeprezime=$korisnik->get_ime_prezime();
    }

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Parkeralište - Dokumetacija</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/css_nzvorc.css" />
        <script src="js/vendor/modernizr.js"></script>
    </head>
    <body>

        <header>
            <div style="width: 50%; display: inline-block; box-sizing: border-box;">arkeralište -  eParking                
            </div>
              <div style="text-align: right; font-size: 14px; width: 45%; display: inline-block; line-height: 20px; ">
                      <?php 
                        echo ispisi_vrijeme();
                      ?>
              </div>
        </header>
        
        <hr class="jedan"/>
        <hr class="dva"/>
        <hr class="tri"/>

        <nav id="meni" style="height: 200px">
            <ul>
                <?php
                    echo kreiranjeIzbornika($tip, $imeprezime);
                ?>
            </ul>
        </nav>
        <section id="sadrzaj" style="margin-left: 10px;">
            <article>
                <p class="naslov">Dokumetacija</p>
                <h5>Opis projektnog zadatka</h5>
                <p style="margin-left: 10px;">Potrebno je bilo napraviti sustav koji služi za organizaciju, evidenciju i naplatu parkinga na organiziranom parkingu. Sustav bi trebao imati 4 uloge, 'Neregistrirani korisnik', 'Registrirani korisnik (Vozač)', 'Moderator (Zaposlenik)' te 'Administrator'. <br>
                Jedne od glavnih funkcionalnosti koje bi sustav trebao imati su: registracija na sustav, prijava te odjava sa sustava, kupnja karte te uvid i plaćanje kazni za registriranog korisnika, unos kazne za registriranog korisnika (unosi moderator), te evidincija korištenja aplikacije kojom se koristi samo administrator. Koristiti različite tehnologije u izradi sustava. </p>                
                <h5>Opis projektnog riješenja</h5>
                <p style="margin-left: 10px;">Napravljen je sutav služi za organizaciju, evidenciju i naplatu parkinga na organiziranom parkingu te ima sve 4 uloge, 'Neregistrirani korisnik', 'Registrirani korisnik (Vozač)', 'Moderator (Zaposlenik)' te 'Administrator'. Zadovoljene su sve funkcionalnosti kao što su:  <br>
                    <b>Za nerigistiranog korisnika:</b> registracija na sustav, aktivacija sustava e-mailom sa 24 satnom aktivacijom,<br>
                    <b>Za registriranog korisnika:</b> uspješna prijava te odjava sa sustava, kupnja karte, pregled  karti, te uvid i plaćanje kazni,<br>
                    <b>Za moderatora:</b> unos kazne za registriranog korisnika, pregled svih kati za njegovo parkiralište,<br>
                    <b>Za administratora:</b> evidincija korištenja aplikacije, tocnije pregled svih kazni i karti pregled korisnika, parkirališta, dnevnika i unos parkirališta.</p>                
                <h5>ERA model za sustav:</h5>
                <p style="text-align: center;"><img src="img/ERA.PNG" alt="ERA" /></p>
                <h5>Popis i opis skripata, mapa mjesta, navigacijski dijagram</h5>
                <p style="margin-left: 10px;">
                    Popis i opis skripata: </p>
                    <ul style="margin-left: 20px;">
                        <li><b>aktivacija.php</b> - služi za aktivaciju korisnika</li>
                        <li><b>aktiviranje.php</b> - služi za aktivaciju korisnika od strane admina</li>
                        <li><b>dokumentacija.php</b> - trenutna stranica</li>
                        <li><b>evidencija_kar.php</b> - evidencija karti od strane admina</li>
                        <li><b>evidencija_kaz.php</b> - evidencija kazni od strane admina</li>
                        <li><b>evidencija_kor.php</b> - evidencija korisnika od strane admina</li>
                        <li><b>evidencija_mod.php</b> - evidencija moderatora</li>
                        <li><b>evidencija_par.php</b> - evidencija parkiralista od strane admina</li>
                        <li><b>evidencija_sustava.php</b> - evidencija sustava, odnosno dnevnik rada</li>
                        <li><b>index.php</b> - početna stranica sustava</li>
                        <li><b>izmjena.php</b> - služi za spremanje pomaka u bazu</li>
                        <li><b>kupnja.php</b> - kupnja karte </li>
                        <li><b>odjava.php</b> - odjava sa sustava</li>
                        <li><b>odustani.php</b> - odustajanje od kupnje karte</li>
                        <li><b>oparkingu.php</b> - stranica s popisom parkirališta za neregistriranog korisnika</li>
                        <li><b>placanje.php</b> - placanje kazne </li>
                        <li><b>placeno.php</b> - služi za potvrdu plaćanja</li>
                        <li><b>potvrda.php</b> - služi za potvrdu kupnje karte</li>
                        <li><b>pregled_kar.php</b> - pregled karti prijavljenog korisnika</li>
                        <li><b>pregled_kaz.php</b> - pregled kazni prijavljenog korisnika</li>
                        <li><b>prijava.php</b> - prijava u sutav</li>
                        <li><b>promjena vremena.php</b> - promjena virtualnog vremena</li>
                        <li><b>registracija.php</b> - služi za registraciju korisnika</li>
                        <li><b>unosKazna.php</b> - usnos kazne od strane zaposlenika</li>
                        <li><b>unosParkinga.php</b> - usnos parkinga od strane admina</li>
                        <li><b>uspjesno.php</b> - služi za ispis poruke uspješne radnje</li>
                        <li><b>zabranjeno.php</b> - služi za ispis poruke zabranjene radnje</li>      
                    </ul>
                 <p style="margin-left: 10px;">
                    Mapa mjesta: </p>
                 <ul>
                     <li>WebDiP2013_096</li>
                     
                        <ul>
                           <li>okviri</li>
                           <li>privatno</li>
                           <li>css</li>
                           <li>img</li>
                           <li>js</li>
                           <ul>
                            <li>foundation</li>
                            <li>vendor</li>                          
                           </ul>
                        </ul>                    
                 </ul>
               <p style="margin-left: 10px;">
                    NAvigacijski dijagram: </p>
               <p style="text-align: center;"><img src="img/navigacijski_dijagram.png" alt="navi" /></p>
               
               <h5>Popis i opis korištenih tehnologija i alata</h5>
               <ul style="margin-left: 20px;">
                   <li><a href="http://foundation.zurb.com/"><b>Foundation</b></a> - Razvojni okvir (framework) za razvoj web stranica  i  aplikacija, sadrži HTML elemente i CSS predloške</li>
               </ul>
               
               <h5>Popis i opis vanjskih modula i biblioteka</h5>
               <ul style="margin-left: 20px;">
                  <li><a href="http://jquery.com/"><b>JQuery</b></a> - JavaScrip biblioteka koja olakšava posao tako da omogućava lakšu manipulaciju HTML, ajax-om, animacijom i slično</li>
                  <li><a href="http://www.datatables.net/"><b>DataTables</b></a> - plug-in za JQuery JavaScript biblioteke</li>           
               </ul>
               
                
                 
            </article>
        </section>    
        <footer id="footer" style="position: relative;">
            <img src="img/html-5.png" alt="valid_html" />
            <img src="img/css.png" alt="valid_css" style="margin-bottom: 3px;"/><br>
            WebDiP 2014 &#169; Nino Žvorc
        </footer>
    </body>
</html>


