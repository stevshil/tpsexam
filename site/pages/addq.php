<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();

	if ( isset($_POST['action2']) && $_POST['action2'] == 'add' ) {
		#echo "Q: " . $_POST['question'] . "<br>A: " . $_POST['answer1'] . " : " . $_POST['correct1'] . "<br>";
		include '../api/addquestion.php';
		header('Refresh:10; url=/exam/index.php?page=questions');
		echo "Question added";
		die;
	}
?>
<script>
function addAnswerBoxes(numBoxes) {
	// Add the header to tick box if correct answer
	//document.getElementById('tickme').style.display = 'block';
	$(".tickme").show();

	var container = document.getElementById('answergrid');
	// Clear container
        while ( container.hasChildNodes() ) {
                container.removeChild(container.lastChild);
        }
	
	// Add the question boxes
	for ( x = 1; x <= numBoxes; x++ ) {
		var newdiv = document.createElement('tr');
		newdiv.innerHTML = '<td>Answer ' + x + ': </td><td> <input type="text" name="answer' + x + '" size="60"> &nbsp; <input type="checkbox" name="correct' + x + '"></td></tr>'
		container.appendChild(newdiv);
	}
}

function addAnswers() {
	var str="";
	try {
		var elems = document.getElementsByTagName('input');
		for ( i = 0; i < elems.length; i++ ) {
			if ( elems.item(i).type == 'checkbox' ) {
				if ( elems[i].checked == true ) {
					document.getElementById('addq').appendChild(elems.item(i));
				}
			} else if ( elems.item(i).type == 'text' ) {
				document.getElementById('addq').appendChild(elems.item(i));
			}
		}
	} catch(e) {
		alert(e.message);
	}
	document.getElementById('addq').submit();
	return false
}
</script>
<table align='center'>
<form id='addq' name='addq' action='pages/addq.php?action=add' method='post' onSubmit='return addAnswers()'>
<input type='hidden' name='action2' value='add'>
<tr><td valign='top' align='right'>Question:</td><td><textarea name='question' rows=4 cols='95'></textarea></td></tr>
<tr><td colspan='2'>
<table>
<tr><td align='right' valign='top'>Category Type:</td><td><select name='CategoryID[]' multiple size=3><?php
	$listItem=dbquery("CatID,CategoryName","categories",null);
	foreach ( $listItem as &$data ) {
		echo "<option value='" . $data['CatID'] ."'>" . $data['CategoryName'] . "</option>";
	}
?></select>
</td><td width='50'> </td>
<td align='right'>Number of answers:</td><td><select name='numans' onChange='addAnswerBoxes(this.options[this.selectedIndex].value)'>
<option value='Choose' selected>---Choose one---</option>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
</select></td></tr>
</table></td></tr>
<tr><td> </td><td class='tickme' align='right' style='display: none'>Tick if correct answer</td></tr>
<table id='answergrid'></table>
</td></tr>
<tr><td colspan='2'><input type='submit' class='tickme' value='Add question' style='display: none'> <input type='reset' class='tickme' value='Clear form' style='display: none'>
</form>
</table>
