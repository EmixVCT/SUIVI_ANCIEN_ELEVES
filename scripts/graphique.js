window.onload = initPage;


function initPage(){
	document.getElementById("donus_affichage").onchange = donuts;
	
	document.getElementById("bar_affichage").onchange = bar;

	donuts();
	bar();
}

function donuts(){

	xhrDOnuts = new XMLHttpRequest();
	
	xhrDOnuts.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var arr = xhrDOnuts.responseText.split(',');
			show_donuts(arr);
			document.getElementById("phraseDonuts").innerHTML = arr[6];

		}
	};
	
	stringSend = "";
	elemForm = document.getElementById("donus_affichage").options;
	for (i=0;i != elemForm.length;i++){
		if (elemForm[i].selected){
			stringSend += "donuts=" + elemForm[i].value;
		}
	}
			
	xhrDOnuts.open("POST","scripts/php/getDonneeDonuts.php",true);
	xhrDOnuts.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrDOnuts.send(stringSend);

}
function bar(){

	xhrBar = new XMLHttpRequest();
	
	xhrBar.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var arr = xhrBar.responseText.split(';');
			for(i = 0;i<arr.length;i++){
				arr[i] = arr[i].split(",");
			}
			show_bar(arr);
			document.getElementById("phraseBar").innerHTML = arr[2][0];
		}
	};
	
	stringSend = "";
	elemForm = document.getElementById("bar_affichage").options;
	for (i=0;i != elemForm.length;i++){
		if (elemForm[i].selected){
			stringSend += "bar=" + elemForm[i].value;
		}
	}
			
	xhrBar.open("POST","scripts/php/getDonneeBar.php",true);
	xhrBar.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhrBar.send(stringSend);

}

function show_donuts(lst){
		
	var ctxD = document.getElementById("doughnutChart").getContext('2d');
	
	if (typeof myLineChart !== 'undefined'){
		resetCHart(myLineChart);
	}	
	
	myLineChart = new Chart(ctxD, {
			type: 'doughnut',
			data: {
				labels: ["École d'ingenieur", "Miage", "L3", "Licence professionnelle", "Bachelor","Autre"],
				datasets: [{
					data: [lst[0], lst[1], lst[2], lst[3], lst[4],lst[5]],
					backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1","#FF5500","#4D5360"],
					hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5","#FF6622", "#616774"]
					}]
				},
			options: {
				responsive: true
			}
		});
}

function show_bar(lst){
	
	console.log(lst[0]);
	console.log(lst[1]);
	
	var ctxB = document.getElementById("barChart").getContext('2d');
	
	if (typeof myBarChart !== 'undefined'){
		resetCHart(myBarChart);
	}
	
	myBarChart = new Chart(ctxB, {
	type: 'bar',
	data: {
	  labels: lst[1],
	  datasets: [{
		label: '# étudiants inscrit a l\'annuaire',
		data: lst[0],
		backgroundColor: [
		  'rgba(255, 99, 132, 0.2)',
		  'rgba(54, 162, 235, 0.2)',
		  'rgba(255, 206, 86, 0.2)',
		  'rgba(75, 192, 192, 0.2)',
		  'rgba(153, 102, 255, 0.2)',
		  'rgba(255, 159, 64, 0.2)'
		],
		borderColor: [
		  'rgba(255,99,132,1)',
		  'rgba(54, 162, 235, 1)',
		  'rgba(255, 206, 86, 1)',
		  'rgba(75, 192, 192, 1)',
		  'rgba(153, 102, 255, 1)',
		  'rgba(255, 159, 64, 1)'
		],
		borderWidth: 1
	  }]
	},
	options: {
	  scales: {
		yAxes: [{
		  ticks: {
			beginAtZero: true
		  }
		}]
	  }
	}
	});
	
	
}

function resetCHart(chart){
	chart.destroy();
}

