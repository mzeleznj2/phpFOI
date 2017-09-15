<?php

    function kreiranjeIzbornika($tip, $imeprezime){
        $meni="";
        switch ($tip){
            case 1:
                $meni="<li class=\"user\"><img src=\"img/user.gif\" alt=\"user\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;".$imeprezime."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href=\"odjava.php\" class=\"nista\" ><img src=\"img/logout.gif\" alt=\"logout\" width=\"25\" /></a></li>"
                     ."<li><a href=\"registracija.php\"><img src=\"img/sign.gif\" alt=\"sign\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Registracija</a></li>"                     
                     ."<li><a href=\"dokumentacija.php\"><img src=\"img/doc.gif\" alt=\"doc\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Dokumentacija</a></li>"
                     ."<li><a href=\"oparkingu.php\"><img src=\"img/about.gif\" alt=\"about\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;O parkiralištu</a></li>"
                     ."<li><a href=\"kupnja.php\"><img src=\"img/ticket.gif\" alt=\"ticket\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Kupnja karte</a></li>"
                     ."<li><a href=\"unosKazna.php\"><img src=\"img/kazna.gif\" alt=\"kazna\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Unos kazne</a></li>"
                     ."<li><a href=\"unosParkinga.php\"><img src=\"img/p.gif\" alt=\"p\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Unos parkinga</a></li>"
                     ."<li><a href=\"evidencija_kaz.php\"><img src=\"img/evidencija.gif\" alt=\"evidence\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Evidencija</a></li>";
                break;
            case 2:
                $meni="<li class=\"user\"><img src=\"img/user.gif\" alt=\"user\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;".$imeprezime."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href=\"odjava.php\" class=\"nista\" ><img src=\"img/logout.gif\" alt=\"logout\" width=\"25\" /></a></li>"
                     ."<li><a href=\"dokumentacija.php\"><img src=\"img/doc.gif\" alt=\"doc\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Dokumentacija</a></li>"
                     ."<li><a href=\"oparkingu.php\"><img src=\"img/about.gif\" alt=\"about\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;O parkiralištu</a></li>"
                     ."<li><a href=\"kupnja.php\"><img src=\"img/ticket.gif\" alt=\"ticket\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Kupnja karte</a></li>"
                     ."<li><a href=\"unosKazna.php\"><img src=\"img/kazna.gif\" alt=\"kazna\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Unos kazne</a></li>"
                     ."<li><a href=\"pregled_kaz.php\"><img src=\"img/kazne.gif\" alt=\"pregled\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Pregled kazni</a></li>"
                     ."<li><a href=\"pregled_kar.php\"><img src=\"img/tickets.gif\" alt=\"pregled\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Pregled karti</a></li>"
                     ."<li><a href=\"evidencija_mod.php\"><img src=\"img/evidencija.gif\" alt=\"evidence\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Evidencija</a></li>";
                break;
            case 3:
                $meni="<li class=\"user\"><img src=\"img/user.gif\" alt=\"user\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;".$imeprezime."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<a href=\"odjava.php\" class=\"nista\" ><img src=\"img/logout.gif\" alt=\"logout\" width=\"25\" /></a></li>"
                     ."<li><a href=\"dokumentacija.php\"><img src=\"img/doc.gif\" alt=\"doc\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Dokumentacija</a></li>"
                     ."<li><a href=\"oparkingu.php\"><img src=\"img/about.gif\" alt=\"about\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;O parkiralištu</a></li>"
                     ."<li><a href=\"kupnja.php\"><img src=\"img/ticket.gif\" alt=\"ticket\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Kupnja karte</a></li>"
                     ."<li><a href=\"pregled_kaz.php\"><img src=\"img/kazne.gif\" alt=\"pregled\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Pregled kazni</a></li>"
                     ."<li><a href=\"pregled_kar.php\"><img src=\"img/tickets.gif\" alt=\"pregled\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;Pregled karti</a></li>";
                break;
            case 0:
                $meni="<li> <a href=\"prijava.php\"><img src=\"img/login.gif\" alt=\"login\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Prijava</a></li>"
                     ."<li><a href=\"registracija.php\"><img src=\"img/sign.gif\" alt=\"sign\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Registracija</a></li>"
                     ."<li><a href=\"dokumentacija.php\"><img src=\"img/doc.gif\" alt=\"doc\" width=\"30\" /> &nbsp;&nbsp;&nbsp;&nbsp;Dokumentacija</a></li>"
                     ."<li><a href=\"oparkingu.php\"><img src=\"img/about.gif\" alt=\"about\" width=\"30\"/> &nbsp;&nbsp;&nbsp;&nbsp;O parkiralištu</a></li>";
        }
        
        return $meni;
    }

?>
