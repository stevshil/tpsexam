<?php
if ( session_status() != PHP_SESSION_ACTIVE )
	session_start();


include '../api/dbfunc.php';

if ( isset($_SESSION['UserID']) ) {
        $UserID=$_SESSION['UserID'];
} else {
        header("location:javascript://history.go(-1)");
        exit;
}

$QID=$_POST['QID'];

echo "Deleting question $QID ";

# Delete answers
echo ".";
if ( dbdel("answers","WHERE QID=$QID") ) {
	echo ".";
	# Delete questionCategory
	if ( dbdel("questionCategory","WHERE QID=$QID") ) {
		echo ".<br>";
		if ( dbdel("questions","WHERE QID=$QID") ) {
			echo "Question $QID has been deleted<br>";
		} else {
			echo "Failed to delete question $QID, but have deleted questionCategory and answers<br>";
		}
	} else {
		echo "<br>Failed to delete questionCategory and question, but have deleted answers for $QID<br>";
	}
} else {
	echo "<br>Deletion of question failed<br>";
}

header("Refresh:3; url=/exam/index.php?page=questions&action=delete");

?>
