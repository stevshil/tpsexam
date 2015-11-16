<?php
	if ( ! isset($_GET['users']) && $_GET['action'] != 'update' ) { 
		header("Refresh:0; url=/exam/index.php?page=users&action=change");
		exit(0);
	}

	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();

	if ( isset($_GET['users']) ) {
		$users=$_GET['users'];
	}

	if ( isset($_GET['action']) ) {
		if ( $_GET['action'] == 'update' ) {
			$updateStr="";
			echo "Writing to database<br>";
			foreach ( $_POST as $key => $value ) {
				if ( $key == 'action2' ) {
					continue;
				}
				if ( $key == 'UserID' ) {
					continue;
				} elseif ( $value != "" ) {
					$updateStr.="$key='$value',";
				} else {
					continue;
				}
			}
			$updateStr=trim($updateStr,",");
			include '../api/dbfunc.php';
			if ( dbupdate("users","$updateStr"," WHERE UserID=".$_POST['UserID']) ) {
				echo $_POST['UserID']." data updated";
				#echo "<br>SQL Statement: UPDATE users SET $updateStr WHERE UserID=".$_POST['UserID'];
				header("Refresh:2; url=/exam/index.php?page=users&action=change");
			} else {
				echo "<br>Data not updated";
				#echo "<br>SQL Statement: UPDATE users SET $updateStr WEHRE UserID=".$_POST['UserID'];
				header("Refresh:0; url=/exam/index.php?action=changeuser&page=users&users=".$_POST['UserID']);
			}
			exit(0);
		}
	}
?>
<script>
function doChecks() {
	if ( checkRequired(document.adduser.LoginID.value,'^[ 	]*$') || checkRequired(document.adduser.FullName.value,'^[ 	]*$') || checkRequired(document.adduser.Country.value,'^[ 	]*$') || checkRequired(document.adduser.Postcode.value,'^[ 	]*$') || checkRequired(document.adduser.Email.value,'^[ 	]*$') ) {
		document.getElementById('messages').innerHTML = "Please check that you have entered all compulsory values";
		return false;
	}

	if ( checkRequired(document.adduser.Email.value,'^\\w+(\\.\\w+)*@\\w+\\.\\w+(\\.\\w+)*$') == false ) {
		document.getElementById('messages').innerHTML = "Please enter a valid Email address";
		return false;
	}

	return true;
}
</script>
<table align=center>
<tr><td valign=top>
<table>
<?php # Get user info from DB
	$data = dbquery("*", "users", "WHERE UserID='" . $users . "'");
?>
<form name='adduser' action='pages/chuserdets.php?action=update' method='post' onsubmit='return doChecks()'>
<input type='hidden' name='action2' value='update'>
<input type='hidden' name='UserID' value='<?php echo $users ?>'>
<tr><td><font style='color:red'>Username:</font></td><td><input type='text' name='LoginID' <?php echo "value='" . $data[0]['LoginID'] . "'" ?> ></td></tr>
<tr><td>Company Name:</td><td><input type='text' name='CompanyName' <?php if ( isset($data[0]['CompanyName']) )
		echo "value='" . $data[0]['CompanyName'] . "'" ?> ></td></tr>
<tr><td><font style='color:red'>Persons Name:</font></td><td><input type='text' name='FullName' <?php if ( isset($data[0]['FullName']) )
		echo "value='" . $data[0]['FullName'] . "'" ?> ></td></tr>
<tr><td valign='top'>Address:</td><td><input type='text' name='Address1' <?php if ( isset($data[0]['Address1']) )
			echo "value='" . $data[0]['Address1'] . "'" ?>><br>
<input type='text' name='Address2' <?php if ( isset($data[0]['Address2']) )
		echo "value='" . $data[0]['Address2'] . "'" ?> ><br>
<input type='text' name='Address3' <?php if ( isset($data[0]['Address3']) )
		echo "value='" . $data[0]['Address3'] . "'" ?> ></td></tr>
<tr><td>Town or City:</td><td><input type='text' name='TownCity' <?php if ( isset($data[0]['TownCity']) )
		echo "value='" . $data[0]['TownCity'] . "'" ?> ></td></tr>
<tr><td>County or State:</td><td><input type='text' name='County' <?php if ( isset($data[0]['County']) )
		echo "value='" . $data[0]['County'] . "'" ?> ></td></tr>
<tr><td><font style='color:red'>Country</font></td><td><input type='text' name='Country' <?php if ( isset($data[0]['Country']) )
		echo "value='" . $data[0]['Country'] . "'" ?>></td></tr>
<tr><td><font style='color:red'>Postcode or Zip:</font></td><td><input type='text' name='Postcode' <?php if ( isset($data[0]['Postcode']) )
		echo "value='" . $data[0]['Postcode'] . "'" ?> ></td></tr>
</table>
</td><td valign=top>
<table>
<tr><td>Telephone:</td><td><input type=text name='Phone' <?php if ( isset($data[0]['Phone']) )
		echo "value='" . $data[0]['Phone'] . "'" ?> ></td></tr>
<tr><td><font style='color:red'>Email:</font></td><td><input type=text name='Email' <?php if ( isset($data[0]['Email']) )
		echo "value='" . $data[0]['Email'] . "'" ?> ></td></tr>
<tr><td>Administrator:</td><td><input type=checkbox name='Admin' <?php if ( isset($data[0]['Admin']) )
		echo "value='" . $data[0]['Admin'] . "'" ?> ></td></tr>
<tr><td colspan=2 align=center><input type=submit value='Change User'></td></tr>
</form>
</table>
</td></tr>
</table>
<p></p>
<div id='messages'><?php if ( isset($_SESSION['message']) )
	echo $_SESSION['message'] ?></div>
