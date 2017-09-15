<?php
setcookie("koristenjeKolacica","1",time() + (3 * 24 * 60 * 60));
header("location: index.php")
?>