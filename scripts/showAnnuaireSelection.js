window.onload = initPage;


function initPage(){
	var searchInput = document.getElementById("input_forma");
	addListenerMulti(searchInput, "change keydown paste input",function (event) {show_table_trie_selection();} );

	var searchInput = document.getElementById("input_nom");
	addListenerMulti(searchInput, "change keydown paste input",function (event) {show_table_trie_selection();} );

	var searchInput = document.getElementById("input_prenom");
	addListenerMulti(searchInput, "change keydown paste input",function (event) {show_table_trie_selection();} );

	var searchInput = document.getElementById("input_promo");
	addListenerMulti(searchInput, "change keydown paste input",function (event) {show_table_trie_selection();} );
	
	document.getElementById("EtuSansPoursuite").onchange = show_table_trie_selection;

	document.getElementById("trie").onchange = show_table_trie_selection;
	show_table_trie_selection();
}

function addListenerMulti(el, s, fn) {
	s.split(' ').forEach(e => el.addEventListener(e, fn, false));
}

function show_table_trie_selection(){
	xhrAfficher = new XMLHttpRequest();
	xhrAfficher.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("table").innerHTML = this.responseText;
		}
	};
	
	stringSend = "";
	elemForm = document.getElementsByName("formulaire")[0];
	
	for (i=0;i != elemForm.length;i++){
		if (elemForm[i].value != null){
			stringSend += elemForm[i].name + "=" + elemForm[i].value;
			if (i != elemForm.length-1){
				stringSend += "&";
			}
		}
	}
	if (document.getElementById("EtuSansPoursuite").checked == true){
		stringSend += "&check=ok";
	}
	
	
	console.log(stringSend);	
	xhrAfficher.open("POST","scripts/php/getAnnuaireTrieSelection.php",true);
	xhrAfficher.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrAfficher.send(stringSend);
}



