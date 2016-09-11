<script>
	pagetype=getURLParameter('page');
	if ( pagetype == 'pw' ) {
		showtext="Change your own password";
	} else if ( pagetype == 'users' ) {
		subparam = getURLParameter('action');
		if ( subparam == 'add' ) {
			showtext = "Add new user to the system";
		} else if ( subparam == 'change' ) {
			showtext = "Change a users settings";
		} else if ( subparam == 'lock' ) {
			showtext = "Lock the user account";
		} else if ( subparam == 'pwreset' ) {
			showtext = "Change the users password";
		} else {
			showtext = "User administration";
		}
	} else if ( pagetype == 'questions' ) {
		subparam = getURLParameter('action');
		if ( subparam == 'cat' ) {
			showtext = 'Manage categories';
		} else if ( subparam == 'add' ) {
			showtext = 'Add a new question';
		} else if ( subparam == 'change' ) {
			showtext = 'Change a question';
		} else if ( subparam == 'delete' ) {
			showtext = 'Delete question';
		} else {
			showtext = 'Question administration';
		}
        } else if ( pagetype == 'qt' ) {
		showtext = 'Create Quick Test';
	} else {
		showtext="Welcome to Exam Centre";
	}
	document.getElementById('subheadertext').innerHTML = showtext;
</script>
