<?php

	include 'includes.php';
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
	$datafile=file_get_contents("quicktest/allquestions/Linux.json");
	$json=json_decode($datafile);
	#var_dump(json_decode($json));
	foreach ($json as $key => $value) {
		echo "$key<br>";
	}
?>

<div id='footer'></div>
</center>
<script>$('#header').load('header.htm');</script>
<script>$('#menu').load('quickmenu.php');</script>
<script>$('#footer').load('footer.htm');</script>
</body>
</html>
