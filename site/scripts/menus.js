function showMenu(btnID)
{
	var menus = new Array('Adminmenu','Testmenu');
	btnID=btnID+'menu';
	for ( x in menus )
	{
		if ( btnID != menus[x] )
			document.getElementById(menus[x]).style.display = 'none';
	}
	if ( document.getElementById(btnID).style.display == 'block' )
	{
		document.getElementById(btnID).style.display='none';
	} else {
		document.getElementById(btnID).style.display='block';
	}

}

function validSelect(theForm)
{
        if ( theForm.to.value == 0 )
        {
                alert('Please select an area of interest so that we can direct your Email correctly\nThank you');
                return false;
        }

        var fields=new Array('sender','user','Subject','msg');
        for (x in fields)
        {
                field = eval('theForm.'+fields[x]+'.value');
                if ( field.match(/^ *$/) )
                {
                        alert('You cannot leave '+fields[x]+' empty.');
                        field=eval('theForm.'+fields[x]);
                        field.focus();
                        return false;
                }
        }
}

function menuTimeout() {
	var menus = new Array('Adminmenu','Testmenu');
	for ( x in menus )
		document.getElementById(menus[x]).style.display = 'none';
}
