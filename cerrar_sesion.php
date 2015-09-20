<?php

	session_start();
	$_SESSION['logged']="";
    $_SESSION['logged_admin'] = "";
    $_SESSION['logged_user'] ="";
    $_SESSION['user_type']="";
    
    session_destroy();
    header('Location: index.php');
    exit;

?>