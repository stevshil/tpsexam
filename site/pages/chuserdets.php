<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();

	$users=$_GET['users'];
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
	$data = dbquery("*", "users", "WHERE LoginID='" . $users . "'");
?>
<form name='adduser' action='pages/chuserdets.php?action=update' method='post' onsubmit='return doChecks()'>
<input type='hidden' name='action2' value='update'>
<tr><td><font style='color:red'>Username:</font></td><td><input type='text' name='LoginID' <?php if ( isset($_SESSION['newLoginID']) )
		echo "value='" . $_SESSION['newLoginID'] . "'" 
	#else
		#echo "value='" . $data['LoginID']
	?> ></td></tr>
<tr><td>Company Name:</td><td><input type='text' name='CompanyName' <?php if ( isset($_SESSION['newCompanyName']) )
		echo "value='" . $_SESSION['newCompanyName'] . "'" ?> ></td></tr>
<tr><td><font style='color:red'>Persons Name:</font></td><td><input type='text' name='FullName' <?php if ( isset($_SESSION['newFullName']) )
		echo "value='" . $_SESSION['newFullName'] . "'" ?> ></td></tr>
<tr><td valign='top'>Address:</td><td><input type='text' name='Address1' <?php if ( isset($_SESSION['newAddress1']) )
			echo "value='" . $_SESSION['newAddress1'] . "'" ?>><br>
<input type='text' name='Address2' <?php if ( isset($_SESSION['newAddress2']) )
		echo "value='" . $_SESSION['newAddress2'] . "'" ?> ><br>
<input type='text' name='Address3' <?php if ( isset($_SESSION['newAddress3']) )
		echo "value='" . $_SESSION['newAddress3'] . "'" ?> ></td></tr>
<tr><td>Town or City:</td><td><input type='text' name='TownCity' <?php if ( isset($_SESSION['newTownCity']) )
		echo "value='" . $_SESSION['newTownCity'] . "'" ?> ></td></tr>
<tr><td>County or State:</td><td><input type='text' name='County' <?php if ( isset($_SESSION['newCounty']) )
		echo "value='" . $_SESSION['newCounty'] . "'" ?> ></td></tr>
<tr><td><font style='color:red'>Country</font></td><td><input type='text' name='Country' <?php if ( isset($_SESSION['newCountry']) )
		echo "value='" . $_SESSION['newCountry'] . "'" ?>></td></tr>
<tr><td><font style='color:red'>Postcode or Zip:</font></td><td><input type='text' name='Postcode' <?php if ( isset($_SESSION['newPostcode']) )
		echo "value='" . $_SESSION['newPostcode'] . "'" ?> ></td></tr>
</table>
</td><td valign=top>
<table>
<tr><td>Telephone:</td><td><input type=text name='Phone' <?php if ( isset($_SESSION['newPhone']) )
		echo "value='" . $_SESSION['newPhone'] . "'" ?> ></td></tr>
<tr><td><font style='color:red'>Email:</font></td><td><input type=text name='Email' <?php if ( isset($_SESSION['newEmail']) )
		echo "value='" . $_SESSION['newEmail'] . "'" ?> ></td></tr>
<tr><td>Administrator:</td><td><input type=checkbox name='Admin' <?php if ( isset($_SESSION['newAdmin']) )
		echo "value='" . $_SESSION['newAdmin'] . "'" ?> ></td></tr>
<tr><td colspan=2 align=center><input type=submit value='Change User'></td></tr>
</form>
</table>
</td></tr>
</table>
<p></p>
<div id='messages'><?php if ( isset($_SESSION['message']) )
	echo $_SESSION['message'] ?></div>
