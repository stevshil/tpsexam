<?php
	set_include_path(get_include_path() . ':' . getcwd() . "/api");
	include "dbfunc.php";

	#$d = dbquery("FullName","users","");
	$d = dbquery("FullName","users","");

	if ( gettype($d) == "array" ) {
		echo $d[0]['FullName'];
	} else {
		echo $d;
	}

	$d=dbquery(" password('admin') = ( SELECT Password FROM users,shadow WHERE LoginID='Admin' AND users.UserID = shadow.UserID) As Result",null,null);
	echo $d[0]['Result'];
?>
