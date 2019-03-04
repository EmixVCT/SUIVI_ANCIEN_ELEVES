window.onload = initPage;


function initPage(){
	xhrAfficher = new XMLHttpRequest();
	xhrAfficher.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("table").innerHTML = this.responseText;
		}
	};
	
	document.getElementById("tables").onchange = show_table;
	show_table();
}


function show_table(){
	nomTable = "";
	nomTable += "tb=" +document.getElementById("tables").value; 
	
	console.log(nomTable);
	
	xhrAfficher.open("POST","scripts/php/getTable.php",true);
	xhrAfficher.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrAfficher.send(nomTable);
}
