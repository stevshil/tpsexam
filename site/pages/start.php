<div id='mainbody'>
	<div id='topGrid'>
		<?php if ( ! isset ($_SESSION["loggedin"]) ): ?>
			<table>
			<form name=login action='logon.php' method=post>
				<tr><td>Username:</td><td><input type=text name=loginid></td></tr>
				<tr><td>Password:</td><td><input type=password name=passwd></td></tr>
				<tr><td colspan=2 align='center'><input type=submit value='Login' onClick='sendForm()'></td></tr>
			</form>
			</table>
		<?php else: ?>
		<div align='justify'>This is the TPS Services Ltd Exam Centre system, used for providing graduate training programs, apprenticeships and courses with exam style questions.  The system allows you to;
		<ul>
		<li>Record and view student marks
		<li>Define questions and answers
		<li>Create tests and assign students
		</ul>
		Choose actions from the menu above.
		</div>
	</div>
	<div id='btmGrid'>
	<div align='right'><?php if ( isset($_SESSION['LastLogon']) ) {
		echo "Last login: " . $_SESSION['LastLogon'];
} ?>
		<?php endif; ?>
	</div>
</div>
