<?php
//header('Content-Encoding: UTF-8');

header('Content-type: text/html; charset=UTF-8');
$handle = fopen ("knjiznice22.csv","r");

echo '<table border="1"><tr><td>naziv</td><td>ulica</td><td>ulica</td><td>ulica</td><td>ulica</td></tr><tr>';
while ($data = fgetcsv ($handle, 1000, ";")) {
        $data = array_map("utf8_encode", $data); //added
		
        $num = count ($data);
        for ($c=0; $c < $num; $c++) {
            // output data
			//$data = iconv("CP1251", "UTF-8", $data[$c]);
			//$podatak = chr(255).chr(254).iconv("UTF-8", "iso-8859-1", $data[$c]);
			$podatak = utf8_decode($data[$c]);
			//$podatak = mb_convert_encoding($data[$c], 'UTF-8'); 
            echo "<td>$podatak</td>";
        }
        echo "</tr><tr>";
}
?>