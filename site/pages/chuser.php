<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();
?>

<form name='chuser' action='index.php'>
<?php if ( $_SESSION["loggedin"] == "yes" && isset($_SESSION["UserID"]) ): ?>
	<input type='hidden' name='action' value='changeuser'>
	<input type='hidden' name='page' value='users'>
	Select user(s) to change details for:<br><br>
	<select name='users' size=12>
	<?php
		try {
			$userlist = dbquery("users.UserID,LoginID,FullName,Locked","users,shadow","WHERE users.UserID=shadow.UserID AND (Locked is null OR Locked = '0') AND users.UserID != 1");
		} catch (Exception $e) {
			echo "<OPTION>Error: " . $e->getMessage() . "</OPTION>";
		}
		for ( $counter = 0; $counter < count($userlist); $counter++ ) {
			echo "<option value='" . $userlist[$counter]['UserID'] . "'>" . $userlist[$counter]['LoginID'] . " : " . $userlist[$counter]['FullName'] . "</option>";
		}
	?>
	</select><br><br>
	<button type='submit'>Change user</button>
<?php else: ?>
	You are not logged in to the system
<?php endif; ?>
