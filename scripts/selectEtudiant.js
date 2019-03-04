function selectAll(ch) {
	var tab = document.getElementsByTagName("input"); 
	for (var i = 0; i < tab.length; i++) { 
		if (tab[i].type == "checkbox")
			tab[i].checked = ch.checked;
	}
}
