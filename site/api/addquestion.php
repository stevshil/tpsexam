<?php
	include 'dbfunc.php';
	function writeQuestionsAndAnswers($question,$category,$answers) {
		if ( isset($_SESSION['UserID']) ) {
			$UserID=$_SESSION['UserID'];
		} else {
			$UserID=1;
		}
		if ( dbinsert('questions','Question,Added,AddedBy',"'$question',Now(),$UserID") ) {
			# Add the category
			$qid=dbquery('QID','questions'," WHERE Question='$question'");
			# Split the categories as they are comma seperated
			$cats=explode(",",$category); # Breaks line into array
			foreach ( $cats as &$cat ) {
				dbinsert('questionCategory','QID,CategoryID',$qid[0]['QID'] . ",$cat");
			}
			# If question inserts ok, insert the answers
			for ( $counter=0; $counter <= (count($answers)-1); $counter+=2 ) {
				$correct=$counter+1;
				if ( ! dbinsert('answers','AID,QID,Correct,AnswerText,Added,AddedBy',"'" . $qid[0]['QID'] . "-$counter'," . $qid[0]['QID'] . ",'" . chop($answers[$correct]) . "','" . $answers[$counter] . "',Now(),$UserID") ) {
					echo "DB insert failed to do\n";
					echo "INSERT INTO answers (QID,Correct,AnswerText,Added,AddedBy) VALUES(" . $qid[0]['QID'] . ",'" . chop($answers[$correct]) . "','" . $answers[$counter] . "',Now(),$UserID)\n";
				}
			}
		}
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
		while ( isset($_POST[$numAnswers]) ) {
			array_push($answers, $_POST[$numAnswers],"$correctAnswers");
			$counter++;
			$numAnswers = "answer" . $counter;
			$correctAnswer = "correct" . $counter;
		}
		#writeQuestionsAndAnswers($questions,$category,$answers);
		echo "Data passed is:<br>";
		echo "Question: " . $question . "<br>";
		echo "Categories: " . $category . "<br>";
		echo "Answers: " . count($answers) . "<br>";
	} else {
		# blulk load cmdline
		$dataFile = fopen($argv[1],"r") or die("Unable to open file!");
		while ( ! feof($dataFile) ) {
			$dataRead = fgets($dataFile);
			if ( ! preg_match('/\!/', $dataRead) ) {
				$writeData=1;
			}
			# File format: Question!category!answer1!correct!answer2!correct!answer...!correct...
			$fields=explode("!",$dataRead); # Breaks line into array
			$questions=array_shift($fields);
			$category=array_shift($fields);
			for ( $counter = 0; $counter < (count($fields)-1) ; $counter+=2 ) {
				array_push($answers, $fields[$counter],$fields[$counter+1]);
			}
			if ( ! isset($writeData) ) {
				writeQuestionsAndAnswers($questions,$category,$answers);
			}
		}
		$writeData=null;
		fclose($dataFile);
	}

?>
