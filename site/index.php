<?php

	include 'includes.php';
	session_start();
	if ( ! isset ($_GET["page" ]) ) {
		$page="start";
		$_SESSION["page"]="start";
	} else {
		$page=$_GET["page"];
		$_SESSION["page"]=$_GET["page"];
	}
?>
<html><head>
<title>TPS Services Ltd Exam Centre</title>
<meta name='description' content='TPS Services Ltd Exam Centre'>
<meta name='keywords' content='TPS Services Ltd Exam Centre'>
<link href='main.css' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META NAME="robots" CONTENT="index">
<meta name="distribution" content="Global">
<meta name="rating" content="General">
<meta name="author" content="TPS Services Ltd">
<META NAME="revisit" CONTENT="30 days">
<meta http-equiv="Expires" CONTENT="-1">
<script language='javascript' src='scripts/menus.js'></script>
<script language="javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script langauge='javascript' src="scripts/pages.js"></script>
<script langauge='javascript' src="scripts/checks.js"></script>
</head>
<body>
<div class='my'>
TPS Services Limited Exam Centre
</div>
<center>
<div id='header'></div>
<div id='menu' align='left'></div>
<div id='subHeader'>
	<div id=subheadertext class='titles' align='center'>
<?php 
	include 'pages/subheader.php';
?>
	</div>
</div>
<?php
	if ( $page == "start" ) {
		$_SESSION["Message"]=null;
		include 'pages/start.php';
	}
	if ( $page == "pw" ) {
		include 'pages/password.php';
	}
	if ( $page == "users") {
		include 'pages/users.php';
	}
	if ( $page == "questions" ) {
		include 'pages/questions.php';
	}
	if ( $page == "tests" ) {
		include 'pages/tests.php';
	}
?>

<div id='footer'></div>
</center>
<script>$('#header').load('header.htm');</script>
<?php if ( isset($_SESSION["loggedin"]) ): ?>
<script>$('#menu').load('menu.php');</script>
<?php else: ?>
<script>$('#menu').load('menu2.htm');</script>
<?php endif; ?>
<script>$('#footer').load('footer.htm');</script>
</body>
</html>
