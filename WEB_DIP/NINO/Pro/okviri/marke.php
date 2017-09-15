<?php

    include_once ("baza.class.php");
    $baza=new Baza();
    
    $marke=array("Abarth","Alfa Romeo","Asia Motors","Aston Martin","Audi","Austin","Autobianchi","Bentley","BMW","Bugatti","Buick","Cadillac","Carver","Chevrolet","Chrysler","Citroen","Corvette","Dacia","Daewoo","Daihatsu","Daimler","Datsun","Dodge","Donkervoort","Ferrari","Fiat","Fisker","Ford","FSO","Galloper","Honda","Hummer","Hyundai","Infiniti","Innocenti","Iveco","Jaguar","Jeep","Josse","Kia","KTM","Lada","Lamborghini","Lancia","Land Rover","Landwind","Lexus","Lincoln","Lotus","Marcos","Maserati","Maybach","Mazda","Mega","Mercedes","Mercury","MG","Mini","Mitsubishi","Morgan","Morris","Nissan","Noble","Opel","Peugeot","PGO","Pontiac","Porsche","Princess","Renault","Rolls-Royce","Rover","Saab","Seat","Skoda","Smart","Spectre","SsangYong","Subaru","Suzuki","Talbot","Tesla","Think","Toyota","Triumph","TVR","Volkswagen","Volvo","Yugo");   
    
    foreach ($marke as &$value) {
        echo $value;
//        $upit="insert into marka VALUES('default','$value');";
//        if($baza->updateDB($upit)){
//            echo "-->Upisan<br>";
//        }       
    }
?>