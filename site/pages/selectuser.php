<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();
?>

<form name='selectuser' action='index.php'>
<?php if ( $_SESSION["loggedin"] == "yes" && isset($_SESSION["UserID"]) ): ?>
	<input type='hidden' name='page' value='pw'>
	Select user to for password change:<br><br>
	<select name='pwname'>
	<option value='0'>Please select</option>
	<?php
		try {
			$userlist = dbquery("users.UserID,LoginID,FullName,Locked","users,shadow","WHERE users.UserID=shadow.UserID AND (Locked is null OR Locked = '0') AND users.UserID != 1");
		} catch (Exception $e) {
			echo "<OPTION>Error: " . $e->getMessage() . "</OPTION>";
		}
		for ( $counter = 0; $counter < count($userlist); $counter++ ) {
			echo "<option value='" . $userlist[$counter]['LoginID'] . "'>" . $userlist[$counter]['LoginID'] . " : " . $userlist[$counter]['FullName'] . "</option>";
		}
	?>
	</select><br><br>
	<input type='submit' name='selectuser' value='Change password'>
<?php else: ?>
	You are not logged in to the system
<?php endif; ?>
