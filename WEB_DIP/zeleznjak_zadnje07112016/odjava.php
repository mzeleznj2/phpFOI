<?php

if(session_id()==""){
	session_start();
}

if(isset($_SESSION['korime'])){
	
	session_destroy();
	header("Location: index.php");
}

?>