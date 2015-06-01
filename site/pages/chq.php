<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();

	if ( isset($_POST['action2']) && $_POST['action2'] == 'chgForm' && $_SESSION
["loggedin"] == "yes" ) {
		# Perform the action
	}

	# Provide the list of available questions and filter with category
	function qList($CID=null) {
		if ( isset($CID) ) {
			$questionsData = dbquery("questions.QID,Question,AID,Correct,AnswerText,CategoryID,CategoryName","questions,answers,questionCategory,categories","WHERE questions.QID=answers.QID and questions.QID=questionCategory.QID and questionCategory.CategoryID=categories.CatID AND questionCategory.CategoryID=" . $CID . " GROUP BY QID");
		} else { 
			$questionsData = dbquery("questions.QID,Question,AID,Correct,AnswerText,CategoryID,CategoryName","questions,answers,questionCategory,categories","WHERE questions.QID=answers.QID and questions.QID=questionCategory.QID and questionCategory.CategoryID=categories.CatID GROUP BY QID");
		}
		return $questionsData;
	}

	function catList() {
		$catList = dbquery("CatID,CategoryName","categories",null);
		return $catList;
	}

	# Provide question change form
	function chqForm() {
	}

	# Change the questions data
	function chqData() {
	}
?>

<script>
	function filterCat(chosen) {
		for ( i = 0; i < chosen.length; i++ ) {
			if ( chosen[i].selected ) {
				location.href='<?php echo $_SERVER['REQUEST_URI']; ?>&CID=' + chosen[i].value;
			}
		}
	}
</script>

<?php if ( ! isset($_POST['action2']) ) : ?>
<form name='selectQuestion' action='/exam/index.php?page=questions&action=change'>
<input type='hidden' name='action2' value='chgForm'>
<table width='80%'>
<tr><td>Select a Question</td><td>Filter by Category</td></tr>
<tr><td><select name='QID' onChange='submit()'>
<option value=''>--- Please select question ---</option>
<?php
	if ( isset($_GET['CID']) ) {
		$data = qList($_GET['CID']);
	} else {
		$data=qList();
	}
	for ( $item = 0; $item < count($data); $item++ ) {
		echo "<option value='" . $data[$item]['QID'] . "'";
		if ( isset($_POST['QID']) && $_POST['QID'] == $data[$item]['QID']) {
			echo " selected ";
		}
		echo ">" . $data[$item]['Question'] . "</option>";
	}
?>
</select></td><td>
<select name='CID' onChange='filterCat(this.options)' >
<option value=''>--- Please select question ---</option>
<?php
	$cList=catList();
	for ( $item = 0; $item < count($cList); $item++ ) {
		echo "<option value='" . $cList[$item]['CatID'] . "'";
		if ( isset($_GET['CID']) && $_GET['CID'] == $cList[$item]['CatID'] ) {
			echo " selected ";
		}
		echo ">" . $cList[$item]['CategoryName'] . "</option>";
	}
?>
</select>
</td></tr>
</table>
</form>
<?php endif; ?>

<?php if ( isset($_POST['action2']) ) : ?>

<?php endif; ?>
