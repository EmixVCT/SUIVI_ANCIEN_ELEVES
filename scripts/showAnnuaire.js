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
/*FONCTION QUI MET A LECOUTE*/
function addListenerMulti(el, s, fn) {
	s.split(' ').forEach(e => el.addEventListener(e, fn, false));
}

/*AFFICHE LA TABLE TRIER*/
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


/* FONCTIONS DE SUPPRESSION */
function supprimerLig(id,cond,tab){
	entete = "id="+id; 
	entete += "&cond="+cond;
	entete += "&tab=" +tab; 
	
	xhrConf = new XMLHttpRequest();
	xhrConf.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("modifEtu").innerHTML = this.responseText;
			var elmnt = document.getElementById("modifEtu");
			elmnt.scrollIntoView();
		}
	};
	xhrConf.open("POST","scripts/php/confirmation.php",true);
	xhrConf.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrConf.send(entete);	
}
function ValiderSupprimerLig(id,cond,tab){
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

/* FONCTIONS DE MODIFICATION */
function modifierEtu(id){
	entete = "id="+id; 
	
	xhrMod = new XMLHttpRequest();
	xhrMod.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {

			document.getElementById("modifEtu").innerHTML = this.responseText;
			var elmnt = document.getElementById("modifEtu");
			elmnt.scrollIntoView();
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
			informationEtu(id);
		}
	};

	xhrMod.open("POST","scripts/php/modifEtu.php",true);
	xhrMod.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrMod.send(entete);
	
}

/* FONCTIONS D'AJOUT */
function ajoutEtu(){
	xhrAdd = new XMLHttpRequest();
	xhrAdd.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("modifEtu").innerHTML = this.responseText;
			var elmnt = document.getElementById("modifEtu");
			elmnt.scrollIntoView();
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

function ajoutEtuCsv(){
	xhrAddCsv = new XMLHttpRequest();
	xhrAddCsv.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("modifEtu").innerHTML = this.responseText;
			var elmnt = document.getElementById("modifEtu");
			elmnt.scrollIntoView();
		}
	};

	xhrAddCsv.open("POST","scripts/php/addEtuCsv.php",true);
	xhrAddCsv.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrAddCsv.send();
}

function validerImportation(){
	elemFormA = document.getElementsByName("ajouterCsv")[0];
	file_accept = ["application/vnd.ms-excel","csv"];
	
	formData = new FormData();	
	valide = false
	for (i=0;i != elemFormA.length;i++){
		if (elemFormA[i].value != null){
			if (elemFormA[i].name == "file" && !empty(elemFormA[i].value)){

				for(var y = 0; y < file_accept.length; y++) {
					if(elemFormA[i].files[0].type === file_accept[y]) {
						formData.append("OK","OK");
						formData.append(elemFormA[i].name,elemFormA[i].files[0]);
						valide = true;
					}
				}
				if (!valide){
					//mauvais format de fichier
					formData.append("NON","NON");
				}
			}else if(elemFormA[i].name == "entete_input" && !elemFormA[i].checked){
				continue;
			}else{
				formData.append(elemFormA[i].name,elemFormA[i].value);
			}
		}
	}
	
	xhrAddCsv = new XMLHttpRequest();
	xhrAddCsv.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("modifEtu").innerHTML = this.responseText;
			var elmnt = document.getElementById("modifEtu");
			elmnt.scrollIntoView();
		}
	};
	
	console.log(formData);
	xhrAddCsv.open("POST","scripts/php/addEtuCsv.php",true);
	xhrAddCsv.send(formData);	
}

/* FONCTIONS D'AFFICHAGE */
function informationEtu(id){
	entete = "id="+id; 
	
	xhrInf = new XMLHttpRequest();
	xhrInf.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {

			document.getElementById("modifEtu").innerHTML = this.responseText;
			var elmnt = document.getElementById("modifEtu");
			elmnt.scrollIntoView();
			}
	};

	xhrInf.open("POST","scripts/php/getInfoEtu.php",true);
	xhrInf.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrInf.send(entete);
}

function clearZone(){
	document.getElementById("modifEtu").innerHTML = "";
	var elmnt = document.getElementById("table");
	elmnt.scrollIntoView();
}


/* FONCTIONS TECHNIQUE */
function empty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}