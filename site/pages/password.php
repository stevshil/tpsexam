<?php
	set_include_path(get_include_path() . ":/home/web-apps/tps-exam/site");
	include 'api/dbfunc.php';
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();

	$data=dbquery("Admin","users","WHERE UserID='" . $_SESSION['UserID'] . "'");
	if ( $data[0]['Admin'] == 1 ) {
		$adminuser = 1;
	} else {
		$adminuser = 0;
	}

	if ( isset($_POST['action']) && $_POST['action'] == 'change' ) {
		if ( isset($_POST['current']) ) {
			$passwd=$_POST['current'];
		}
		$new1=$_POST['new1'];
		$new2=$_POST['new2'];
		if ( isset($_POST['pwname']) ) {
			$loginid = dbquery("UserID","users","WHERE LoginID='" . $_POST['pwname'] . "'");
			$loginname = (string)$loginid[0]['UserID'];
		} else {
			$loginname=$_SESSION['loginname'];
		}
		# Only required if not an Admin account
		if ( $adminuser != 1 || ! isset($_POST['pwname']) ) {
			if ( isset($new1) && $new1 != $passwd && $new1 == $new2 && ! isset($_POST['pwname']) ) {
				$data = dbquery("password('$passwd') = (Select Password FROM users,shadow WHERE LoginID='$loginname' AND users.UserID = shadow.UserID) As Result",null,null);
				if ( $data[0]['Result'] == 1 ) {
					if ( dbupdate("shadow","Password=password('$new1')","WHERE UserID=" . $_SESSION['UserID']) ) {
					header("Location: /exam/index.php?page=start");
					die;
					}
				}
			}
		}
		if ( isset($new1) && $new1 == $new2 && $adminuser == 1 ) {
			echo $loginname;
			#$data = dbquery("UserID","users","WHERE LoginID='" . $loginname . "'");
			if ( dbupdate("shadow","Password=password('$new1')","WHERE UserID=$loginname" ) ) {
				header("Location: /exam/index.php?page=start");
				die;
			}
		}
		header("Location: /exam/index.php?page=pw");
	}
?>
<div id='mainbody'>
	<?php if ( $_SESSION["loggedin"] == "yes" ): ?>
	<div id='topGrid'>
			<table>
			<form name='passwordForm' action='pages/password.php' method='post' onSubmit="return chkPassword()">
				<input type=hidden name=action value=change>
				<?php   $pwchanger="";
					if ( isset($_GET['pwname']) ) {
					if ( $adminuser != 1 ) {
						$pwchanger="";
					} else {
						$pwchanger=$_GET['pwname'];
					}
				}
				if ( $pwchanger != "" ) : ?>
				<tr><td>Change password for</td><td><b><?php echo $pwchanger ?></b></td></tr>
				<input type=hidden name=pwname value=<?php echo $pwchanger ?> >
				<?php endif; ?>
				<?php if ( $adminuser != 1 || ! isset($_GET['pwname'])) : ?>
				<tr><td>Current Password</td><td><input type=password name=current></td></tr>
				<?php endif; ?>
				<tr><td>New Password:</td><td><input type=password name=new1></td></tr>
				<tr><td>Again Password:</td><td><input type=password name=new2></td></tr>
				<tr><td colspan=2 align='center'><input type='submit' value='Change' onClick='sendForm()'> &nbsp; <input type='reset' value='Clear'></td></tr>
			</form>
			</table>
		<?php else: ?>
			<div>Page unavailable</div>
	</div>
	<div id='btmGrid'>
	<div align='right'><?php echo "Last login: " . $_SESSION['LastLogon'] ?>
	</div>
	<?php endif; ?>
</div>
