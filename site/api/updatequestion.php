<?php

if ( session_status() != PHP_SESSION_ACTIVE )
	session_start();
echo "Session started<br>";

include 'dbfunc.php';

if ( isset($_SESSION['UserID']) ) {
	$UserID=$_SESSION['UserID'];
} else {
	#header("Location: exam/index.php?action2=chgForm&page=questions&action=change&QID=" . $_POST['QID'] );
	header("location:javascript://history.go(-1)");
	exit;
}

echo "Getting data<br>";

# Get form data
$QID = $_POST['QID'];
$question = $_POST['question'];
$AIDs = $_POST['AID'];
$Cats = $_POST['Category'];
$question=str_replace("'","''",$question);

echo "About to update question $QID - $question<br>";
if ( dbupdate("questions","Question='$question'","WHERE QID=$QID") ) {
	echo "Question updated<br>";
	# Update the categories, delete all first and add new
	if ( dbdel("questionCategory","WHERE QID=" . $QID) ) {
		# Add the new categories
		echo "Updating categories<br>";
		for ( $counter = 0; $counter < count($Cats); $counter++ ) {
			if ( ! dbinsert("questionCategory","QID,CategoryID","$QID," . $Cats[$counter]) ) {
				echo "Failed to insert category for $QID: " . $Cats[$counter];
			}
		}
		# Update answers
		for ( $counter = 0; $counter < count($AIDs); $counter++ ) {
			$answer="answer" . $AIDs[$counter];
			$correct="correct" . $AIDs[$counter];
			$newanswer=str_replace("'","''",$_POST[$answer]);
			if ( isset($_POST[$correct]) ) {
				$correct=1;
			} else {
				$correct=0;
			}
			if ( ! dbupdate("answers","AnswerText='$newanswer',Correct='$correct'","WHERE AID='" . $AIDs[$counter] . "'") ) {
				echo "Failed to update answers";
			}
		}
	}
}

header("Refresh:3; url=/exam/index.php?page=questions&action=change");

?>
