<?php
	
	session_start();

	$_SESSION  = array();

	// Destroy all session related to user
	session_destroy();

	
	header('location: login.php');
	exit;
?>