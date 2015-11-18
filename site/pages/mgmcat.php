<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();
?>

<form name='chuser' action='index.php'>
<?php if ( $_SESSION["loggedin"] == "yes" && isset($_SESSION["UserID"]) ): ?>
<table width=100%>
<tr><td align=left valign=top width=50%>
<h2>Add Category</h2>
<form name='AddCat' action=''>
<input type=text size=30 name=category> <input type=submit value='Add Category'>
</form>
<h2>Delete Category</h2>
<form name='DelCat' action=''>
<table><tr><td>
<select name=CategoryID[] multiple>
</select>
<td><td>
<input type=submit value='Delete Category'>
</td></tr></table>
</td><td align=left valign=top width=50%>
<h2>Change Category</h2>
<form name='ChangeCat' action=''>
<table><tr><td>
<select name=CategoryID[] multiple size=8>
</select>
</td><td>
<input type=submit value='Change Category'>
</td></tr></table>
</form>
</td></tr>
<?php else: ?>
	You are not logged in to the system
<?php endif; ?>

