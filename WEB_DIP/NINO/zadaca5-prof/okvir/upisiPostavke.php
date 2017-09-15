<?php
include_once('aplikacijskiOkvir.php');

provjeraUloge(ADMINISTRATOR);
dnevnik_zapis("Uspješna autorizacija");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Upis razine izvještavanja o pogreškama</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Upis razine izvještavanja o pogreškama</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            echo "Samo za POST metodu!";
            exit;
        }

        $vrste = array("E_ALL", "E_ERROR", "E_WARNING", "E_PARSE", "E_NOTICE");
        $razina = 0;

        foreach ($vrste as $i => $v) {
            if (isset($_POST[$v])) {
                echo "i: " . $i . " v: " . $v . "<br>";
                switch ($i) {
                    case 0: $razina |= E_ALL;
                        break;
                    case 1: $razina |= E_ERROR;
                        break;
                    case 2: $razina |= E_WARNING;
                        break;
                    case 3: $razina |= E_PARSE;
                        break;
                    case 4: $razina |= E_NOTICE;
                        break;
                }
            }
        }

        $zapis = '<?php $razina = ' . $razina . ';' . "\n";
        $zapis .= 'error_reporting($razina);' . "\n";
        $zapis .= '?>' . "\n";
        $fp = fopen("postavke.php", "w");
        fwrite($fp, $zapis);
        fclose($fp);
        ?>
        <br><a href='aplikacija.php'>Početak aplikacije</a><br>
    </body>
</html>
