<?php
	include 'api/dbfunc.php';
	session_start();
	$_SERVER['SERVER_NAME']="localhost";
	$url = "http://" . $_SERVER['SERVER_NAME'] . "/exam";
	$loginname = $_SESSION['loginname'];

	# Here we need to set the DB of the user to log out data stamp
	if ( dbupdate("shadow","LastLogoff=Now()","WHERE UserID=(SELECT UserID FROM users WHERE LoginID='$loginname')") ) {
		$_SESSION["loggedin"] = null;
		session_destroy();
	}
	header("Location: $url");
?>
