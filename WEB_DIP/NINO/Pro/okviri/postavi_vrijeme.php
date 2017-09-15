<?php

    include_once ("baza.class.php");    

    function preuzmi(){
        $url = "http://arka.foi.hr/PzaWeb/PzaWeb2004/config/pomak.xml";

        if (!($fp = fopen($url, 'r'))) {
            echo "Problem: nije moguÄ‡e otvoriti url: " . $url;
            exit;
        }

        $xml_string = fread($fp, 10000);
        fclose($fp);

        $domdoc = new DOMDocument;
        $domdoc->loadXML($xml_string);

        $params = $domdoc->getElementsByTagName('pomak');
        $sati = 0;

        foreach ($params as $param) {
            $attributes = $param->attributes;
            foreach ($attributes as $attr => $val) {
                if ($attr == "brojSati") {
                    $sati = $val->value;
                }
            }
        }
        return $sati;
    }

    function spremi_uDB(){ 
        $baza=new Baza();  
        $sati = preuzmi();    
        $upit="UPDATE pomak SET pomak = '$sati';";
        if(!$baza->updateDB($upit)){
            echo "Greska";
        }
    }

    function ispisi_vrijeme(){    
        $vrijeme_servera = time();
        $baza=new Baza();  
        $upit="select pomak from pomak;";
        $podaci=$baza->selectDB($upit);
        $red=$podaci->fetch_array();
        $vrijeme_servera = time();

        $vrijeme_sustava = $vrijeme_servera + ($red[0] * 60 * 60);
        echo "Vrijeme servera: " . date('d.m.Y H:i', $vrijeme_servera) . "<br>";
        echo "Vrijeme sustava: " . date('d.m.Y H:i', $vrijeme_sustava);
    }

?>
