window.onload = initPage;


function initPage(){
	var searchInput = document.getElementById("input_forma");
	addListenerMulti(searchInput, "change keydown paste input",function (event) {show_table_trie();} );

	var searchInput = document.getElementById("input_nom");
	addListenerMulti(searchInput, "change keydown paste input",function (event) {show_table_trie();} );

	var searchInput = document.getElementById("input_prenom");
	addListenerMulti(searchInput, "change keydown paste input",function (event) {show_table_trie();} );

	var searchInput = document.getElementById("input_promo");
	addListenerMulti(searchInput, "change keydown paste input",function (event) {show_table_trie();} );
	
	
	document.getElementById("trie").onchange = show_table_trie;
	show_table_trie();
}

function addListenerMulti(el, s, fn) {
	s.split(' ').forEach(e => el.addEventListener(e, fn, false));
}

function show_table_trie(){
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
		
	xhrAfficher.open("POST","scripts/php/getAnnuaireTrie.php",true);
	xhrAfficher.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrAfficher.send(stringSend);
}

function supprimerLig(id,cond,tab){
	entete = "id="+id; 
	entete += "&cond="+cond;
	entete += "&tab=" +tab; 
	
	xhrSupp = new XMLHttpRequest();
	xhrSupp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("modifEtu").innerHTML = this.responseText;
			show_table_trie();
		}
	};
	
	xhrSupp.open("POST","scripts/php/suppLigneTable.php",true);
	xhrSupp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrSupp.send(entete);
	
}


function modifierEtu(id){
	entete = "id="+id; 
	
	xhrMod = new XMLHttpRequest();
	xhrMod.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("modifEtu").innerHTML = this.responseText;
		}
	};

	xhrMod.open("POST","scripts/php/modifEtu.php",true);
	xhrMod.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrMod.send(entete);
}


function validerModif(id){
	entete = "OK=OK&id="+id+"&";

	elemFormM = document.getElementsByName("modification")[0];
	
	for (i=0;i != elemFormM.length;i++){
		if (elemFormM[i].value != null){
			entete += elemFormM[i].name + "=" + elemFormM[i].value;
			if (i != elemFormM.length-1){
				entete += "&";
			}
		}
	}
	
	xhrMod = new XMLHttpRequest();
	xhrMod.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("modifEtu").innerHTML = this.responseText;
			show_table_trie();
		}
	};

	xhrMod.open("POST","scripts/php/modifEtu.php",true);
	xhrMod.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrMod.send(entete);
	
}

function ajoutEtu(){
	xhrAdd = new XMLHttpRequest();
	xhrAdd.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("modifEtu").innerHTML = this.responseText;
		}
	};

	xhrAdd.open("POST","scripts/php/addEtu.php",true);
	xhrAdd.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrAdd.send();
}


function validerAjout(){
	entete = "";
	complet = "OK";
	elemFormA = document.getElementsByName("ajouter")[0];
	
	for (i=0;i != elemFormA.length;i++){
		if (elemFormA[i].value != null){
			entete += elemFormA[i].name + "=" + elemFormA[i].value;
			if (i != elemFormA.length-1){
				entete += "&";
			}
			//Si le champ est obligatoire
			if ((elemFormA[i].name == "nom") || (elemFormA[i].name == "prenom") || (elemFormA[i].name == "formation")){
				if (empty(elemFormA[i].value)){ //test si il est vide
					complet = "NA"; //bloque l'ajout dans l'annuaire
				}
			}
		}
	}
	entete += "&OK="+complet;
	
	xhrAdd = new XMLHttpRequest();
	xhrAdd.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("modifEtu").innerHTML = this.responseText;
			show_table_trie();
		}
	};
	console.log(entete);

	xhrAdd.open("POST","scripts/php/addEtu.php",true);
	xhrAdd.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrAdd.send(entete);
	
}



function empty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}