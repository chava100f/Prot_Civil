<?php

	session_start();
	$_SESSION['logged']="";
    $_SESSION['logged_admin'] = "";
    
    session_destroy();
    header('Location: index.php');
    exit;

?>