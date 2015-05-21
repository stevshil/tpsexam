function showPage(str,toDo) {
    if (str.length == 0) {
        document.getElementById("mainbody").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            //if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            if (xmlhttp.readyState == 4 ) {
                document.getElementById("mainbody").innerHTML = xmlhttp.responseText;
		document.doAction.action=toDo;
            }
        }
        xmlhttp.open("GET", "pages/"+str, true);
        xmlhttp.send(null);
    }
}

function getURLParameter(name) {
	return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
}

function changeSize(elementToChange, newSize) {
	document.getElementById(elementToChange).style.height = newSize;
}
