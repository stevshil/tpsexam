<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();
?>

<form name='lockuser' action='pages/lockuser.php'>
<?php if ( $_SESSION["loggedin"] == "yes" && isset($_SESSION["UserID"]) ): ?>
	<?php if ( ! isset($_GET['action2']) ) : ?>
	<input type='hidden' name='action2' value='lock'>
	Select user(s) to lock account for:<br><br>
	<select name='users[]' multiple size=12>
	<?php
		try {
			if ( $_SESSION['loginname'] == 'Admin' ) {
				$userlist = dbquery("users.UserID,LoginID,FullName,Locked","users,shadow","WHERE users.UserID=shadow.UserID AND (Locked is null OR Locked = '0') AND users.UserID != 1");
			} else {
                                $userlist = dbquery("users.UserID,LoginID,FullName,Locked","users,shadow","WHERE users.UserID=shadow.UserID AND (Locked is null OR Locked = '0') AND users.UserID != 1 AND users.LoginID = '" .$_SESSION['loginname'] . "'");
                        }

		} catch (Exception $e) {
			echo "<OPTION>Error: " . $e->getMessage() . "</OPTION>";
		}
		for ( $counter = 0; $counter < count($userlist); $counter++ ) {
			echo "<option value='" . $userlist[$counter]['UserID'] . "'>" . $userlist[$counter]['LoginID'] . " : " . $userlist[$counter]['FullName'] . "</option>";
		}
	?>
	</select><br><br>
	<input type='submit' name='lock' value='Lock user(s)'>
	<?php endif; ?>
	<?php if ( isset($_GET['action2']) ) {
		include '../api/dbfunc.php';
		$uid = $_GET['users']; # Note this is an array
		for ( $counter = 0; $counter < count($uid); $counter++ ) {
			dbupdate("shadow","Locked=1","WHERE UserID=" . $uid[$counter]);
			#echo "UPDATE users SET Inactive=1 WHERE UserID=" . $uid[$counter];
			header("Refresh:0; url=/exam/index.php?page=users&action=lock");

		}
	}
	?>
<?php else: ?>
	You are not logged in to the system
<?php endif; ?>
