<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();

	function qData($QID) {
		$questionsData = dbquery("questions.QID,Question,AID,Correct,AnswerText,CategoryID,CategoryName","questions,answers,questionCategory,categories","WHERE questions.QID=answers.QID and questions.QID=questionCategory.QID and questionCategory.CategoryID=categories.CatID AND questions.QID=" . $QID . " GROUP BY QID,AID");
		return $questionsData;
	}

	function qCategories($QID) {
		$categories = dbquery("QID,CategoryID,CategoryName","questionCategory,categories","WHERE CategoryID=CatID AND QID=" . $QID,null);
		return $categories;
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

<?php if ( ! isset($_GET['action2']) ) : ?>
<form name='selectQuestion' action='/exam/index.php'>
<input type='hidden' name='action2' value='chgForm'>
<input type='hidden' name='page' value='questions'>
<input type='hidden' name='action' value='change'>
<table width='80%'>
<tr><td>Select a Question</td><td>Filter by Category</td></tr>
<tr><td><select name='QID' onChange='submit()' size=15>
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
<select name='CID' onChange='filterCat(this.options)' size=15>
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

<?php if ( isset($_GET['action2']) ) : ?>
	<table align='center'>
	<form id='chq' name='chq' action='pages/updateQ.php' method='post'>
	<input type='hidden' name='QID' value='<?php echo $_GET['QID'] ?>'>
	<?php $qInfo=qData($_GET['QID']); ?>
	<tr><td valign='top' align='right'>Question:</td><td><textarea name='question' rows=4 cols='95'><?php echo $qInfo[0]['Question'] ?></textarea></td></tr>
	<tr><td>
	<?php for ( $counter = 0; $counter < count($qInfo); $counter++ ) : ?>
	<tr><td>Answer <?php echo $counter ?>: <input type='hidden' name='AID[]' value='<?php echo $qInfo[$counter]['AID'] ?>'></td><td><input type=text name='answer<?php echo $qInfo[$counter]['AID'] ?>' value='<?php echo $qInfo[$counter]['AnswerText'] ?>' size=80> <input type='checkbox' name='correct<?php echo $qInfo[$counter]['AID'] ?>' <?php if ( $qInfo[$counter]['Correct'] == 1 ) {
		echo "checked" ;
	} ?>></td></tr>
	<?php endfor; ?>
	</td></tr>
	</tr><td colspan=2><table>
	<tr><td valign=top>Categories:</td><td><select name='Category[]' size=5 multiple>
	<?php 
		$cats = qCategories($_GET['QID']);
		$allcats = catList();
		for ( $counter = 0; $counter < count($allcats); $counter++ ) {
			echo "<option value='" . $allcats[$counter]['CategoryID'] . "'";
			for ( $catcount = 0; $catcount < count($cats); $catcount++ ) {
				if ( $allcats[$counter]['CatID'] == $cats[$catcount]['CategoryID'] ) {
					echo " selected ";
				}
			}
			echo ">" . $allcats[$counter]['CategoryName'] . "</option>";
		}
	?>
	</select></td>
	<td width=300 align=center><input type='submit' name='update' value='Update Question'></td></tr>
	</table></td></tr>
	</form>
	</table>
<?php endif; ?>
