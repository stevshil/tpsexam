<?php
	include 'dbfunc.php';

	if ( isset($_SESSION['UserID']) ) {
		$UserID=$_SESSION['UserID'];
	} else {
		header("Location: exam/index.php?action2=chgForm&page=questions&action=change&QID=" . $_POST['QID'] );
	}

	# Get form data
	$QID = $_POST['QID'];
	$question = $_POST['question'];
	$AIDs = $_POST['AID'];
	$Cats = $_POST['Category'];

	echo "QID: $QID - $question<br>";
	for ($counter=0; $counter < count(AIDs); $counter++ ) {
		echo "AID: $AIDs[$counter];
	}

	$question=str_replace("'","''",$question);
	#if ( dbupdate("question","Question","WHERE QID=$QID") {
		# Update the categories
		#for 
	#}

	#true/false=dbupdate($table,$columns,$condition);
?>
