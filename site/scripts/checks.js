function chkPassword() {
	// Check that the new and current passwords are not the same
	if ( document.passwordForm.current.value == document.passwordForm.new1.value ) {
		alert("New password is the same as the old password!");
		document.passwordForm.new1.focus();
		return false;
	}
	
	// Check that the new password is typed correctly
	if ( document.passwordForm.new1.value != document.passwordForm.new2.value ) {
		alert("New passwords do not match!");
		document.passwordForm.new1.focus();
		return false;
	}
	return true;
}

function checkRequired(field,regex) {
	var str=field;
	var re=new RegExp(regex,"gi");
	if ( field.search(re) > -1 ) {
		// Pattern was matched
		return true;
	} else {
		return false;
	}
}
