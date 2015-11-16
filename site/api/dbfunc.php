<?php
function dbconnect() {
	$servername = "localhost";
	$username = "TPSADMIN";
	$password = "TPSPASSWORD";
	$dbname = "tpsexam";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_TIMEOUT,3600);
	}
	catch(PDOException $e) {
		$conn = "An error occurred, please contact the developer or administrator";
	}

	return $conn;
}

function injectionChk($sql) {
	$illegalsql='/;/';
	if ( preg_match($illegalsql,$sql) ) {
		return 1;	# Injection SQL found
	} else {
		return 0;	# All OK
	}
}

function dbquery($inputparams, $tables, $conditions) {
	$data = Array();

	if ( injectionChk($inputparams) || injectionChk($tables) || injectionChk($conditions) ) {
		return "Illegal SQL found";
	}

	$conn=dbconnect();
	if ( $conn == "string" ) {
		if ( preg_match('/An error occurred/', $conn) ) {
			return "Database connection failed";
		}
	}

	if ( $tables == null && $conditions == null ) {
		$statement = $conn->prepare("SELECT $inputparams");
	} else {
		$statement = $conn->prepare("SELECT $inputparams FROM $tables $conditions");
	}
	#echo "SELECT $inputparams FROM $tables $conditions<br><br>";
	#echo "<option>SELECT $inputparams FROM $tables $conditions</option>";
	$statement->execute();
	$data = $statement->fetchAll(PDO::FETCH_ASSOC);
	$statement = null;
	$conn = null;
	return $data;
}

function dbupdate($table,$columns,$condition) {
	$data = Array();

	if ( injectionChk($table) || injectionChk($columns) || injectionChk($condition) ) {
		return "Illegal SQL found";
	}
	
	$conn=dbconnect();

	if ( $conn == "string" ) {
		if ( preg_match('/An error occurred/', $conn) ) {
			return "Database connection failed";
		}
	}

	#echo "UPDATE $table SET $columns $condition<br><br>";
	$statement = $conn->prepare("UPDATE $table SET $columns $condition");
	try {
		if ( $statement->execute() ) {
			return true;
		} else {
			return false;
		}
	} catch (PDOException $e) {
		echo $e->getMessage()."<br>";
		return false;
	}
}

function dbinsert($table,$columns,$values) {
	if ( injectionChk($table) || injectionChk($columns) || injectionChk($values) ) {
		return "Illegal SQL found";
	}

	$conn=dbconnect();

	if ( $conn == "string" ) {
		if ( preg_match('/An error occurred/', $conn) ) {
			return "Database connection failed";
		}
	}

	$statement = $conn->prepare("INSERT INTO $table ($columns) VALUES($values)");
	try {
		if ( $statement->execute() ) {
			return true;
		} else {
			return false;
		}
	} catch (PDOException $e) {
		return false;
	}
}

function dbdel($table,$condition) {
	if ( injectionChk($table) || injectionChk($condition) ) {
		return "Illegal SQL found";
	}

	if ( empty($table) || empty($condition) ) {
		return "No table or condition supplied";
	}

	$conn=dbconnect();

	if ( $conn == "string" ) {
		if ( preg_match('/An error occurred/', $conn) ) {
			return "Database connection failed";
		}
	}

	$statement = $conn->prepare("DELETE FROM $table $condition");
	try {
		if ( $statement->execute() ) {
			return true;
		} else {
			return false;
		}
	} catch (PDOException $e) {
		return false;
	}
}
?>
