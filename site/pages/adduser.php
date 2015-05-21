<?php
	function redo() {
		# Add session variables so page reloads with data
		$_SESSION['newLoginID'] = $_POST['LoginID'];
		$_SESSION['newCompanyName'] = $_POST['CompanyName'];
		$_SESSION['newFullName'] = $_POST['FullName'];
		$_SESSION['newAddress1'] = $_POST['Address1'];
		$_SESSION['newAddress2'] = $_POST['Address2'];
		$_SESSION['newAddress3'] = $_POST['Address3'];
		$_SESSION['newTownCity'] = $_POST['TownCity'];
		$_SESSION['newCounty'] = $_POST['County'];
		$_SESSION['newCountry'] = $_POST['Country'];
		$_SESSION['newPostcode'] = $_POST['Postcode'];
		$_SESSION['newPhone'] = $_POST['Phone'];
		$_SESSION['newEmail'] = $_POST['Email'];
		if ( isset($_POST['Admin']) )
			$_SESSION['newAdmin'] = $_POST['Admin'];
		header("Refresh:5; url=/exam/index.php?page=users&action=add", true, 303);
	}

	function clearData() {
		$_SESSION['newLoginID'] = null;
		$_SESSION['newCompanyName'] = null;
		$_SESSION['newFullName'] = null;
		$_SESSION['newAddress1'] = null;
		$_SESSION['newAddress2'] = null;
		$_SESSION['newAddress3'] = null;
		$_SESSION['newTownCity'] = null;
		$_SESSION['newCounty'] = null;
		$_SESSION['newCountry'] = null;
		$_SESSION['newPostcode'] = null;
		$_SESSION['newPhone'] = null;
		$_SESSION['newEmail'] = null;
		if ( isset($_POST['Admin']) )
			$_SESSION['newAdmin'] = null;
		header("Refresh:5; url=/exam/index.php?page=users", true, 303);
	}


	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();

	if ( isset($_POST['action2']) && $_POST['action2'] == 'adding' ) {
		# Check that the important pieces are not empty
		if ( preg_match('/^[ 	]*$/',$_POST['LoginID']) || preg_match('/^[ 	]*$/',$_POST['FullName']) || preg_match('/^[ 	]*$/',$_POST['Country']) || preg_match('/^[ 	]*$/',$_POST['Postcode']) || preg_match('/^[ 	]*$/',$_POST['Email']) ) {
			# Return to input page
			redo();
			die;
		}
		# Check valid Emial address
		if ( ! preg_match('/^\\w+(\\.\\w+)*@\\w+\\.\\w+(\\.\\w+)*$/', $_POST['Email']) ) {
			redo();
			die;
		}

		# Perform DB add here, and any error messages
		set_include_path(get_include_path() . ":/home/web-apps/tps-exam/site");
		include 'api/dbfunc.php';
		try { 
			$data = dbquery("LoginID,Email,Postcode","users","WHERE LoginID='" . $_POST['LoginID'] . "'");
			if ( isset($data[0]) ) {
				if ( $data[0]['LoginID'] == $_POST['LoginID'] ) {
					redo();
					die();
				}
				$newuser=1;
			}
		} catch ( Exception $e ) {
			$newuser=1;
		}

		#echo "Adding new user " . $_POST['LoginID'];
		$fieldsArray=array("LoginID","CompanyName","FullName","Address1","Address2","Address3","TownCity","County","Country","Postcode","Phone","Email","Admin");
		foreach ($fieldsArray as &$field) {
			if ( isset($_POST[$field]) ) {
				#echo $field . " : " . $_POST[$field] . "<br>";
				if ( $_POST[$field] != "" ) {
					if ( isset($fields) ) {
						$fields=$fields . ",$field";
						if ( $field == "Admin" ) {
							$values=$values . ",'1'";
						} else {
							$values=$values . ",'" . $_POST[$field] ."'";
						}
					} else {
						$fields=$field;
						$values="'" . $_POST[$field] . "'";
					}
				}
			}
		}

		#echo "dbinsert('users',$fields,$values)";
		# Add the date and added by values
		$fields=$fields . ",AddedDate,AddedBy";
		$values=$values . ",Now(),". $_SESSION['UserID'];
		
		if ( dbinsert("users",$fields,$values) ) {
			clearData();
			die;
		} else {
			if ( isset($_POST['LoginID']) ) {
				$_SESSION['reason']="User " . $_POST['LoginID'] . "already exists";
			}
			redo();
			die();
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
<form name='adduser' action='pages/adduser.php?action=add' method='post' onsubmit='return doChecks()'>
<input type='hidden' name='action2' value='adding'>
<tr><td><font style='color:red'>Username:</font></td><td><input type='text' name='LoginID' <?php if ( isset($_SESSION['newLoginID']) )
		echo "value='" . $_SESSION['newLoginID'] . "'" ?> ></td></tr>
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
<tr><td colspan=2><input type=submit value='Add User'> &nbsp; <input type=reset value='Clear fields'></td></tr>
</form>
</table>
</td></tr>
</table>
<p></p>
<div id='messages'><?php if ( isset($_SESSION['message']) )
	echo $_SESSION['message'] ?></div>
