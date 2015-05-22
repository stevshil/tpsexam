<?php
	include 'api/dbfunc.php';
	session_start();
	$data=dbquery("Admin","users","WHERE UserID='" . $_SESSION['UserID'] . "'");
	$data=dbquery("Admin","users","WHERE LoginID='Admin'");
	if ( gettype($data != "array" ) ) {
                echo "";
        }

?>
<table style='cursor: pointer'><tr>
<td class='menu' id='home' onMouseOver='menuTimeout()' onClick='location.href="index.php"'>Home</td>
<td class='menu' id='Admin' onMouseOver='showMenu("Admin")'>Admin</td>
<td class='menu' id='Test' onMouseOver='showMenu("Test")'>Take Test</td>
<td class='menu' id='History' onMouseOver='menuTimeout()' onClick='location.href="history.php"'>Your Test History</td>
<td class='menu' id='Logout' onMouseOver='menuTimeout()' onClick='location.href="logout.php"'>Logout</td>
</tr></table>
<div id='Adminmenu' onMouseOut='showMenu("Admin")'>
<a class='menu' href='index.php?page=pw'>Change Password</a><br>
<?php if ( $data[0]['Admin'] == 1 ) : ?>
<a class='menu' href='index.php?page=users'>Manage Users</a><br>
<a class='menu' href='index.php?page=questions'>Add Questions</a><br>
<a class='menu' href='index.php'>Create Test</a><br>
<a class='menu' href='index.php'>Assign Test Takers</a><br>
<a class='menu' href='index.php'>Add Categories</a>
<?php endif; 
$data = null;
?>
</div>
<div id='Testmenu' onMouseOut='showMenu("Test")'>
<a class='menu' href='index.php'>Select Test</a><br>
<a class='menu' href='index.php'>Resume Test</a><br>
<a class='menu' href='index.php'>Retake Test</a><br>
</div>
