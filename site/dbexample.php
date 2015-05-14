<?php
	session_start();
	$servername = "localhost";
	$username = "TPSADMIN";
	$password = "TPSPASSWORD";
	$dbname = "tpsexam";
	$_SERVER['SERVER_NAME']="localhost";
	$url = "http://" . $_SERVER['SERVER_NAME'] . "/exam";
	$loginname=$_POST["loginid"];
	$passwd=$_POST["passwd"];

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_TIMEOUT,3600);
	}
	catch(PDOException $e) {
		#echo $e->getMessage();
		header("Location: $url");
	}
	#$statement=$conn->prepare("SELECT * FROM users");
	#$statement->execute();
	#$data = $statement->fetchAll(PDO::FETCH_ASSOC);
	#echo $data[0]['FullName'];
	$_SESSION["loggedin"] = "yes";
	#$conn = null;
	header("Location: $url");
?>
