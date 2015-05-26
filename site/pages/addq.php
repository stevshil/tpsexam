<?php
	if ( session_status() != PHP_SESSION_ACTIVE )
		session_start();
?>
<script>
function addAnswerBoxes(numBoxes) {
	var container = document.getElementById("answergrid");

	// Add the header to tick box if correct answer
	//document.getElementById('tickme').style.display = 'block';
	$(".tickme").show();
	
	// Clear container
	while ( container.hasChildNodes() ) {
		container.removeChild(container.lastChild);
	}

	// Add the question boxes
	for ( x = 1; x <= numBoxes; x++ ) {
		var ans = document.createElement("input");
		var cor = document.createElement("input");
		ans.type='text';
		ans.name='answer' + x;
		ans.size=60;
		cor.type='checkbox';
		cor.name='correct' + x;
		var row = document.createElement("tr");
		var cell = document.createElement("td");
		cell.appendChild(document.createTextNode("Answer " + x + ": "));
		row.appendChild(cell);
		container.appendChild(row);

		var cell2 = document.createElement("td");
		cell2.appendChild(container.appendChild(ans));
		cell2.appendChild(container.appendChild(cor));
		row.appendChild(cell2);
		container.appendChild(row);
	}
}
</script>
<table align='center'>
<form name='addq' action='pages/addq.php?action=add' method='post'>
<tr><td valign='top' align='right'>Question:</td><td><textarea name='question' rows=4 cols='95'></textarea></td></tr>
<tr><td colspan='2'>
<table>
<tr><td align='right' valign='top'>Category Type:</td><td><select name='CategoryID' multiple size=3><?php
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
<tr><td colspan='2'><input type='submit' class='tickme' value='Add question' style='display: none'> <input type='reset' class='tickme' value='Clear form' style='display: none'>
</form>
</table>
