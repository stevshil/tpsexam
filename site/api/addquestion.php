<?php
	function writeQuestionsAndAnswers() {
	}

	$websession=0;

	if ( PHP_SAPI != 'cli' ) {
		if ( session_status() != PHP_SESSION_ACTIVE )
			session_start();
		if ( $_SESSION["loggedin"] != "yes" ) {
			header("Location: /exam/index.php");
			die;
		}
		$websession=1;
	}

	# Set values if using web session
	$question="";
	$category="";
	$answers=array();
	if ( $websession == 1 ) {
		$question=$_POST["question"];
		$category=$_POST["CategoryID"];
		$counter=1;
		$numAnswers = "answer" . $counter;
		$correctAnswers = "correct" . $counter;
		while ( isset($_POST[$numAnswers] ) {
			array_push($answers, array($_POST[$numAnswers] => "$correct"));
			$counter++;
			$numAnswers = "answer" . $counter;
			$correctAnswer = "correct" . $counter;
		}
	} else {
		# blulk load cmdline
		$dataFile = fopen($argv[0],"r") or die("Unable ot open file!");
		while ( ! feof($dataFile) ) {
			$dataRead = fgets($dataFile);
			# File format: Question!category!answer1!correct!answer2!correct!answer...!correct...
			$fields=explode("!",$dataRead); # Breaks line into array
			$questions=$fields[0];
			$category=$fields[1];
			for ( $counter = 2; $counter <= count($fields); $counter++ ) {
				array_push($answers, array($fields[$counter],$fields[$counter+1]));
				$counter+=2;
			}
		}
		fclose($dataFile);
	}

?>
