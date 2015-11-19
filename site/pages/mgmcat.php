<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();

      	if ( file_exists("../api/dbfunc.php") ) {
               	require_once '../api/dbfunc.php';
       	} else {
               	require_once 'api/dbfunc.php';
       	}

	if ( $_POST['action'] == 'addCat' ) {
		echo "Adding Category ".$_POST['CategoryName']."<br>";
		$fields = "CategoryName,DateAdded,AddedBy";
		$values = "'".$_POST['CategoryName']."',Now(),".$_SESSION['UserID'];
		if ( dbinsert("categories","$fields","$values") ) {
			echo "Added ".$_POST['CategoryName']." to database";
			header("Refresh: 1; url=/exam/index.php?page=questions&action=cat");
			exit(0);
		} else {
			echo "Failed to add ".$_POST['CategoryName'];
			header("Refresh: 1; url=/exam/index.php?page=questions&action=cat");
			exit(1);
		}
	} 
	if ( $_POST['action'] == 'delCat' ) {
		$values="";
		foreach ($_POST['CategoryID'] as &$catID) {
			$values="$catID,$values";
		}
		$values=trim($values,",");
		echo "Deleting Category: $values<br>";
		if ( dbdel("categories","WHERE CatID in ($values)") ) {
			echo "Deleted categories: $values<br>";
			header("Refresh: 1; url=/exam/index.php?page=questions&action=cat");
			exit(0);
		} else {
			echo "Failed to delete categories: $values<br>";
			header("Refresh: 1; url=/exam/index.php?page=questions&action=cat");
			exit(1);
		}
	}
	if ( $_POST['action'] == 'changeCat' ) {
		echo "Changing Category";
	}
?>

<?php if ( $_SESSION["loggedin"] == "yes" && isset($_SESSION["UserID"]) ): ?>
<?php $catData = dbquery("CatID,CategoryName","categories",""); ?>
<table width=100%>
<tr><td align=left valign=top width=50%>
<h2>Add Category</h2>
<form name='AddCat' action='pages/mgmcat.php' method=post>
<input type=hidden name=action value=addCat>
<input type=text size=30 name=CategoryName> &nbsp;<input type=submit value='Add Category'>
</form>
<h2>Delete Category</h2>
<form name='DelCat' action='pages/mgmcat.php' method=post>
<input type=hidden name=action value=delCat>
<table><tr><td>
<select name=CategoryID[] multiple>
<option value='' selected>--- Please select category ---</option>
<?php
	for ( $counter = 0; $counter < count($catData); $counter++ ) {
		echo "<option value='" . $catData[$counter]['CatID'] . "'>" . $catData[$counter]['CategoryName'] . "</option>";
	}
?>
</select>
</form>
<td><td>
&nbsp;<input type=submit value='Delete Category'>
</td></tr></table>
</td><td align=left valign=top width=50%>
<h2>Change Category</h2>
<form name='ChangeCat' action='pages/mgmcat.php' method=post>
<input type=hidden name=action value=changeCat>
<table><tr><td>
<select name=CategoryID size=10>
<option value='' selected>--- Please select category ---</option>
<?php
	for ( $counter = 0; $counter < count($catData); $counter++ ) {
		echo "<option value='" . $catData[$counter]['CatID'] . "'>" . $catData[$counter]['CategoryName'] . "</option>";
	}
?>
</select>
</form>
</td><td>
<p>&nbsp;New name:<br>&nbsp;<input type=text size=30 name=CategoryName>
<p>&nbsp;<input type=submit value='Change Category'>
</td></tr></table>
</td></tr>
<?php else: ?>
	You are not logged in to the system
<?php endif; ?>

