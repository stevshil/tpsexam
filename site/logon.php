<?php
	include 'api/dbfunc.php';
	session_start();
	$_SERVER['SERVER_NAME']="localhost";
	$url = "http://" . $_SERVER['SERVER_NAME'] . "/exam";
	$loginname=$_POST["loginid"];
	$passwd=$_POST["passwd"];
	#$loginname="Admin";
	#$password="admin";


	$data=dbquery("password('$passwd') = (Select Password FROM users,shadow WHERE LoginID='$loginname' AND users.UserID = shadow.UserID) As Result",null,null);
	if ( gettype($data) != "array" ) {
		header("Location: $url");
	}

	if ( $data[0]['Result'] == 1 ) {
		if ( dbupdate("shadow","LastLogon=Now()","WHERE UserID=(SELECT UserID FROM users WHERE LoginID='$loginname')") ) {
			$_SESSION["loggedin"] = "yes";
			$_SESSION["loginname"] = "$loginname";
			$user=dbquery("FullName,LastLogon,LastLogoff,users.UserID","users,shadow","WHERE LoginID='$loginname' AND users.UserID = shadow.UserID");
			$_SESSION["LastLogon"] = $user[0]['LastLogon'];
			$_SESSION["LastLogoff"] = $user[0]['LastLogoff'];
			$_SESSION["UserID"] = $user[0]['UserID'];
			$_SESSION["Name"] = $user[0]["FullName"];
		}
	}
	$data = null;
	$user = null;
	header("Location: $url");
?>
